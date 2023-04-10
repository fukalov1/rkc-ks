<?php

namespace App\Admin\Controllers;
use App\Page;
use App\QuestBlock;
use Encore\Admin\Facades\Admin;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class QuestBlockController extends Controller
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
            ->header('Блок вопросы-ответы на странице '.$this->page_name)
            ->description(' список вопросов')
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
        return $content
            ->header('Detail')
            ->description('description')
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
            ->header('Блок вопросы-ответы на странице '.$this->page_name)
            ->description(' редактирование ')
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
            ->header('Блок вопросы-ответы на странице '.$this->page_name)
            ->description(' добавление ')
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
        $grid = new Grid(new QuestBlock);
        $grid->model()->where('page_id', session('page_id'));

//        $grid->id('Id');
//        $grid->page_id('Page id');
//        $grid->page_block_id('Page block id');
//        $grid->sort('Sort');
        $grid->content('Список вопросов-ответов')->display(function () {
           return '<a href="/admin/questions?set='.$this->id.'">перейти</a>';
        });
        $grid->hide('Получение вопросов');
        $grid->email('Email ответственного');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

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
        $show = new Show(QuestBlock::findOrFail($id));


        $show->id('Id');
        $show->page_id('Page id');
        $show->page_block_id('Page block id');
        $show->sort('Sort');
        $show->hide('Hide');
        $show->email('Email');
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
        $form = new Form(new QuestBlock);

        $form->hidden('page_id')->value(session('page_id'));
        $form->hidden('page_block_id')->value(session('page_block_id'));
        $form->number('sort', 'Номер показа вопроса')->default(1);
        $form->switch('hide', 'Получать вопросы')->default(0);
        $form->email('email', 'Email ответственного')->default(env('MAIL_FROM_ADDRESS'));

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

}
