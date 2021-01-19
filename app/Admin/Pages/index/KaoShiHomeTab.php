<?php


namespace App\Admin\Pages\index;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;

class KaoShiHomeTab implements Renderable
{
    public function render()
    {
        $data = $this->statement();
        return view('backstage.index.KaoShi_tab', ['data' => json_encode($data)]);
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
        $ems_exams = DB::table('ems_exams')->count();//试卷统计
        $ems_examsession = DB::table('ems_examsession')->count();//正在考试
        $ems_subject = DB::table('ems_subject')->count();//申报统计
        $ems_examhistory= DB::table('ems_examhistory')->count();//成绩统计
        $data = ['ems_exams' => $ems_exams, 'ems_examsession' => $ems_examsession, 'ems_subject' => $ems_subject, 'ems_examhistory' => $ems_examhistory];
        return $data;
    }
}
