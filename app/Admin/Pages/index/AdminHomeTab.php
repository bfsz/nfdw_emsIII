<?php


namespace App\Admin\Pages\index;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;

class AdminHomeTab implements Renderable
{
    public function render()
    {
        $data = $this->statement();
        return view('backstage.index.home_tab', ['data' => json_encode($data)]);
    }

    /**
     * Notes: 首页卡片统计
     * User: 62726
     * Date: 2020/12/16
     * Time: 9:25
     * @return array
     */
    public function statement()
    {
        $admin_users = DB::table('admin_users')->count();
        $admin_roles = DB::table('admin_roles')->count();
        $admin_operation_log = DB::table('admin_operation_log')->where('input','<>','[]')->count();
        $data = ['admin_users' => $admin_users, 'admin_roles' => $admin_roles, 'admin_operation_log' => $admin_operation_log];
        return $data;
    }
}
