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

class MapSubPointController extends Controller
{
    use HasResourceActions;
    public $map_id=0;
    public $map_name = '';
    public $point_id=0;
    public $point_name = '';

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
            ->header($this->map_name.' / '.$this->point_name)
            ->description('точки группы')
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
            ->header($this->map_name.' / '.$this->point_name)
            ->description('редактирование точек группы')
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
            ->header($this->map_name.' / '.$this->point_name)
            ->description('добавление точек группы')
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
            ->where('parent_id',session('point_id'));

        $grid->id('Id');
//        $grid->hidden('map_id')->value(session('map_id'));
//        $grid->parent_id('Группа');
        $grid->name('Наименование');
        $grid->xcoord('Долгота');
        $grid->ycoord('Широта');
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
        $show->content('Описание');
        $show->header('Заголовок');
        $show->body('Текст');
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
        $form->hidden('parent_id')->value(session('point_id'));
        $form->text('name', 'Наименование');
        $form->text('xcoord', 'Долгота')->default('1');
        $form->text('ycoord', 'Широта')->default('1');
        $form->text('content', 'Содержание');
        $form->text('header', 'Заголовок');
        $form->text('body', 'Описание');
        $form->text('hint', 'Подскзка');

        return $form;
    }

    private function getHeader() {
        $map = Map::find(session('map_id'));
        $point = MapPoint::find(session('point_id'));
        if ($map) {
            $this->map_id = $map->id;
            $this->map_name = $map->name;
            $this->point_id = $point->id;
            $this->point_name = $point->name;
        }
        else {
            return redirect('/admin/pages');
        }
    }

}
