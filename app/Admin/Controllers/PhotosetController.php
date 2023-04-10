<?php

namespace App\Admin\Controllers;

use App\Page;
use App\Photoset;
use Encore\Admin\Facades\Admin;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class PhotosetController extends Controller
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
            ->header('Блок Фотогалерея на странице '.$this->page_name)
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
            ->header('Блок Фотогалерея на странице '.$this->page_name)
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
            ->header('Блок Фотогалерея на странице '.$this->page_name)
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
            ->header('Блок Фотогалерея на странице '.$this->page_name)
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
        $grid = new Grid(new Photoset);
        $grid->model()->where('page_id', session('page_id'));

//        $grid->id('Id');
        $grid->name('Наименование')->display(function ($name) {
            return '<a href="/admin/photos?set='.$this->id.'">'.$name.'</a>';
        });
        $grid->photos('Фотографий')->display(function ($photos) {
            $count = count($photos);
            return "<span class='label label-warning'>{$count}</span>";
        });
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
        $show = new Show(Photoset::findOrFail($id));

        $show->id('Id');
        $show->name('Наименование');
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
        $form = new Form(new Photoset);

        $form->hidden('page_id')->value(session('page_id'));
        $form->hidden('page_block_id')->value(session('page_block_id'));
        $form->text('name', 'Наименование');
        $form->hasMany('photos', 'Фотографии', function (Form\NestedForm $form) {
            $form->number('orders', 'Номер показа');
            $form->text('name', 'Заголовок');
            $form->textarea('text', 'Текст');
            $form->myimage('image', 'Фото');
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
        $url = "/admin/sub_pages?set={$page->id}";
        if (!$page->relation)
            $url = "/admin/page_blocks?set={$page->id}";
        $this->bread_crubs = " <a href='$url'>".$page->name."</a> / ".$this->bread_crubs;

        if (($page->parent_id>0) and (Admin::user()->isAdministrator()) ) {
            $this->getBeadCrumbs($page->parent_id);
        }
    }

}
