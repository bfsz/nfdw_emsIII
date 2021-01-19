<?php


namespace App\Admin\Pages\index;

use Dcat\Admin\Admin;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;

class ShenBaoHomeTab implements Renderable
{
    public function render()
    {
        $data = $this->statement();
        return view('backstage.index.ShenBao_tab', ['data' => json_encode($data)]);
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
        $login_id = Admin::user()->id;
        $ems_subject = DB::table('ems_subject')->where('create_by', $login_id)->count();
        $admin_users = DB::table('admin_users')->where('create_by', $login_id)->count();
        $data = ['ems_subject' => $ems_subject, 'admin_users' => $admin_users];
        return $data;
    }
}
