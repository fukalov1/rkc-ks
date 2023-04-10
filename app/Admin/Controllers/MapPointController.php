<?php

namespace App\Admin\Controllers;

use App\Map;
use App\MapPoint;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class MapPointController extends Controller
{
    use HasResourceActions;
    public $map_id=0;
    public $map_name = '';

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        $this->getHeader();
        return $content
            ->header('Точки на карте '.$this->map_name)
            ->description('список')
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
        return $content
            ->header('Точки на карте '.$this->map_name)
            ->description('редактирование')
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
            ->header('Точки на карте '.$this->map_name)
            ->description('добавление')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MapPoint);

        $grid->model()
            ->where('map_id', session('map_id'))
            ->where('parent_id', 0);

        $grid->id('Id');
//        $grid->hidden('map_id')->value(session('map_id'));
        $grid->name('Наименование')->display(function ($name) {
            $map = Map::find(session('map_id'));

            $str = $name;
            if ($map->type==2) {
                $str =  '<a href="/admin/map_sub_points?set='.$this->id.'">'.$name.'</a>';
            }
            return $str;
        });
        $grid->xcoord('Долгота');
        $grid->ycoord('Широта');
        $grid->content('Ссылка');
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
        $show = new Show(MapPoint::findOrFail($id));

        $show->id('Id');
//        $show->hidden('map_id')->value(session('map_id'));
//        $show->parent_id('Parent id');
        $show->name('Наименование');
        $show->xcoord('Долгота');
        $show->ycoord('Широта');
        $show->content('Ссылка');
        $show->header('Заголовок');
        $show->body('Описание');
        $show->hint('Подсказка');
//        $show->created_at('Created at');
//        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new MapPoint);

        $form->hidden('map_id')->value(session('map_id'));
//        $form->number('parent_id', 'Parent id');
        $form->text('name', 'Наименование');
        $form->text('xcoord', 'Долгота')->default('1');
        $form->text('ycoord', 'Широта')->default('1');
        $form->text('content', 'Ссылка');
        $form->text('header', 'Заголовок');
        $form->text('body', 'Описание');
        $form->text('hint', 'Подсказка');

        return $form;
    }

    private function getHeader() {
        $map = Map::find(session('map_id'));
        if ($map) {
            $this->map_id = $map->id;
            $this->map_name = $map->name;
        }
        else {
            return redirect('/admin/pages');
        }
    }

}
