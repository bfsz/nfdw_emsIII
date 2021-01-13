<?php

namespace App\Admin\Controllers\KaoShi;

use App\Admin\Actions\Grid\GridAdminUsersData;
use App\Models\KaoShi\AdminRoleUsers;
use App\Models\KaoShi\AdminUser;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class AdminUserController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $create_by = Admin::user()->id;
        $data = AdminUser::where('create_by', $create_by)->orderByDesc('created_at');//创建人可看
        return Grid::make($data, function (Grid $grid) {
            $grid->id->sortable();
            $grid->username;
            $grid->password->limit(10);
            $grid->name;
            $grid->project_dept;
            $grid->organ_name;
            $grid->pid_number->copyable()->qrcode(function () {
                return $this->pid_number;
            }, 200, 200);
            $grid->user_phone->copyable()->qrcode(function () {
                return $this->user_phone;
            }, 200, 200);
            // 快捷查询
            $grid->quickSearch(['name', 'username', 'project_dept', 'organ_name', 'pid_number'])->placeholder('搜索...');
            // 禁用查看按钮、编辑按钮
            $grid->disableViewButton();
            $grid->disableEditButton();
            $grid->enableDialogCreate();
            // 启用快捷编辑
            $grid->showQuickEditButton();

            $grid->export()->filename('考生数据');
            //导入
            $grid->tools(new GridAdminUsersData());
            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局
                $filter->panel();
                $filter->equal('id')->width(3);
                $filter->like('username')->width(3);
                $filter->like('name')->width(3);
                $filter->like('project_dept')->width(3);
                $filter->like('organ_name')->width(3);
                $filter->like('pid_number')->width(3);
                $filter->between('created_at')->datetime()->width(3);
                $filter->scope('new', '最近修改')
                    ->whereDate('created_at', date('Y-m-d'))
                    ->orWhere('updated_at', date('Y-m-d'));
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
        return Show::make($id, new AdminUsers(), function (Show $show) {
            $show->id;
            $show->username;
            $show->password;
            $show->name;
            $show->avatar;
            $show->remember_token;
            $show->project_dept;
            $show->organ_name;
            $show->pid_number;
            $show->created_at;
            $show->updated_at;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {

        $create_by = $user = Admin::user()->id;
        $data = AdminUser::where('create_by', $create_by);
        return Form::make($data, function (Form $form) {
            $id = $form->getKey();
            $form->display('id');
            $form->text('username')->required();
            if ($id) {
                $form->password('password', trans('admin.password'))
                    ->minLength(5)
                    ->maxLength(20)
                    ->customFormat(function () {
                        return '';
                    });
            } else {
                $form->password('password', trans('admin.password'))
                    ->required()
                    ->minLength(5)
                    ->maxLength(20);
            }

            $form->password('password_confirmation', trans('admin.password_confirmation'))->same('password');
            $form->ignore(['password_confirmation']);


            $form->text('name')->required();
            $form->text('project_dept')->required();
            $form->text('organ_name')->required();
            $form->text('pid_number')->required()->rules('required|max:18');
            $form->mobile('user_phone')->required()->options(['mask' => '999 9999 9999']);
            $form->text('create_by')->default(Admin::user()->id, true)->disable();
            $form->display('created_at');
            $form->display('updated_at');
        })->saving(function (Form $form) {
            $form->create_by = Admin::user()->id;
            //密码加密
            if ($form->password && $form->model()->get('password') != $form->password) {
                $form->password = bcrypt($form->password);
            }
            if (!$form->password) {
                $form->deleteInput('password');
            }
        })->saved(function (Form $form) {
            //新增考生保存后，自动分配考生权限
            $id = $form->getKey();
            $status = AdminRoleUsers::where('user_id', $id)->count();
            $admin_id = Admin::user()->id;
            if ($status === 0) {
                $roleDatas = new AdminRoleUsers;
                $roleDatas->role_id = 5;
                $roleDatas->user_id = $id;
                $roleDatas->save();
                return $form->response()->success('新增成功，用户权限已自动分配为【考生】')->refresh();
            }
            return $form->response()->success('错误，请联系管理员')->refresh();
        });
    }
}

