<?php


namespace App\Admin\Pages\index;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;

class TikuHomeTab implements Renderable
{
    public function render()
    {
        $data = $this->statement();
        return view('backstage.index.tiku_tab', ['data' => json_encode($data)]);
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
        $ems_questions = DB::table('ems_questions')->count();
        $ems_questype = DB::table('ems_questype')->count();
        $ems_major = DB::table('ems_major')->count();
        $ems_declaration = DB::table('ems_declaration')->count();
        $data = ['ems_questions' => $ems_questions, 'ems_questype' => $ems_questype, 'ems_major' => $ems_major, 'ems_declaration' => $ems_declaration];
        return $data;
    }
}
