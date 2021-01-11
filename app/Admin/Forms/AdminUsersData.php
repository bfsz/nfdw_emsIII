<?php

namespace App\Admin\Forms;

use App\Imports\AdminUsersImport;
use App\Models\KaoShi\AdminRoleUsers;
use App\Models\KaoShi\AdminUsers;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Form;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;

class AdminUsersData extends Form
{
    // 增加一个自定义属性保存用户ID
    protected $id = 'DATA_USER';

    // 构造方法的参数必须设置默认值
    public function __construct($id = null)
    {
        $this->id = $id;

        parent::__construct();
    }

    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return Response
     */
    public function handle(array $input)
    {
        // 下面的代码获取到上传的文件，然后使用`maatwebsite/excel`等包来处理上传你的文件，保存到数据库
        $file = $input['file'];
        if (!$file) {
            return $this->error('请先上传文件');
        }
        // 导入
        Excel::import(new AdminUsersImport(), $file, 'admin');

        // 数据处理
        try {
            // 数据导入后获取登录用户名为null的所有用户
            $data = AdminUsers::where('username', null)->get();
            // 获取当前登录用户id
            $admin_id = Admin::user()->id;
            // 遍历处理数据
            for ($i = 0, $iMax = count($data); $i < $iMax; $i++) {
                // 通过身份证号自动生成用户名和密码
                $user = AdminUsers::find($data[$i]->id);
                $user->username = $data[$i]->pid_number; // 登录用户名为身份证号
                $user->password = bcrypt('zy' . substr($data[$i]->pid_number, -6)); // 密码为身份证后 6 位
                $user->create_by=$admin_id;//创建管理员ID
                $user->save();

                // 自动分配考生权限
                $roleDatas = new AdminRoleUsers;
                $roleDatas->role_id = 4;  // 4 为考试权限
                $roleDatas->user_id = $data[$i]->id;
                $roleDatas->save();
            }
            return $this->success('导入完成！');
        } catch (\Exception $e) {
            return $this->success('导入完成！');
        }
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->file('file', '请选择文件')
            ->disk('admin')
            ->autoUpload()
            ->accept('xlsx,xls,csv');
    }
}
