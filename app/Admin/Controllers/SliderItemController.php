<?php

namespace App\Admin\Controllers;

use App\Page;
use App\SliderItem;
use Encore\Admin\Facades\Admin;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class SliderItemController extends Controller
{
    use HasResourceActions;
    public $page_id=0;
    public $page_name = '';
    public $bread_crubs='';
    public $slider_id=0;
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
            ->header('Слайдеры на странице '.$this->page_name)
            ->description(' список ')
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
            ->header('Слайдеры на странице '.$this->page_name)
            ->description(' список ')
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
            ->header('Слайдеры на странице '.$this->page_name)
            ->description(' список ')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SliderItem);

        $grid->model()->where('slider_id', session('slider_id'));

//        $grid->id('Id');
//        $grid->slider_id('Slider id');
        $grid->title('Наименование');
        $grid->url('Ссылка');
        $grid->image('Изображение')->display(function () {
            return  '<img src="/uploads/'.$this->image.'" width="200"/>';
        });
        $grid->orders('Номер показа');
//        $grid->created_at('Created at');
//        $grid->updated_at('Updated at');

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
        $show = new Show(SliderItem::findOrFail($id));

        $show->id('Id');
        $show->slider_id('Slider id');
        $show->title('Title');
        $show->text('Text');
        $show->image('Image');
        $show->orders('Orders');
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
        $form = new Form(new SliderItem);

        $form->hidden('slider_id')->value(session('slider_id'));
        $form->text('title', 'Наименование');
        $form->text('url', 'Ссылка на страницу');
        $form->textarea('text', 'Текст');
        $form->image('image', 'Изображение');
        $form->number('orders', 'Номер показа')->default(1);

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
