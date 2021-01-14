<?php

namespace App\Admin\Controllers\KaoShi;

use App\Admin\Repositories\KaoShi\EmsExamsession;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class EmsExamsessionController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new EmsExamsession(), function (Grid $grid) {
            $grid->column('session_user_id')->sortable();
            $grid->column('session_subject_id');
            $grid->column('session_exam_id');
            $grid->column('session_basic_id');
            $grid->column('session_allscore');
            $grid->column('session_exam_url');
            $grid->column('session_history_time');
            $grid->column('session_sum_time');
            $grid->column('session_token_status');
            $grid->column('created_at')->sortable();
            $grid->column('updated_at')->sortable();
            $grid->disableCreateButton();
            $grid->disableEditButton();
            $grid->disableViewButton();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->equal('id')->width(3);
                $filter->equal('session_subject_id')->width(3);
                $filter->equal('session_exam_id')->width(3);
                $filter->equal('session_basic_id')->width(3);
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
        return Show::make($id, new EmsExamsession(), function (Show $show) {
//            $show->field('session_user_id');
//            $show->field('session_subject_id');
//            $show->field('session_exam_id');
//            $show->field('session_basic_id');
//            $show->field('session_user_id');
//            $show->field('session_allscore');
//            $show->field('session_exam_question');
//            $show->field('session_exam_url');
//            $show->field('session_history_time');
//            $show->field('session_sum_time');
//            $show->field('session_token_status');
//            $show->field('created_at');
//            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new EmsExamsession(), function (Form $form) {
//            $form->display('session_user_id');
//            $form->text('session_subject_id');
//            $form->text('session_exam_id');
//            $form->text('session_basic_id');
//            $form->text('session_allscore');
//            $form->text('session_exam_question');
//            $form->text('session_exam_url');
//            $form->text('session_history_time');
//            $form->text('session_sum_time');
//            $form->text('session_token_status');
//
//            $form->display('created_at');
//            $form->display('updated_at');
        });
    }
}
