<?php


namespace App\Renderable;


use App\Models\KaoShi\AdminUser;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;

class UsersTable extends LazyRenderable
{

    public function grid(): Grid
    {
        // 获取外部传递的参数
        $create_by = $this->create_by;
        return Grid::make(AdminUser::where('create_by', $create_by), function (Grid $grid) {
            $grid->column('id');
            $grid->column('username', '用户名');
            $grid->column('name', '姓名');
            $grid->column('project_dept', '部门');
            $grid->column('organ_name', '单位');
            $grid->column('pid_number', '身份证号');
            $grid->column('user_phone', '手机号');
            $grid->rowSelector()->titleColumn('name');
            $grid->quickSearch(['name', 'project_dept', 'organ_name', 'pid_number', 'user_phone']);
            $grid->paginate(20);
            $grid->disableActions();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('username')->width(4);
                $filter->like('name')->width(4);
            });
        });
    }
}
