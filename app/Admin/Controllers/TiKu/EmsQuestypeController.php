<?php

namespace App\Admin\Controllers\TiKu;

use App\Admin\Repositories\TiKu\EmsQuestype;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class EmsQuestypeController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new EmsQuestype(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('type_name');
            $grid->column('sort');
            $grid->column('type_choice');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new EmsQuestype(), function (Show $show) {
            $show->field('id');
            $show->field('type_name');
            $show->field('sort');
            $show->field('type_choice');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new EmsQuestype(), function (Form $form) {
            $form->display('id');
            $form->text('type_name');
            $form->text('sort');
            $form->text('type_choice');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
