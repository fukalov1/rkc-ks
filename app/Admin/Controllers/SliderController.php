<?php

namespace App\Admin\Controllers;

use App\Page;
use App\Slider;
use Encore\Admin\Facades\Admin;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class SliderController extends Controller
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
            ->header('Блок Слайдеры на странице '.$this->page_name)
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
            ->header('Блок Слайдеры на странице '.$this->page_name)
            ->description(' просмотр ')
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
            ->header('Блок Слайдеры на странице '.$this->page_name)
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
            ->header('Блок Слайдеры на странице '.$this->page_name)
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
        $grid = new Grid(new Slider);
        $grid->model()->where('page_id', session('page_id'));

//        $grid->id('Id');
        $grid->name('Наименование');
        $grid->type('Type')->display(function ($type) {
            $str = 'Стандарт';
            if ($this->type == 2){
                $str = 'Модерн';
            }
            return $str;
        });
        $grid->items('Слайды')->display(function ($items) {
            $count = count($items);
            return "<a href='/admin/slider_items?set={$this->id}' title='перейти к слайдам'><span class='label label-warning'>{$count}</span></a>";
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
        $show = new Show(Slider::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->uid('Uid');
        $show->type('Type')->display(function ($type) {
            $str = 'Стандарт';
            if ($this->type == 2){
                $str = 'Модерн';
            }
            return $str;
        });

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
        $form = new Form(new Slider);

        $form->hidden('page_id')->value(session('page_id'));
        $form->hidden('page_block_id')->value(session('page_block_id'));
        $form->text('name', 'Наименование');
        $form->radio('type', 'Тип текстового блока')
            ->options([
                '1' => 'Стандарт',
                '2' => 'Модерн'
            ])->default('1');
        $form->hasMany('items', function (Form\NestedForm $form) {
                $form->number('orders', 'Номер показа');
                $form->text('title','Заголовок');
                $form->text('url','Ссылка на страницу');
                $form->textarea('text', 'Текст');
                $form->file('image', 'Картинка');
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
