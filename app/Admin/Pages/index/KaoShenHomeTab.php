<?php


namespace App\Admin\Pages\index;

use App\Models\KaoShi\EmsExamhistory;
use App\Models\KaoShi\EmsExamsession;
use Dcat\Admin\Admin;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;

class KaoShenHomeTab implements Renderable
{
    public function render()
    {
        $data = $this->statement();
        return view('backstage.index.KaoShen_tab', ['data' => json_encode($data)]);
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
        $EmsExamsession = EmsExamsession::where('session_user_id', $login_id)->count();
        $EmsExamhistory = EmsExamhistory::where('ems_user_id', $login_id)->count();
        $data = ['EmsExamsession' => $EmsExamsession, 'EmsExamhistory' => $EmsExamhistory];
        return $data;
    }
}
