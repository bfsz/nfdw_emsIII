<?php

namespace App\Admin\Metrics\Examples;

use App\Models\KaoShi\EmsSubject;
use Dcat\Admin\Widgets\Metrics\Line;
use Illuminate\Http\Request;

class DeclareHome extends Line
{
    /**
     * 初始化卡片内容
     *
     * @return void
     */
    protected function init()
    {
        parent::init();

        $this->title('申报数量');
        $this->height(193);
        $this->dropdown([
            '1' => '当日',
            '7' => '7天内',
            '30' => '30天内'
        ]);
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
        switch ($request->get('option')) {
            case '1':
                $date = date("Y-m-d");
                $count = EmsSubject::where('created_at','=',$date)->count();
                // 卡片内容
                $this->withContent($count);
                $this->withChart([]);
                break;
            case '7':
                $date = date('Y-m-d',strtotime('-7 day'));
                $count = EmsSubject::where('created_at','>=',$date)->count();
                // 卡片内容
                $this->withContent($count);
                // 图表数据
                $this->withChart([]);
                break;
            case '30':
                $date = date('Y-m-d',strtotime('-30 day'));
                $count = EmsSubject::where('created_at','>=',$date)->count();
                // 卡片内容
                $this->withContent($count);
                // 图表数据
                $this->withChart([]);
                break;
            default:
                $date = date("Y-m-d");
                $count = EmsSubject::where('created_at','=',$date)->count();
                // 卡片内容
                $this->withContent($count);
                $this->withChart([]);
                // 图表数据
                break;
        }
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
    <h2 class="ml-1 font-lg-2"><i class="fa fa-bell" style="color: rgba(65, 153, 222, 0.95)"></i>&nbsp;&nbsp;&nbsp;&nbsp;{$content}</h2>
    <span class="mb-0 mr-1 text-80">{$this->title}</span>
</div>
HTML
        );
    }
}
