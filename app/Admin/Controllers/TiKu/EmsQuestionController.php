<?php

namespace App\Admin\Controllers\TiKu;

use App\Admin\Actions\Grid\GridQuestionData;
use App\Admin\Repositories\TiKu\EmsQuestion;
use App\Models\TiKu\EmsDeclaration;
use App\Models\TiKu\EmsMajor;
use App\Models\TiKu\EmsQuestype;
use App\Renderable\TikuTable;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;

class EmsQuestionController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new EmsQuestion(), function (Grid $grid) {
            $grid->id->sortable()->bold();
            $grid->column('questype.type_name', '题型')->label('default');
            $grid->que_index->limit(35);
            $grid->que_status->using([1 => '启用', 0 => '停用'])
                ->dot(
                    [
                        1 => 'success',
                        0 => 'danger',
                    ]
                );
            $grid->column('declaration_id', '申报种类')->display(function ($declaration_id) {
                $decl_id = json_decode($declaration_id);
                $arr = [];
                if (is_array($decl_id)) {
                    for ($i = 0, $iMax = count($decl_id); $i < $iMax; $i++) {
                        array_push($arr, intval($decl_id[$i]));
                    }
                }
                $decl_name = EmsDeclaration::all(['decl_name', 'id'])->whereIn('id', $arr);
                $result = [];
                foreach ($decl_name as $i) {
                    array_push($result, $i->decl_name);
                }
                $str = '';
                foreach ($result as $item) {
                    $str = $str . " / " . $item;
                }
                return "<span>$str</span>";
            });
            $grid->column('major_id', '申报专业')->display(function ($major_id) {
                $major_id = json_decode($major_id);
                $arr = [];
                if (is_array($major_id)) {
                    for ($i = 0, $iMax = count($major_id); $i < $iMax; $i++) {
                        array_push($arr, intval($major_id[$i]));
                    }
                }
                $major_name = EmsMajor::all(['major_name', 'id'])->whereIn('id', $arr);
                $result = [];
                foreach ($major_name as $i) {
                    array_push($result, $i->major_name);
                }
                $str = '';
                foreach ($result as $item) {
                    $str = $str . " / " . $item;
                }
                return "<span>$str</span>";
            });
            $grid->que_head_satuts('题类')->using([1 => '题冒题', 0 => '一般题'])
                ->badge(
                    [
                        1 => 'success',
                        0 => 'info',
                    ]
                );
            $grid->que_head_id->display(function ($que_head_id) {
                if ($que_head_id) {
                    return "<span class=\"badge badge-pill badge-warning\">$que_head_id</span>";
                } else {
                    return "<span></span>";
                }
            });
            $grid->column('que_zql', '正确率')->display(function () {
                $sure = (int)$this->que_sure_count;
                $error = (int)$this->que_error_count;
                if ($sure + $error == 0) {
                    return '-';
                } else {
                    $data = "<span class=\"badge badge-pill badge-danger\">" . ceil($sure / ($sure + $error) * 100) . ' %' . "</span>";
                    return $data;
                }
            });
            // 设置表单提示值
            $grid->quickSearch(['que_index'])->placeholder('题干内容搜索...');
            //导出
            $titles = ['id' => 'ID', 'que_index' => '题干', 'que_select' => '选项', 'que_answer' => '答案'];
            $grid->export($titles)->filename('题库数据');
            //导入
            $grid->tools(new GridQuestionData());
            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局
                $filter->panel();
                // 注意切换为panel布局方式时需要重新调整表单字段的宽度
                $filter->like('que_index')->width(3);
                $filter->equal('questype.type_name', '题型')->select('/api/questype1')->width(3);
                $filter->equal('que_head_satuts')->select([1 => '题冒题', 0 => '一般题'])->width(3);
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
        return Show::make($id, new EmsQuestion(), function (Show $show) {
//            $show->field('id');
//            $show->field('questype_id');
//            $show->field('que_index');
//            $show->field('que_create_byid');
//            $show->field('que_create_byname');
//            $show->field('que_last_byid');
//            $show->field('que_last_byname');
//            $show->field('que_select');
//            $show->field('que_selectnum');
//            $show->field('que_answer');
//            $show->field('que_describe');
//            $show->field('que_status');
//            $show->field('que_level');
//            $show->field('que_sequence');
//            $show->field('declaration_id');
//            $show->field('major_id');
//            $show->field('que_head_id');
//            $show->field('que_head_satuts');
//            $show->field('que_son_num');
//            $show->field('que_son_value');
//            $show->field('que_sure_count');
//            $show->field('que_error_count');
//            $show->field('created_at');
//            $show->field('updated_at');
            $show->html(function () {
                // 获取字段信息
                $id = $this->id;
                $que_index = $this->que_index;
                $que_select = $this->que_select;
                $que_answer = $this->que_answer;
                return "<div class=\"card\">
                          <div class=\"card-header\"><h5>$que_index</h5></div>
                          <div class=\"card-body\">
                              <div style='padding-left: 20px'>$que_select</div>
                          </div>
                          <div class=\"card-footer\">正确答案：$que_answer</div>
                        </div>";
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
        return Form::make(new EmsQuestion(), function (Form $form) {
            $user = Admin::user();
            $info = '<i class="fa fa-exclamation-circle"></i>题冒题建议手动输入，一般题则可导入，题目导入后，需要对新导入的题目进行格式的调整。';
            $form->html(Alert::make($info)->info());
            $form->display('id');
            $form->radio('que_head_satuts')->when(1, function (Form $form) {
                if ($form->isCreating() || $form->isEditing()) {
                    $form->selectTable('que_head_id', '题冒题目')
                        ->title('弹窗标题')
                        ->dialogWidth('50%') // 弹窗宽度，默认 800px
                        ->from(TikuTable::make(['id' => $form->getKey()])) // 设置渲染类实例，并传递自定义参数
                        ->model(EmsQuestion::class, 'id', 'que_index'); // 设置编辑数据显示
                    $form->number('que_son_num');
                }
            })->when(0, function (Form $form) {

            })->options([1 => '是', 0 => '否'])->default(0);

            $form->select('questype_id', '题型')->options(function () {
                $categoryModel = EmsQuestype::class;
                return $categoryModel::all()->pluck('type_name', 'id');
            })->required();
            $form->editor('que_index');
            $form->text('que_create_byid')->default($user->id)->display(false);
            $form->text('que_create_byname')->default($user->name)->disable();
            $form->text('que_last_byid')->display(false);
            $form->text('que_last_byname')->display(false);
            $form->editor('que_select');
            $form->number('que_selectnum');
            $form->text('que_answer');
            $form->editor('que_describe');
            $form->switch('que_status')->default(1);
//            $form->select('que_level')->options([1 => '易', 2 => '中', 3 => '难']);
//            $form->number('que_sequence');
            $form->multipleSelect('declaration_id', '申报种类')->options(function () {
                $categoryModel = EmsDeclaration::class;
                return $categoryModel::all()->pluck('decl_name', 'id');
            })->required()->saving(function ($value) {
                // 转化成json字符串保存到数据库
                return json_encode($value);
            });
            $form->multipleSelect('major_id', '申报专业')->options(function () {
                $categoryModel = EmsMajor::class;
                return $categoryModel::all()->pluck('major_name', 'id');
            })->required()->saving(function ($value) {
                // 转化成json字符串保存到数据库
                return json_encode($value);
            });
            $form->display('created_at');
            $form->display('updated_at');

            $form->confirm('您确定要提交表单吗？', '');
        });
    }
}
