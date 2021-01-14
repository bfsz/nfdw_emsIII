<?php


namespace App\Admin\Metrics\Examples;


use App\Models\KaoShi\AdminUser;
use App\Models\KaoShi\EmsBasic;
use App\Models\KaoShi\EmsSubject;
use Dcat\Admin\Support\LazyRenderable;
use Dcat\Admin\Widgets\Table;

class EmsExamUser extends LazyRenderable
{
    public function render()
    {
        // 获取ID
        $id = $this->key;
        $data = EmsBasic::where('id', $id)
            ->get(['basic_subject_id']);
        $basic_id = $data[0]->basic_subject_id;
        $user_date = EmsSubject::where('id', $basic_id)->get(['subject_uesrs']);
        $data_a = json_decode($user_date[0]->subject_uesrs);
        // 判断是否有数据
        if ($data_a) {
            $questions_datas = AdminUser::whereIn('id', $data_a)->get(['id', 'name', 'project_dept', 'organ_name', 'pid_number'])->toArray();
        } else {
            $questions_datas = [];
        }

        $titles = [
            'ID',
            '姓名',
            '项目责任部门',
            '单位名称',
            '身份证号',
        ];

        return Table::make($titles, $questions_datas);
    }
}
