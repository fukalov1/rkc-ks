<?php

namespace App\Admin\Controllers;

use App\Page;
use App\Photo;
use Encore\Admin\Facades\Admin;
use App\Http\Controllers\Controller;
use App\Photoset;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class PhotoController extends Controller
{
    use HasResourceActions;
    public $photoset_name='';
    public $photoset_id=0;
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
            ->header('Фотогалерея '.$this->photoset_name)
            ->description(' фотографии')
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
        $this->getBeadCrumbs(session('page_id'));
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
            ->header('Фотогалерея '.$this->photoset_name)
            ->description('Редактирование фотографии')
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
            ->header('Фотогалерея '.$this->photoset_name)
            ->description('Добавление фотографии')
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
        $grid = new Grid(new Photo);

        $grid->model()->where('photoset_id',session('photoset_id'));

//        $grid->id('Id');
//        $grid->photoset_id('Photoset id');
        $grid->name('Название');
        $grid->text('Описание');
        $grid->orders('Номер');
        $grid->image('Фото')->display(function ($image) {
            $str = '-';
            if ($image!='') {
                $str = '<img src="/uploads/images/thumbnail/'.$image.'"/>';
            }
           return $str;
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
        $show = new Show(Photo::findOrFail($id));

        $show->id('Id');
        $show->photoset_id('Photoset id');
        $show->name('Name');
        $show->text('Text');
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
        $form = new Form(new Photo);

        $form->hidden('photoset_id')->value(session('photoset_id'));
        $form->text('name', 'Название');
        $form->textarea('text', 'Описание');
        $form->number('orders', 'Номер')->default(1);
        $form->myimage('image', 'Фото');

        return $form;
    }

    private function getHeader() {
        $page = Photoset::find(session('page_id'));
        if ($page) {
            $this->page_id = $page->id;
            $this->page_name = $page->name;
        }
        else {
            return redirect('/admin/photosets');
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
