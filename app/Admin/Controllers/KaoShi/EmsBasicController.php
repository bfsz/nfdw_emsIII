<?php

namespace App\Admin\Controllers\KaoShi;

use App\Admin\Metrics\Examples\EmsExamUser;
use App\Admin\Repositories\KaoShi\EmsBasic;
use App\Models\KaoShi\EmsExam;
use App\Models\KaoShi\EmsExamsession;
use App\Models\KaoShi\EmsSubject;
use App\Renderable\EmsExamTable;
use App\Renderable\EmsSubjectTable;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;

class EmsBasicController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new EmsBasic(), function (Grid $grid) {
            $grid->model()->with(['emsSubject']);
            $user = Admin::user();
            $grid->id->sortable();
            $grid->column('emsSubject.subject', '申报名称')->limit(30);
            $grid->column('emsSubject.subject_dept', '申报单位')->limit(30);
            $grid->basic_staus->using([1 => '开启', 0 => '关闭'])
                ->dot(
                    [
                        0 => 'danger',
                        1 => 'success',
                    ]
                );
            $grid->basic_users->display('查看')->modal('参考人员', EmsExamUser::make());
            $grid->created_at;
            $grid->updated_at->sortable();

            // 设置弹窗宽高，默认值为 '700px', '670px'
            $grid->enableDialogCreate();
            $grid->setDialogFormDimensions('80%', '60%');
            // 设置表单提示值
            $grid->quickSearch(['basic', 'basic_desc'])->placeholder('搜索...');
            //导出
            $grid->export()->filename('考场数据');
            // 显示快捷编辑按钮
            $grid->showQuickEditButton();
            // 禁用编辑按钮
            $grid->disableEditButton();
            $grid->disableViewButton();
            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局
                $filter->panel();
                // 注意切换为panel布局方式时需要重新调整表单字段的宽度
                $filter->like('basic', '考场名')->width(3);
                $filter->like('emsSubject.subject', '科目')->width(3);
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
        return Show::make($id, new EmsBasic(), function (Show $show) {
            $show->field('id');
            $show->field('basic');
            $show->field('basic_desc');
            $show->field('basic_exam_id');
            $show->field('basic_subject_id');
            $show->field('basic_users');
            $show->field('basic_staus');
            $show->field('creat_by');
            $show->field('last_by');
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
        return Form::make(new EmsBasic(), function (Form $form) {
            $user = Admin::user();
            $form->display('id');
            $form->text('basic')->required();
            $form->selectTable('basic_subject_id', '申报信息')
                ->title("申报信息")
                ->dialogWidth('50%')
                ->from(EmsSubjectTable::make())
                ->model(EmsSubject::class, 'id', 'subject')
                ->required();
            $form->selectTable('basic_exam_id', '选择试卷')
                ->title("试卷信息")
                ->dialogWidth('50%')
                ->from(EmsExamTable::make())
                ->model(EmsExam::class, 'id', 'exam_name')
                ->required();
            $form->textarea('basic_desc')->rows(4);
            $info = '<i class="fa fa-exclamation-circle"></i> 注意:考试期间勿做更新操作,建议开考前确认表单无误后开启考试';
            $form->switch('basic_staus')->default(0);
            $form->html(Alert::make($info)->info());
            $form->text('creat_by')->default($user->id)->display(false);
            $form->text('last_by')->default($user->id)->display(false);
            $form->display('created_at')->display(false);
            $form->display('updated_at')->display(false);
        })->saved(function (Form $form) {
            /* 生成考试记录*/
            //1、考场ID、试卷ID
            try {
                // 获取表单主键ID 考场ID
                $basic_id = $form->getKey();
                $basic = \App\Models\KaoShi\EmsBasic::where('id', $basic_id)->select('basic_subject_id', 'basic_exam_id')->get(); //申报科目ID
                $subject_id = $basic[0]->basic_subject_id; // 申报科目ID
                $exam_id = $basic[0]->basic_exam_id; // 试卷ID
                $users_datas = EmsSubject::where('id', $subject_id)->select('subject_uesrs')->get();
                $users_datas = $users_datas[0]->subject_uesrs;
                //2、获取考试时长
                $exam = EmsExam::where('id', $exam_id)->select('exam_time', 'exam_questions', 'exam_score')->get();
                $all_time = $exam[0]->exam_time;// 总时长
                $exam_questions = $exam[0]->exam_questions;
                $exam_score = $exam[0]->exam_score;
                // 遍历考生ID依次依次生成临时记录
                $users_datas_json = json_decode(trim($users_datas, '"'));
                for ($i = 0, $iMax = count($users_datas_json); $i < $iMax; $i++) {
                    // 考试记录 考生考场唯一
                    $is_user = EmsExamsession::where('session_user_id', (int)$users_datas_json[$i])->where('session_basic_id', (int)$basic_id)->exists();
                    if ($is_user != true) {
                        //判断数据是否已存在 通过考场、科目、试卷、用户ID
                        $is_status = EmsExamsession::where('session_user_id', (int)$users_datas_json[$i])
                            ->where('session_basic_id', (int)$basic_id)
                            ->where('session_subject_id', (int)$subject_id)
                            ->where('session_exam_id', (int)$exam_id)->exists();
                        //不存在则新增
                        if ($is_status != true) {
                            $EmsExamsession = new EmsExamsession();
                            $EmsExamsession->session_user_id = (int)$users_datas_json[$i];
                            $EmsExamsession->session_basic_id = (int)$basic_id;
                            $EmsExamsession->session_subject_id = (int)$subject_id;
                            $EmsExamsession->session_exam_id = (int)$exam_id;
                            $EmsExamsession->session_sum_time = $all_time;
                            $EmsExamsession->session_exam_question = $exam_questions;
                            $EmsExamsession->session_allscore = $exam_score;
                            $EmsExamsession->session_exam_url = admin_url('KaoSheng/EmsKaoShi') . '/' . base64_encode($basic_id) . '/ExamPage';
                            $EmsExamsession->save();
                        } else {
                            EmsExamsession::where('session_user_id', (int)$users_datas_json[$i])
                                ->where('session_basic_id', (int)$basic_id)
                                ->where('session_subject_id', (int)$subject_id)
                                ->where('session_exam_id', (int)$exam_id)
                                ->update(['session_sum_time' => $all_time]);
                        }
                    } else {
                        admin_warning('提示', '考试记录已存在的考生数据不变更，新增新参加考试考生记录');
                    }
                }
            } catch (\Exception $e) {
                admin_error('错误', '请联系管理员');
            }
        });
    }
}
