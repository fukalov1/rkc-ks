<?php

namespace App\Admin\Controllers;
use App\Models\Page;
use App\Models\PageBlock;
use Encore\Admin\Facades\Admin;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use http\Env\Request;


class PageBlockController extends Controller
{
    use HasResourceActions;
    public $page_id=0;
    public $page_name = '';
    public $bread_crubs='';

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        $this->getHeader();
        $this->getBeadCrumbs(session('page_id'));
        if (Admin::user()->isAdministrator())
            $this->bread_crubs = '<a href="/admin/pages"> Структура сайта</a> / '.$this->bread_crubs;

        return $content
            ->header('Страница '.$this->page_name)
            ->description(' список текстовых блоков (абзацев)')
            ->body($this->bread_crubs )
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        $this->getHeader();
        return $content
            ->header('Страница '.$this->page_name)
            ->description(' список текстовых блоков (абзацев)')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        $this->getHeader();
        return $content
            ->header('Страница '.$this->page_name)
            ->description(' список текстовых блоков (абзацев)')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        $this->getHeader();
        return $content
            ->header('Страница '.$this->page_name)
            ->description(' список текстовых блоков (абзацев)')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PageBlock);
        $grid->model()->where('page_id',session('page_id'))->orderBy('orders');

//        $grid->id('Id');
//        $grid->page_id('Page id');
        $grid->orders('Номер показа')->editable();
//        $grid->header('Заголовок');
//        $grid->submenu('Пункт подменю')->display(function () {
//            $str = 'нет';
//            if ($this->submenu)
//                $str = 'да';
//            return $str;
//        });
        $grid->text('Текст')->display(function ($text) {
            return (\Illuminate\Support\Str::limit(strip_tags($text), 250, '...'));
//            return '<pre>'.substr($this->text,0,250).'</pre>';
        });
        $grid->question('Функционал')->display(function () {
            $str = '';
            if ($this->type==7) {
                $str = '<a href="/admin/sliders?set='.$this->id.'">слайдеры</a>';
            }
            elseif ($this->type==9) {
                $str = '<a href="/admin/photosets?set='.$this->id.'">фотогалерея</a>';
            }
            elseif ($this->type==10) {
                $str = '<a href="/admin/mailforms?set='.$this->id.'">почтовая форма</a>';
            }
            elseif ($this->type==11) {
                $str = '<a href="/admin/maps?set='.$this->id.'">карта</a>';
            }
            elseif ($this->type==12) {
                $str = '<a href="/admin/quest_blocks?set='.$this->id.'">вопросы-ответы</a>';
            }
            return $str;
        });
        $grid->content('Фото')->display(function ($image) {
            $link = '';
            if ($this->image) {
                $link = '<a href="javascript:removePhoto(\''.$this->id.'\')"  class="photo'.$this->id.'" title="удалить фото">x</a><img class="photo'.$this->id.'" src="/uploads/'.$this->image.'" style="width: 150px;padding:5px; ">';
            }
            return $link;
        });
//        $grid->created_at('Created at');
        $grid->updated_at('Обновлено');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(PageBlock::findOrFail($id));

        $show->id('Id');
        $show->page_id('Page id');
        $show->orders('Orders');
        $show->header('Header');
        $show->text('Text');
        $show->image('Image');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PageBlock);

        $form->select('type', 'Тип текстового блока')->options(function ($id) {
            $list = [
                '1' => 'Стандарт',
                '2' => 'С фото',
                '3'=> 'Промо-блок',
                '4'=> 'Список документов',
                '5'=> 'Список ссылок',
                '6'=> 'Список ссылок на PDF',
                '7'=> 'Слайдеры',
                '8'=> 'Блок во всю ширину',
                '9'=> 'Фотогалерея',
                '10'=> 'Почтовая форма',
                '11'=> 'Карта',
                '12'=> 'Вопросы-ответы'
                ];
            return $list;
        })->default(1);

        $form->hidden('page_id')->value(session('page_id'));
        $form->number('orders', 'Номер показа');
        $form->switch('submenu', 'Пункт подменю');
        $form->text('header', 'Заголовок')->default('');
        $form->ckeditor('text', 'Текст блока')
            ->options(
                [
                    'filebrowserBrowseUrl' =>  '/ckfinder/browser',
                    'filebrowserImageBrowseUrl' =>  '/ckfinder/browser',
                    'filebrowserUploadUrl' => '/ckfinder/browser?type=Files',
                    'filebrowserImageUploadUrl' => '/ckfinder/browser?command=QuickUpload&type=Images',
                    'language' => 'ru',
                    'height' => 500
                ])->default('-');
//        $form->myresizeimage('image', 'Фото');
        $form->image('image', 'Фото');

        return $form;
    }

    private function getHeader() {
        $page = Page::find(session('page_id'));
        if ($page) {
            $this->page_id = $page->id;
            $this->page_name = $page->name;
        }
        else {
            return redirect('/admin/pages');
        }
    }

    private function getBeadCrumbs($id)
    {
        $page = Page::find($id);
        $url = "/admin/sub_pages?set={$page->id}";
        if (!$page->relation)
            $url = "/admin/page_blocks?set={$page->id}";
        $this->bread_crubs = " <a href='$url'>".$page->name."</a> / ".$this->bread_crubs;

        if (($page->parent_id>0) and (Admin::user()->isAdministrator()) ) {
            $this->getBeadCrumbs($page->parent_id);
        }
    }

    public function removePhoto()
    {
        $id = \request('id');
        $page = PageBlock::find($id);
        $file = $page->image;
        if (file_exists(public_path('uploads/').$file))
            unlink(public_path('uploads/').$file);
        $page->update(['image' => '']);
        return json_encode(['result'=>'delete','id'=> $id]);
    }


}
