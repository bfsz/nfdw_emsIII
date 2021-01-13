<?php

namespace App\Admin\Controllers\KaoShi;

use App\Admin\Metrics\Examples\EmsExamQuestions;
use App\Models\KaoShi\EmsExam;
use App\Models\TiKu\EmsDeclaration;
use App\Models\TiKu\EmsMajor;
use App\Models\Tiku\EmsQuestion;
use App\Models\TiKu\EmsQuestype;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\DB;

class EmsExamController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new EmsExam(), function (Grid $grid) {
            $grid->model()->with(['major', 'subject', 'declaration']);
            $user = Admin::user()->name;
            $grid->id->sortable();
            $grid->exam_name;
            $grid->exam_questions->display('试卷查看')->modal('试卷', EmsExamQuestions::make());
            $grid->column('declaration.decl_name', '适用类别')->label('info');
            $grid->column('major.major_name', '适用专业')->label('success');
            $grid->created_at;
            $grid->updated_at->sortable();
            $grid->enableDialogCreate();
            $grid->setDialogFormDimensions('80%', '80%');
            // 设置表单提示值
            $grid->quickSearch(['exam_name'])->placeholder('搜索...');
            //导出
            $grid->export()->filename('试卷数据');
            $grid->disableViewButton();
            $grid->disableEditButton();
            $grid->showQuickEditButton();

            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局
                $filter->panel();
                // 注意切换为panel布局方式时需要重新调整表单字段的宽度
                $filter->like('exam_name')->width(3);
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
        return Show::make($id, new EmsExam(), function (Show $show) {
            $show->field('id');
            $show->field('exam_name');
            $show->field('exam_questions');
            $show->field('exam_set');
            $show->field('exam_score');
            $show->field('exam_jigescore');
            $show->field('exam_time');
            $show->field('exam_major');
            $show->field('exam_type');
            $show->field('exam_status');
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
        return Form::make(new \App\Models\KaoShi\EmsExam(), function (Form $form) {
            $user = Admin::user()->id;
            $form->display('id');
            $form->text('exam_name');
            $form->table('exam_set', function ($table) {
                $table->select('subject_set', '题型')->options(function () {
                    $roleModel = EmsQuestype::class;
                    return $roleModel::all()->pluck('type_name', 'id');
                });
                $table->number('count', '数量');
                $table->number('score', '每题分值');
            })->saving(function ($v) {
                return json_encode($v);
            });
            $form->slider('exam_time')->options(['max' => 150, 'min' => 0, 'step' => 10, 'postfix' => '/分钟']);
            $form->text('exam_score')->disable()->help('总分根据题型设置数量自动计算');
            $form->text('exam_jigescore')->disable()->help('及格是占总分 60% 的分值');
//            $form->switch('exam_status')->default(1);
            $form->select('exam_type')->options(function () {
                $declarationModel = EmsDeclaration::class;
                return $declarationModel::all()->pluck('decl_name', 'id');
            });
            $form->select('exam_major')
                ->options(function () {
                    $roleModel = EmsMajor::class;
                    return $roleModel::all()->pluck('major_name', 'id');
                });
            $form->text('create_by')->default($user)->display(false);
            $form->text('last_by')->default($user)->display(false);

            $form->display('created_at');
            $form->display('updated_at');

            // 保存成功后自动生成题库
        })->saved(function (Form $form) {
            // 获取表单主键ID
            $id = $form->getKey();
            //如果是新增，则随机抽取题库生成试卷
            if ($form->isCreating()) {
                // 获取生成题库需要的数据
                $data = EmsExam::where('id', $id)->select('exam_set', 'exam_type', 'exam_major')->get();
                $exam_set = json_decode(trim($data[0]->exam_set, '"'), true); // 题型数量
                $exam_type = '%' . $data[0]->exam_type . '%'; // 类别
                $exam_major = '%' . $data[0]->exam_major . '%'; // 专业
                $questions = array(); // 试题数组
                $yiban_score = 0; //一般题得分
                $timao_score = 0; //题冒题得分
                //遍历随机获取题目
                foreach ($exam_set as $item) {
                    $qType_id = (int)$item['subject_set'];//题型ID
                    $qType_name = EmsQuestype::where('id', $qType_id)->pluck('type_name');
                    $qCount = (int)$item['count']; //题型数量
                    $qScore = (int)$item['score']; //每小题分值
                    $questions_data = EmsQuestion::select(['id', 'questype_id', 'que_index', 'que_select', 'que_selectnum', 'que_answer', 'que_son_num', 'que_son_value'])
                        ->where('questype_id', $qType_id)->where('major_id', 'like', $exam_major)->where('declaration_id', 'like', $exam_type)
                        ->where('que_head_id', null)->orderBy(DB::raw('RAND()'))
                        ->take($qCount)->get();
                    $questions_array = json_decode($questions_data);

                    //判断是否事题冒题，如果无子题数量则不做操作
                    for ($i = 0, $iMax = count($questions_array); $i < $iMax; $i++) {
                        if ($questions_array[$i]->que_son_num != null) {
                            $timao_id = $questions_array[$i]->id;
                            $timao_questions = EmsQuestion::select(['id', 'questype_id', 'que_index', 'que_select', 'que_selectnum', 'que_answer', 'que_son_num', 'que_head_id'])->where('que_head_id', $timao_id)->get();
                            $questions_array[$i]->que_son_value = $timao_questions;
                            $timao_score = (int)($questions_array[$i]->que_son_num) * $qScore; //题冒子题总分
                        } else {
                            $yiban_score += $qScore; //一般题累加分
                            $timao_score = 0;
                        }
                    }
                    $questions_info = array('id' => $qType_id, 'type' => $qType_name[0], 'count' => $qCount, 'score' => $qScore, 'questions' => $questions_array,);
                    array_push($questions, $questions_info);
                }
                $all_score = $yiban_score + $timao_score; //非题冒题 题型总分
                $jg_score = (int)$all_score * 0.6; //及格分 总分60%
                $questions_json = json_encode($questions);
                // 试卷组成
                $EmsExamData = EmsExam::find($id);
                $EmsExamData->exam_questions = $questions_json;
                $EmsExamData->exam_score = $all_score;
                $EmsExamData->exam_jigescore = $jg_score;
                $EmsExamData->save();
                $message = '试卷已生成！';
                //否则,不执行任何操作抽题操作
            } else {
                $message = '内容修改成功 注：已生成的试卷，题型设置不可再更改，试卷试题不做更新！';
            }
            return admin_info('试卷生成', $message);
        });
    }
}
