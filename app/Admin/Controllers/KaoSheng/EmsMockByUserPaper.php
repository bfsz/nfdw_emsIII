<?php


namespace App\Admin\Controllers\KaoSheng;

use App\Models\KaoSheng\EmsMockexam;
use App\Models\KaoShi\EmsExamsession;
use Dcat\Admin\Admin;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\URL;

class EmsMockByUserPaper implements Renderable
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
        $url_a = strstr($url, 'EmsMock/');
        $mock_id = substr($url_a, strpos($url_a, '/') + 1);
        $mock_id = substr($mock_id, 0, strrpos($mock_id, '/'));
        $mock_id = base64_decode($mock_id); //解密

        //判断当前登录用户通过id 获取考生id
        $user_id = Admin::user()->id;
        $mockDatas = EmsMockexam::with(['major', 'declaration'])->where('mkems_byid', $user_id)->where('id', $mock_id)->get();

        $mock_name = $mockDatas[0]->mkems_name;
        $mock_question = json_decode($mockDatas[0]->mkems_question); //试题
        $mock_count = $mockDatas[0]->mkems_question_count;
        $mock_startdate = time(); //开始时间 时间戳
        $success_url = admin_url('/KaoSheng/EmsMockexam');// 提交成功后跳转url
        $mock_select = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];//选项
        return view('exam.mock_user', ['name' => $mock_name,
            'mock_question' => $mock_question[0],
            'user_id' => $user_id,
            'mock_id' => $mock_id,
            'mock_startdate' => $mock_startdate,
            'mock_count' => $mock_count,
            'success_url' => $success_url,
            'mock_select' => $mock_select])->render();
    }
}
