<?php

namespace App\Admin\Controllers;

use App\Page;
use App\MailForm;
use Encore\Admin\Facades\Admin;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class MailFormController extends Controller
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
            ->header('Блок Почтовые формы на странице '.$this->page_name)
            ->description(' редактирование ')
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
        return $content
            ->header('Блок Почтовые формы на странице '.$this->page_name)
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
        return $content
            ->header('Блок Почтовые формы на странице '.$this->page_name)
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
        $grid = new Grid(new MailForm);

        $grid->model()->where('page_id', session('page_id'));

        $grid->name('Наименование')->display(function ($name) {
            return '<a href="/admin/mailform_fields?set='.$this->id.'">'.$name.'</a>';
        });
        $grid->fields('Полей ввода')->display(function ($fields) {
            $count = count($fields);
            return "<span class='label label-warning'>{$count}</span>";
        });


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
        $show = new Show(MailForm::findOrFail($id));



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new MailForm);

        $form->text('name', 'Наименование');
        $form->hidden('page_id')->value(session('page_id'));
        $form->hidden('page_block_id')->value(session('page_block_id'));
        $form->text('sender', 'Email ответсвенного получателя')->default(env('MAIL_FROM_ADDRESS'));
        $form->text('sender_name','Отправитель')->default(env('MAIL_FROM_NAME'));
        $form->textarea('signature', 'Подпись');

        $form->hasMany('fields', 'Поля ввода', function (Form\NestedForm $form) {
            $form->number('orders', 'Номер показа');
            $form->text('field_name', 'Наименование');
            $form->text('field_value', 'Описание поля');
        });


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
