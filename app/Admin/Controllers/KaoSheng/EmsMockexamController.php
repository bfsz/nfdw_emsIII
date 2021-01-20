<?php

namespace App\Admin\Controllers\KaoSheng;

use App\Admin\Repositories\KaoSheng\EmsMockexam;
use App\Admin\Tools\DropdownOptionsTools;
use App\Models\TiKu\EmsDeclaration;
use App\Models\TiKu\EmsMajor;
use App\Models\TiKu\EmsQuestion;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\DB;

class EmsMockexamController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $create_by = Admin::user()->id;
        $data = \App\Models\KaoSheng\EmsMockexam::where('mkems_byid', $create_by)->orderByDesc('created_at');//创建人可看
        return Grid::make($data, function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('mkems_name');
            $grid->column('mkems_startdate');
            $grid->column('mkems_enddate');
            $grid->column('mkems_timespent')->display(function ($value) {
                return $value . ' / 分钟';
            });
            $grid->column('mkems_url')->display(function ($value) {
                $status = $this->mkems_status;
                if ($status === 1) {
                    return '<a href="' . $value . '" target="_blank">进入考试</a>';
                }
                return '已结束';

            });
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->enableDialogCreate();
            $grid->setDialogFormDimensions('50%', '50%');
            $grid->quickSearch(['id', 'mkems_name']);
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
        return Show::make($id, new EmsMockexam(['major', 'declaration']), function (Show $show) {
            $show->html(function () {
                // 获取字段信息
                $id = $this->id;
                $mkems_name = $this->mkems_name;
                $mkems_analysis = $this->mkems_analysis;
                $mkems_startdate = $this->mkems_startdate;
                $mkems_enddate = $this->mkems_enddate;
                $mkems_timespent = $this->mkems_timespent;
                $mkems_question_count = $this->mkems_question_count;
                $corrects = 0;
                $wrongs = 0;
                foreach (json_decode($mkems_analysis) as $item) {
                    $item->answer === $item->ksAnswer ? $corrects++ : $wrongs++;
                }
                $correct_rate = $corrects / ($corrects + $wrongs) * 100;
                return view('exam.mock_view', ['id' => $id,
                    'mkems_name' => $mkems_name,
                    'mkems_analysis' => json_decode($mkems_analysis),
                    'mkems_startdate' => $mkems_startdate,
                    'mkems_enddate' => $mkems_enddate,
                    'corrects' => $corrects,
                    'wrongs' => $wrongs,
                    'correct_rate' => $correct_rate,
                    'mkems_question_count' => $mkems_question_count,
                    'mkems_timespent' => $mkems_timespent]);
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new EmsMockexam(), function (Form $form) {
            if ($form->isEditing()) {
                $form->disableSubmitButton();
            }
            $login_id = Admin::user()->id;
            $form->display('id');
            $form->hidden('mkems_byid')->default($login_id);
            $mkems_name = 'MOCK' . $login_id . date('YmdHis');
            $form->text('mkems_name')->default($mkems_name);
            $form->select('mkems_major_id')->options(function () {
                $majorModel = EmsMajor::class;
                return $majorModel::all()->pluck('major_name', 'id');
            })->required();
            $form->select('mkems_declaration_id')->options(function () {
                $categoryModel = EmsDeclaration::class;
                return $categoryModel::all()->pluck('decl_name', 'id');
            })->required();
            $options = new DropdownOptionsTools();
            $form->select('mkems_question_count')->options($options->MockQuestionsCount());
            $form->display('created_at');
            $form->display('updated_at');
            $form->hidden('mkems_question');
            $form->hidden('mkems_url');
            $form->hidden('mkems_status');
        })->saved(function (Form $form, $result) {
            // 获取表单主键ID
            $id = $form->getKey();
            // 获取生成题库需要的数据
            $mock_declaration = '%' . $form->mkems_declaration_id . '%'; // 种类
            $mock_major = '%' . $form->mkems_major_id . '%'; // 专业
            $mock_questions_count = $form->mkems_question_count;
            $questions = array(); // 试题数组
            //遍历随机获取题目

            $questions_data = EmsQuestion::select(['id', 'questype_id', 'que_index', 'que_select', 'que_selectnum', 'que_answer', 'que_son_num', 'que_son_value'])
                ->where('major_id', 'like', $mock_major)->where('declaration_id', 'like', $mock_declaration)
                ->where('que_head_id', null)->orderBy(DB::raw('RAND()'))
                ->take($mock_questions_count)->get();
            $questions_array = json_decode($questions_data);

            //判断是否事题冒题，如果无子题数量则不做操作
            for ($i = 0, $iMax = count($questions_array); $i < $iMax; $i++) {
                if ($questions_array[$i]->que_son_num != null) {
                    $timao_id = $questions_array[$i]->id;
                    $timao_questions = EmsQuestion::select(['id', 'questype_id', 'que_index', 'que_select', 'que_selectnum', 'que_answer', 'que_son_num', 'que_head_id'])->where('que_head_id', $timao_id)->get();
                    $questions_array[$i]->que_son_value = $timao_questions;
                }
            }
            array_push($questions, $questions_array);
            $mkems_question = json_encode($questions);
            $mkems_url = admin_url('KaoSheng/EmsMock') . '/' . base64_encode($id) . '/MockPage';
            $mkems_status = 1;
            \App\Models\KaoSheng\EmsMockexam::where('id', $id)->update(['mkems_question' => $mkems_question, 'mkems_url' => $mkems_url, 'mkems_status' => $mkems_status]);
        });
    }
}
