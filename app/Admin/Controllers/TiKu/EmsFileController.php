<?php

namespace App\Admin\Controllers\TiKu;

use App\Admin\Repositories\TiKu\EmsFile;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class EmsFileController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new EmsFile(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('file_name');
            $grid->column('file_desc');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            if (!(Admin::user()->isRole('administrator'))) {
                // 禁用删除
                $grid->disableDeleteButton();
                $grid->disableBatchDelete();
                $grid->disableQuickEditButton();
            }
            $grid->disableQuickEditButton(false);
            $grid->disableEditButton(true);
            $grid->setActionClass(Grid\Displayers\Actions::class);
            $grid->quickSearch(['file_name', 'file_desc'])->placeholder('搜索...');
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
        return Show::make($id, new EmsFile(), function (Show $show) {
            $show->field('id');
            $show->field('file_name');
            $show->field('file_desc');
            $show->field('file_path')->file();
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
        return Form::make(new EmsFile(), function (Form $form) {
            $form->display('id');
            $form->text('file_name')->required();
            $form->textarea('file_desc');
            $form->file('file_path')->autoUpload()->required();

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
