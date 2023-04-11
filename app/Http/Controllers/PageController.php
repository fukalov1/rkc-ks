<?php

namespace App\Http\Controllers;
use App\Models\QuestBlock;
use Mail;
//use App\Models\CenterNew;
use App\Models\Page;
use App\Models\PageBlock;
use App\Models\Slider;
use App\Models\SliderItem;
use App\Models\Photoset;
use App\Models\MailForm;
use App\Models\Map;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public $bread_crubs;

    public function __construct(Page $page, PageBlock $pageBlock, Map $map, QuestBlock $questBlock,
                                Slider $slider, SliderItem $sliderItem, Photoset $photoset, MailForm $mailForm)
    {
        $this->page = $page;
        $this->pageBlock = $pageBlock;
        $this->questBlock = $questBlock;
//        $this->centerNew = $centerNew;
        $this->slider = $slider;
        $this->sliderItem = $sliderItem;
        $this->photoset = $photoset;
        $this->mailForm = $mailForm;
        $this->map = $map;
    }

    public function show(Page $page)
    {

//        dd($page);
        $template = 'page';
        $data = ['data' => $page];
        // Если главная страница
        if ($page->id == 1) {
            $template = 'main';
            $data = [
                'data' => $page
            ];
        }

//        print_r($page->toArray());
//
        //  баннера для зоны новостей
        $banners = $this->sliderItem->where('slider_id',4)->get();
//        dd($banners);
        $limit_news = 4;
        $limit_news = $limit_news - count($banners);

        $this->getBeadCrumbs($page->id);
        $data['pages'] = $this->page->getMenu();
        $data['directs'] = $this->page->where('number_direct','>', '0')->orderBy('number_direct')->get();
        $data['page_blocks'] = $this->pageBlock->where('page_id', $page->id)->orderBy('orders')->get();
        if ($page->id == 1) {
            $data['directs'] = $this->pageBlock
                ->orWhere('page_id', 6)
                ->orderBy('orders')->get();
        }
//        $data['center_news'] = $this->centerNew->orderBy('date', 'desc')->inRandomOrder()->limit($limit_news)->get();
        $data['banners'] = $banners;
        $data['bread_crumbs'] = '<a href="/">Главная</a> /'.$this->bread_crubs;

//        dd($page->getMenu());
//dd($template, $page->id,$data);
        return view($template, $data);
    }

    private function getBeadCrumbs($id)
    {
        $page = Page::find($id);
        $this->bread_crubs = " <a href='/{$page->url}'>".preg_replace('/\<br\/\>/','',$page->name)."</a> / ".$this->bread_crubs;

        if ($page->parent_id>0) {
            $this->getBeadCrumbs($page->parent_id);
        }
    }

    public function sendFormData($id)
    {
        if ($id) {


            try {
                $mailform = MailForm::find($id);
                $direction = request('direction');

                $data = [
                    'email' => request('email'),
                    'name' => request('name'),
                    'fio' => request('fio'),
                    'email' => request('email'),
                    'phone' => request('phone'),
                    'direction' => request('direction'),
                    'message' => request('message' . $id),
                    'to' => $mailform->sender
                ];

                Log::channel('sitelog')->info('Send mail from ' . request('email') . ' name: ' . request('fio') . ' ' . request('direction'));

                Mail::send('emails.sendform', ['data' => $data], function ($m) use ($data, $direction) {
                    $m->from(config('robot_email'), ' ', config('company_name'));

                    $m->to($data['to'], 'admin')->subject('Обратная связь. ' . $direction);
                });
                Log::channel('sitelog')->info('Send mail to '.$data['to'].' from '.config('email').' Data:'.json_encode($data));
                $data = ['result' => 'Спасибо за Ваше обращение. <br/><br/>Сообщение успешно отправлено администратору.<br/><br/> В ближайшее время Вы получите ответ.'];
            }
            catch (\Exception $error) {
                Log::channel('sitelog')->info('Error send mail from ' . request('email') . ' name: ' . request('fio') . ' ' . request('direction'));
            }
        }
        else {
            $data = ['result' => 'Данные не приняты'];
        }
        return json_encode($data);
    }

    public function sendQuestData($id)
    {
        if ($id) {

            $quest_block = $this->questBlock->find($id);

            $question = new Question();
            $question->quest_block_id = $id;
            $question->sort = 1;
            $question->hide = 1;
            $question->quest = request('message'.$id);
            $question->response = '';
            $question->email = request('email');
            $question->name = request('fio');
            $question->save();

            $data = [
                'email' => request('email'),
                'name' => request('name'),
                'message' => request('message'.$id),
                'to' => $quest_block->email,
                'page' => $quest_block->page->name,
                'id' => $question->id
            ];
            $data1 = $data;

            try {
                // Уведомление ответсвенному центра
                Mail::send('emails.sendform', ['data' => $data], function ($m) use ($data) {
                    $m->from(config('robot_email'), ' ', config('company_name'));
                    $m->to($data['to'], 'Администратору')->subject('Вопрос № '.$data['id'].' для центра трудовых ресурсов. Страница '.$data['page']);
                });
                Log::channel('sitelog')->info('Send to quest admin '.$data['to'].' from '.config('email').' Data:'.json_encode($data));
                // уведомлдение посетителю
                Mail::send('emails.sendform', ['data' => $data], function ($m) use ($data) {
                    $m->from(config('robot_email'), ' ', config('company_name'));
                    $m->to($data['email'], 'Посетителю')->subject('Вопрос № '.$data['id'].' c сайта. Страница '.$data['page']);
                });
                Log::channel('sitelog')->info('Send to quest notice '.$data['email'].' from '.config('email').' Data:'.json_encode($data));
                $data = ['result' => 'Спасибо, Ваше письмо № '.$question->id.' получено. <br/><br/> Ожидайте ответа в ближайшее время.'];
            }
            catch(\Exception $error) {
                Log::channel('sitelog')->info('Error '.$error->getMessage());
                return json_encode(['result' => 'Error send quest from '.config('robot_email').' '. $error->getMessage().' for data '.json_encode($data1)]);
            }


        }
        else {
            $data = ['result' => 'Данные не приняты'];
        }
        return json_encode($data);
    }


    public function searchPages(Request $request) {
        $word = $request['word'];
        if (isset($word)) {

            $data['pages'] = $this->page->getMenu();
            $data['bread_crumbs'] = '<a href="/">Главная</a> / Результат поиска по фразе: "'.$word.'"';

//            $result = collect([]);

//            $news = $this->centerNew
//                ->where('name','LIKE',"%$word%")
//                ->orWhere('anons','LIKE',"%$word%")
//                ->orWhere('text','LIKE',"%$word%")
//                ->paginate(10);

            $result = $this->page
                ->join('page_blocks','pages.id','page_blocks.page_id')
                ->where('pages.name','LIKE',"%$word%")
                ->orWhere('page_blocks.text','LIKE',"%$word%")->paginate(10);

            $data['result'] = $result;

            return view('search', $data);

        }
        else {
            redirect('/');
        }

    }

}
