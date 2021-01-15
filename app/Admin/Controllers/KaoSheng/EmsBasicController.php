<?php

namespace App\Admin\Controllers\KaoSheng;

use App\Models\KaoShi\EmsBasic;
use App\Models\KaoShi\EmsExamsession;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;

class EmsBasicController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('考场')
            ->description('已申报参加的考试')
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
            $user_id = Admin::user()->id; //登录用户ID
            $grid->id->display(function ($value) {
                return "<span class=\"badge badge-pill badge-success\">$value</span>";
            })->sortable();
            $grid->basic;
            $grid->basic_desc->limit(50);
            $grid->basic_staus->using([1 => '开启', 0 => '关闭'])
                ->dot(
                    [
                        1 => 'success',
                        0 => 'danger',
                    ]
                );
//            $grid->column('emsExam.session_exam_url', '进入考试')->link();
            $grid->column('emsExam.session_exam_url', '进入考试')->display(function ($value) {
                return '<a href="' . $value . '" target="_blank">进入考试</a>';
            });
            $grid->column('emsExam.session_sum_time', '考试时间')->display(function ($value) {
                return "<span class=\"badge badge-pill badge-danger\">$value / 分钟</span>";
            });
            $grid->created_at->sortable();
            // 禁用
            $grid->disableRowSelector();
            $grid->disableActions();
            $grid->disableEditButton();
            $grid->disableDeleteButton();
            $grid->disableCreateButton();
            $grid->disableFilterButton();
            $grid->disableQuickEditButton();
            $grid->disablePagination();
            $grid->quickSearch(['basic'])->placeholder('考场名...');
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
        return Show::make($id, $this->info(), function (Show $show) {
            $show->id;
            $show->basic;
            $show->basic_staus->using([1 => '开启', 0 => '关闭'])
                ->dot(
                    [
                        1 => 'success',
                        0 => 'danger',
                    ]
                );
            $show->divider();
            $show->disableDeleteButton();
            $show->disableEditButton();
            $show->basic_desc;
        });
    }

    // 页面数据逻辑
    public function info()
    {
        $user_id = Admin::user()->id; //登录用户ID
        $flag = EmsExamsession::where('session_user_id', $user_id)->exists();
        if ($flag != false) {
            $data = EmsExamsession::where('session_user_id', $user_id)->get(['session_basic_id', 'id']);
            // 判断当前登录用户 是否有正在开启的考场
            $is_users = [];
            for ($i = 0, $iMax = count($data); $i < $iMax; $i++) {
                $basic_id = $data[$i]->session_basic_id; //考场ID
                array_push($is_users, $basic_id);
            }
            //如果没有当前用户 id 则为 null
            if (!$is_users) {
                $is_user = null;
            }
            // 模型一对一关联
            $datas = EmsBasic::with(['emsSubject', 'emsExam'])->where('basic_staus', 1)->whereIn('id', $is_users);
        } else {
            $datas = EmsBasic::with(['emsSubject', 'emsExam'])->where('id', 0); //当临时表单状态为1 查询为空
        }
        return $datas;
    }
}
