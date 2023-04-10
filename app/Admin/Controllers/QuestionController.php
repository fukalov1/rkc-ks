<?php

namespace App\Admin\Controllers;

use App\Question;
use App\Page;
use Encore\Admin\Facades\Admin;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class QuestionController extends Controller
{
    use HasResourceActions;
    public $page_id=0;
    public $page_name = '';
    public $quest_block_id = '';
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
            ->header('Вопросы ответы на странице '.$this->page_name)
            ->description(' список ')
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
        $this->getBeadCrumbs(session('page_id'));

        return $content
            ->header('Вопросы ответы на странице '.$this->page_name)
            ->description(' просмотр')
            ->body('<a href="/admin/pages"> Структура сайта</a> / '.$this->bread_crubs )
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
        $this->getBeadCrumbs(session('page_id'));

        return $content
            ->header('Вопросы ответы на странице '.$this->page_name)
            ->description(' редактирование')
            ->body('<a href="/admin/pages"> Структура сайта</a> / '.$this->bread_crubs )
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
        $this->getBeadCrumbs(session('page_id'));

        return $content
            ->header('Вопросы ответы на странице '.$this->page_name)
            ->description(' добавление')
            ->body('<a href="/admin/pages"> Структура сайта</a> / '.$this->bread_crubs )
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Question);

        $grid->model()->where('quest_block_id',session('quest_block_id'))->orderBy('created_at', 'desc');

        $grid->filter(function($filter){
            $filter->like('quest', 'Вопрос');
            $filter->like('response', 'Ответ');
//            $filter->equal('hide')->select(['0' => 'Только показанные','1' => 'Только скрытые']);
            $filter->in('type', 'Показать')->checkbox([
                '0'    => 'Все',
                '1'    => 'Типовые',
            ]);
            $filter->in('hide', 'Показать')->checkbox([
                '0'    => 'Активные',
                '1'    => 'Скрытые',
            ]);
        });

        $grid->id('№ вопроса');
        $grid->quest('Вопрос');
        $grid->response('Ответ');
        $grid->type('Скрыт');
        $grid->hide('Скрыт');
        $grid->sort('Номер показа')->editable();

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
        $show = new Show(Question::findOrFail($id));

        $show->id('Id');
        $show->hidden('quest_block_id')->value('quest_block_id');
        $show->block_order('');
        $show->sort('Sort');
        $show->hide('Hide');
        $show->quest('Quest');
        $show->response('Response');
        $show->email('Email');
        $show->name('Name');
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
        $form = new Form(new Question);

        $form->hidden('quest_block_id')->value(session('quest_block_id'));
        $form->number('sort', 'Номер показа вопроса')->default(1);
        $form->switch('type', 'Типовой')->default(0);
        $form->switch('hide', 'Скрыт')->default(1);
        $form->textarea('quest', 'Вопрос');
        $form->ckeditor('response', 'Ответ')
            ->options(
                [
                    'filebrowserBrowseUrl' =>  '/ckfinder/browser',
                    'filebrowserImageBrowseUrl' =>  '/ckfinder/browser',
                    'filebrowserUploadUrl' => '/ckfinder/browser?type=Files',
                    'filebrowserImageUploadUrl' => '/ckfinder/browser?command=QuickUpload&type=Images',
                    'language' => 'ru',
                    'height' => 200
                ])->default('-');
        $form->email('email', 'E-mail');
        $form->text('name', 'Отправитель');

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
        $this->bread_crubs = " <a href='/admin/sub_pages?set={$page->id}'>".$page->name."</a> / ".$this->bread_crubs;

        if (($page->parent_id>0) and (Admin::user()->isAdministrator()) ) {
            $this->getBeadCrumbs($page->parent_id);
        }
    }

}
