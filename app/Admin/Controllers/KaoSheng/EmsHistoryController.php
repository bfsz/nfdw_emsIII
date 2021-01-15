<?php

namespace App\Admin\Controllers\KaoSheng;

use App\Models\KaoShi\EmsBasic;
use App\Models\KaoShi\EmsExam;
use App\Models\KaoShi\EmsExamhistory;
use App\Admin\Metrics\Examples\EmsUserQuestions;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;

class EmsHistoryController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('成绩记录')
            ->description('考试成绩记录')
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make($this->info(), function (Grid $grid) {
            $grid->id->display(function ($value) {
                return "<span class=\"badge badge-pill badge-success\">$value</span>";
            })->sortable();
            $grid->column('ems_basic_id', '考场名')->display(function ($ems_basic_id) {
                $basic = EmsBasic::where('id', $ems_basic_id)->get('basic');
                $data = json_decode($basic);
                return $data[0]->basic;
            });
            $grid->column('emsSubject.subject', '申报名称');
            $grid->column('emsSubject.subject_dept', '申报单位');
            $grid->column('ems_exam_id', '试卷名')->display(function ($ems_exam_id) {
                $exam_name = EmsExam::where('id', $ems_exam_id)->get('exam_name');
                $data = json_decode($exam_name);
                $exam_name = $data[0]->exam_name;
                return $exam_name;
            });
            $grid->column('ems_time', '时长')->display(function ($ems_time) {
                return "<span class=\"badge badge-success\">$ems_time / 分钟</span>";
            });
            $grid->column('ems_starttime', '开始时间')->sortable();
            $grid->column('ems_endtime', '结束时间');
            $grid->column('ems_timelist', '考试用时')->display(function ($ems_time) {
                $ems_time = ceil($ems_time / 60);
                return "<span class=\"badge badge-success\">$ems_time 分钟</span>";
            });
            $grid->column('ems_allscore', '总分')->display(function ($ems_allscore) {
                $ems_allscore .= ' 分';
                return "<span class=\"badge badge-success\">$ems_allscore</span>";

            });
            $grid->column('ems_score', '成绩')->display(function ($ems_score) {
                $ems_score = 0 + $ems_score . ' 分';
                return "<span class=\"badge badge-danger\">$ems_score</span>";

            })->sortable();
            $grid->ems_scorelist('已做试题')->display('查看试题')->modal('已做试题', EmsUserQuestions::make());
            $grid->ems_ispass('是否通过')->using([1 => '是', 0 => '否'])
                ->dot(
                    [
                        0 => 'danger',
                        1 => 'success',
                    ]
                );
            $grid->ems_decidetime('评卷时间')->sortable();
            // 禁用
            $grid->disableRowSelector();
            $grid->disableActions();
            $grid->disableEditButton();
            $grid->disableDeleteButton();
            $grid->disableCreateButton();
            $grid->disableQuickEditButton();
            $grid->disableViewButton();
            $grid->disableBatchActions();
            $grid->selector(function (Grid\Tools\Selector $selector) {
                $selector->select('ems_ispass', '是否通过', [1 => '是', 0 => '否']);
            });
        });
    }

    /*
     * 用户数据逻辑
     * */
    public function info()
    {
        $user_id = Admin::user()->id; //登录用户ID
        $data = EmsExamhistory::with(['ems_basic', 'ems_exam', 'ems_subject'])->where('ems_user_id', $user_id);
        return $data;
    }
}
