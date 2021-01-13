<?php

namespace App\Admin\Controllers\TiKu;

use App\Admin\Repositories\TiKu\EmsMajor;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class EmsMajorController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new EmsMajor(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->major_name->editable(true);
            $grid->explain;
            $grid->created_at;
            $grid->updated_at->sortable();

            // 设置弹窗宽高，默认值为 '700px', '670px'
            $grid->enableDialogCreate();
            $grid->setDialogFormDimensions('50%', '50%');
            // 设置表单提示值
            $grid->quickSearch(['major_name', 'explain'])->placeholder('搜索...');
            //导出
            $grid->export()->filename('申报专业数据');
            // 显示快捷编辑按钮
            $grid->showQuickEditButton();
            // 禁用编辑按钮
            $grid->disableEditButton();

            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局
                $filter->panel();
                // 注意切换为panel布局方式时需要重新调整表单字段的宽度
                $filter->like('major_name')->width(3);
                $filter->equal('explain')->width(3);

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
        return Show::make($id, new EmsMajor(), function (Show $show) {
            $show->field('id');
            $show->field('major_name');
            $show->field('explain');
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
        return Form::make(new EmsMajor(), function (Form $form) {
            $form->display('id');
            $form->text('major_name')->required();
            $form->textarea('explain')->rows(5);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
