<?php

namespace App\Admin\Forms;

use App\Imports\AdminUsersImport;
use App\Models\KaoShi\AdminRoleUsers;
use App\Models\KaoShi\AdminUser;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\Storage;
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
     * @return \Dcat\Admin\Http\JsonResponse
     */
    public function handle(array $input)
    {
        // 下面的代码获取到上传的文件，然后使用`maatwebsite/excel`等包来处理上传你的文件，保存到数据库
        $file = $input['file'];
        if (!$file) {
            return $this->response()->error('请先上传文件');
        }
        // 导入
        Excel::import(new AdminUsersImport(), $file, 'admin');
        //导入成功后删除文件
        $disk = Storage::disk('admin');
        $disk->delete($file);
        // 数据处理
        try {
            // 数据导入后获取登录用户名为null的所有用户
            $data = AdminUser::where('username', null)->get();
            // 获取当前登录用户id
            $admin_id = Admin::user()->id;
            // 遍历处理数据
            foreach ($data as $iValue) {
                // 通过身份证号自动生成用户名和密码
                $user = AdminUser::find($iValue->id);
                $user->username = 'zy@' . substr($iValue->pid_number, -4) . random_int(1000, 9999); // 登录用户名为 'zy@身份证号后4位+4位随机数'
                $user->password = bcrypt('zy' . substr($iValue->pid_number, -6) . substr($iValue->user_phone, -4)); // 密码为身份证后 6 位+手机号后 4 位
                $user->create_by = $admin_id;//创建管理员ID
                $user->save();

                // 自动分配考生权限
                $roleDatas = new AdminRoleUsers;
                $roleDatas->role_id = 5;  // 5 为考试权限
                $roleDatas->user_id = $iValue->id;
                $roleDatas->save();
            }
            return $this->response()->success('导入完成！')->refresh();
        } catch (\Exception $e) {
            return $this->response()->error('导入失败')->refresh();
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
