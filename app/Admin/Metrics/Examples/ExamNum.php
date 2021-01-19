<?php

namespace App\Admin\Metrics\Examples;

use App\Models\KaoShi\EmsExam;
use App\Models\KaoShi\EmsSubject;
use Dcat\Admin\Widgets\Metrics\Line;
use Illuminate\Http\Request;

class ExamNum extends Line
{
    /**
     * 初始化卡片内容
     *
     * @return void
     */
    protected function init()
    {
        parent::init();

        $this->title('试卷数量');
        $this->subTitle('目前试卷数量');
        $this->height(193);
//        $this->dropdown([
//            '1' => '当日',
//            '7' => '7天内',
//            '30' => '30天内'
//        ]);
    }

    /**
     * 处理请求
     *
     * @param Request $request
     *
     * @return mixed|void
     */
    public function handle(Request $request)
    {
        $count = EmsExam::all()->count();
        // 卡片内容
        $this->withContent($count);
        $this->withChart([]);
    }

    /**
     * 设置图表数据.
     *
     * @param array $data
     *
     * @return $this
     */
    public function withChart(array $data)
    {
        return $this->chart([
            'series' => [
                [
                    'name' => $this->title,
                    'data' => $data,
                ],
            ],
        ]);
    }

    /**
     * 设置卡片内容.
     *
     * @param string $content
     *
     * @return $this
     */
    public function withContent($content)
    {
        return $this->content(
            <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px;">
    <h2 class="ml-1 font-lg-2"><i class="fa fa-file-text" style="color: rgba(65, 153, 222, 0.95)"></i>&nbsp;&nbsp;&nbsp;&nbsp;{$content}</h2>
</div>
HTML
        );
    }
}
