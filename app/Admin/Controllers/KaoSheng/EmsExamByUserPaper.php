<?php


namespace App\Admin\Controllers\KaoSheng;

use App\Models\KaoShi\EmsExamsession;
use Dcat\Admin\Admin;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\URL;

class EmsExamByUserPaper implements Renderable
{
    // 定义页面所需的静态资源，这里会按需加载
    public static $js = [
        'emsexam/time/jquery.countdown.js',
        'emsexam/jquery.easy-pie-chart.js',
    ];
    public static $css = [
        'emsexam/test.css',
    ];

    public function script()
    {
        return <<<JS
JS;
    }

    public function render()
    {
        // 在这里可以引入你的js或css文件
        Admin::js(static::$js);
        Admin::css(static::$css);
        // 需要在页面执行的JS代码
        // 通过 Admin::script 设置的JS代码会自动在所有JS脚本都加载完毕后执行
        Admin::script($this->script());
        // 获取url路径后面的考场ID
        $url = URL::full();
        $url_a = strstr($url, 'EmsKaoShi/');
        $basic_id = substr($url_a, strpos($url_a, '/') + 1);
        $basic_id = substr($basic_id, 0, strrpos($basic_id, '/'));
        $basic_id = base64_decode($basic_id); //解密

        //判断当前登录用户 通过ID 获取自考生临时记录
        $user_id = Admin::user()->id;
        $user_name = Admin::user()->name;
        $examDatas = EmsExamsession::with(['emsBasic', 'emsExam', 'emsSubject'])->where('session_user_id', $user_id)->where('session_basic_id', $basic_id)->get();

        $basic_name = $examDatas[0]->emsBasic->basic; //考场名
        $subject_name = $examDatas[0]->emsSubject->subject; //科目名
        $exam_name = $examDatas[0]->emsExam->exam_name; //试卷名
        $sum_time = $examDatas[0]->session_sum_time; //总时长
        $allscore = $examDatas[0]->session_allscore; //总分
        $id = $examDatas[0]->id;
        $token_status = $examDatas[0]->session_token_status; //表单状态 默认为0 状态为1则为交卷 数据插入成绩表 之后删除临时表该条数据
        $exam_question = json_decode($examDatas[0]->session_exam_question); //试题
        $ems_starttime = time(); //开始时间 时间戳

        //随机打乱试题
        for ($i = 0, $iMax = count($exam_question); $i < $iMax; $i++) {
            $a_data = $exam_question[$i]->questions;
            shuffle($a_data);
            $exam_question[$i]->questions = $a_data;
        }
        // 提交成功后跳转url
        $success_url = admin_url('/KaoSheng/EmsHistory');

        $exam_select = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];//选项

        return view('exam.exam_user', ['name' => $basic_name,
            'sum_time' => $sum_time,
            'subject_name' => $subject_name,
            'token_status' => $token_status,
            'exam_question' => $exam_question,
            'user_name' => $user_name,
            'user_id' => $user_id,
            'exam_name' => $exam_name,
            'allscore' => $allscore,
            'exam_select' => $exam_select,
            'basic_id' => $basic_id,
            'ems_starttime' => $ems_starttime,
            'success_url' => $success_url,
            'id' => $id])->render();
    }
}
