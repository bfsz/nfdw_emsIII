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
            $grid->id->sortable();
            $grid->type_name->editable(true);
//            $grid->sort->editable(true);
            $grid->type_choice->select([1 => '主观题', 2 => '客观题']);
            $grid->created_at;
            $grid->updated_at->sortable();

            //显示边框
//            $grid->withBorder();
            // 设置弹窗宽高，默认值为 '700px', '670px'
            $grid->enableDialogCreate();
            $grid->setDialogFormDimensions('50%', '50%');
            // 设置表单提示值
            $grid->quickSearch(['type_name'])->placeholder('搜索...');
            //导出
            $grid->export()->filename('题库题型数据');
            // 显示快捷编辑按钮
            $grid->showQuickEditButton();
            // 禁用编辑按钮
            $grid->disableEditButton();

            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局
                $filter->panel();
                // 注意切换为panel布局方式时需要重新调整表单字段的宽度
                $filter->like('type_name')->width(3);
                $filter->equal('type_choice')->select([1 => '主观题', 2 => '客观题'])->width(3);
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
//            $show->field('sort');
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
//            $form->text('sort');
            $form->select('type_choice')->options([1 => '主观题', 2 => '客观题']);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
