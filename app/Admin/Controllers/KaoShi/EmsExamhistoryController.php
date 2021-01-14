<?php

namespace App\Admin\Controllers\KaoShi;

use App\Admin\Metrics\Examples\EmsUserQuestions;
use App\Admin\Repositories\KaoShi\EmsExamhistory;
use App\Models\KaoShi\EmsExam;
use App\Models\KaoShi\EmsSubject;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class EmsExamhistoryController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new EmsExamhistory(['ems_basic', 'kao_shi_users', 'ems_exam', 'ems_subject']), function (Grid $grid) {
            $grid->id->display(function ($value) {
                return "<span class=\"badge badge-pill badge-info\">$value</span>";
            })->sortable();
            $grid->column('kao_shi_users.id', '考生ID');
            $grid->column('kao_shi_users.name', '姓名');
            $grid->column('kao_shi_users.pid_number', '身份证号')->limit(20)->copyable();
            $grid->column('kao_shi_users.user_phone', '手机号')->limit(20)->copyable();
            $grid->column('ems_basic.basic', '考场名')->limit(10);
            $grid->column('ems_subject.subject', '申报名称');
            $grid->column('ems_subject.subject_dept', '申报单位');
            $grid->column('ems_exam.exam_name', '试卷名');
            $grid->column('ems_time', '时长')->display(function ($ems_time) {
                return "<span class=\"badge badge-success\">$ems_time/分钟</span>";
            });
            $grid->column('ems_starttime', '开始时间')->sortable();
            $grid->column('ems_endtime', '结束时间');
            $grid->column('ems_timelist', '考试用时')->display(function ($ems_time) {
                $ems_time = ceil($ems_time / 60);
                return "<span class=\"badge badge-success\">$ems_time 分钟</span>";
            });
            $grid->column('ems_score', '成绩')->display(function ($ems_score) {
                $ems_score = 0 + $ems_score . ' 分';
                return "<span class=\"badge badge-danger\">$ems_score</span>";

            });
            $grid->ems_scorelist('试题')->display('查看')->modal('已做试题', EmsUserQuestions::make());
            $grid->ems_ispass('是否通过')->using([1 => '是', 0 => '否'])
                ->dot(
                    [
                        0 => 'danger',
                        1 => 'success',
                    ]
                );
            $grid->disableActions();
            $grid->disableRowSelector();
            $grid->disableDeleteButton();
            $grid->disableBatchDelete();
            $grid->disableCreateButton();
            $grid->disableDeleteButton();
            $grid->disableEditButton();
            $grid->export();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->equal('id')->width(3);
                $filter->like('kao_shi_users.pid_number', '身份证号')->width(3);
                $filter->like('kao_shi_users.name', '姓名')->width(3);
                $filter->like('ems_basic.basic', '考场')->width(3);
                $filter->equal('ems_ispass', '是否通过')->select(['1' => '是', '0' => '否'])->width(3);
                $filter->between('ems_starttime', '开始时间')->datetime()->width(3);
                $filter->between('ems_endtime', '结束时间')->datetime()->width(3);
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
        return Show::make($id, new EmsExamhistory(), function (Show $show) {
            $show->field('id');
            $show->field('ems_user_id');
            $show->field('ems_basic_id');
            $show->field('ems_exam_id');
            $show->field('ems_subject_id');
            $show->field('ems_time');
            $show->field('ems_allscore');
            $show->field('ems_answerlist');
            $show->field('ems_scorelist');
            $show->field('ems_decidetime');
            $show->field('ems_timelist');
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
        return Form::make(new EmsExamhistory(), function (Form $form) {
            $form->display('id');
            $form->text('ems_user_id');
            $form->text('ems_basic_id');
            $form->text('ems_exam_id');
            $form->text('ems_subject_id');
            $form->text('ems_time');
            $form->text('ems_allscore');
            $form->text('ems_answerlist');
            $form->text('ems_scorelist');
            $form->text('ems_decidetime');
            $form->text('ems_timelist');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
