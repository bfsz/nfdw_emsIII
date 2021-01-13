<?php

namespace App\Admin\Controllers\KaoShi;

use App\Admin\Repositories\KaoShi\EmsSubject;
use App\Models\KaoShi\EmsSubject as EmsSubjectModel;
use App\Models\KaoShi\AdminUser;
use App\Models\TiKu\EmsDeclaration;
use App\Models\TiKu\EmsMajor;
use App\Renderable\UsersTable;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class EmsSubjectController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $create_by = Admin::user()->id;
        $data = new EmsSubject();
        /*系统管理员\考试管理员 可查看所有*/
        if (Admin::user()->isRole('exam_administrator') || Admin::user()->isRole('administrator')) {
            $data = new EmsSubject();
        }
        /*申报管理员 创建人可见*/
        if (Admin::user()->isRole('filing_administrator')) {
            $data = EmsSubjectModel::where('create_by', $create_by);//创建人可看
        }
        return Grid::make($data, function (Grid $grid) {
            $user = Admin::user();
            $grid->id->sortable();
            $grid->subject;
            $grid->subject_dept;
            $grid->column('subject_set', '申报专业/种类')->display(function () {
                $data = json_decode($this->subject_set);
                $major_id = $data->major;
                $decl_name_id = $data->decl_name;
                $major_name = EmsMajor::find($major_id)->major_name;
                $decl_name = EmsDeclaration::find($decl_name_id)->decl_name;
                return "<span class=\"badge badge-pill badge-success\">$major_name</span> <span class=\"badge badge-pill badge-info\">$decl_name</span>";
            });
            $grid->subject_desc->limit(30);
            $grid->created_at->sortable();
            $grid->updated_at->sortable();

            // 设置弹窗宽高，默认值为 '700px', '670px'
            $grid->enableDialogCreate();
            $grid->setDialogFormDimensions('70%', '70%');
            // 设置表单提示值
            $grid->quickSearch(['subject'])->placeholder('搜索...');
            //导出
            $grid->export()->filename('申报管理');
            // 显示快捷编辑按钮
            $grid->showQuickEditButton();
            // 禁用编辑按钮
            $grid->disableEditButton();
            $grid->disableViewButton();
            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局
                $filter->panel();
                // 注意切换为panel布局方式时需要重新调整表单字段的宽度
                $filter->like('subject')->width(3);
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
        return Show::make($id, new EmsSubject(), function (Show $show) {
            $show->field('id');
            $show->field('subject');
            $show->field('subject_dept');
            $show->field('subject_desc');
            $show->field('subject_set');
            $show->field('subject_status');
            $show->field('subject_uesrs');
            $show->field('create_by');
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
        return Form::make(new EmsSubject(), function (Form $form) {
            $user = Admin::user()->id;
            $form->display('id');
            $form->create_by = Admin::user()->id;
            $form->block(7, function (Form\BlockForm $form) {
                $form->text('subject')->required();
                $form->text('subject_dept')->required();
                $form->embeds('subject_set', function ($form) {
                    $form->select('major')->options(function () {
                        $majorModel = EmsMajor::class;
                        return $majorModel::all()->pluck('major_name', 'id');
                    })->required();
                    $form->select('decl_name')->options(function () {
                        $categoryModel = EmsDeclaration::class;
                        return $categoryModel::all()->pluck('decl_name', 'id');
                    })->required();
                })->saving(function ($v) {
                    return json_encode($v);
                })->required();
                $form->textarea('subject_desc')->rows(5);
            });
            // 分块显示
            $form->block(5, function (Form\BlockForm $form) {
                $form->title('参加考试人员');
                $form->multipleSelectTable('subject_uesrs', '参加考试人员')
                    ->title("考生信息")
                    ->dialogWidth('50%')
                    ->from(UsersTable::make(['create_by' => Admin::user()->id]))
                    ->model(AdminUser::class, 'id', 'name')
                    ->saveAsJson();
            });
            $form->text('create_by')->default($user)->display(false);
            $form->text('last_by')->default($user)->display(false);

            $form->display('created_at')->display(false);
            $form->display('updated_at')->display(false);
        });
    }
}
