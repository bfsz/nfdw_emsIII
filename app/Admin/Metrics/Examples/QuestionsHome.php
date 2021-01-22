<?php

namespace App\Admin\Metrics\Examples;

use App\Models\TiKu\EmsQuestion;
use App\Models\TiKu\EmsQuestype;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\RadialBar;
use Illuminate\Http\Request;


class QuestionsHome extends RadialBar
{
    /**
     * 初始化卡片内容
     */
    protected function init()
    {

        parent::init();
        $this->title('题目数量');
        $this->height(200);
        $this->chartHeight(170);
        $this->chartLabels('题型占比');
        $this->dropdown($this->question_tool());
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
        $all = EmsQuestion::all()->count();
        try {
            switch ($request->get('option')) {
                case '0':
                    // 卡片内容
                    $ct1 = EmsQuestion::all()->count();
                    $this->withContent($ct1);
                    // 卡片底部
                    $ct2 = EmsQuestion::where('que_status', 1)->count();
                    $ct3 = EmsQuestion::where('que_status', 0)->count();
                    $this->withFooter($ct2, $ct3);
                    // 图表数据
                    $this->withChart(100);
                    break;
                case '1':
                    // 卡片内容
                    $ct1 = EmsQuestion::where('questype_id', 1)->count();
                    $this->withContent($ct1);
                    // 卡片底部
                    $ct2 = EmsQuestion::where('questype_id', 1)->where('que_status', 1)->count();
                    $ct3 = EmsQuestion::where('questype_id', 1)->where('que_status', 0)->count();
                    $this->withFooter($ct2, $ct3);
                    // 图表数据
                    $ct4 = ($ct2 + $ct3) / $all * 100;
                    $this->withChart($ct4);
                    break;
                case '2':
                    // 卡片内容
                    $ct1 = EmsQuestion::where('questype_id', 2)->count();
                    $this->withContent($ct1);
                    // 卡片底部
                    $ct2 = EmsQuestion::where('questype_id', 2)->where('que_status', 1)->count();
                    $ct3 = EmsQuestion::where('questype_id', 2)->where('que_status', 0)->count();
                    $this->withFooter($ct2, $ct3);
                    // 图表数据
                    $ct4 = ($ct2 + $ct3) / $all * 100;
                    $this->withChart($ct4);
                    break;
                case '3':
                    // 卡片内容
                    $ct1 = EmsQuestion::where('questype_id', 3)->count();
                    $this->withContent($ct1);
                    // 卡片底部
                    $ct2 = EmsQuestion::where('questype_id', 3)->where('que_status', 1)->count();
                    $ct3 = EmsQuestion::where('questype_id', 3)->where('que_status', 0)->count();
                    $this->withFooter($ct2, $ct3);
                    // 图表数据
                    $ct4 = ($ct2 + $ct3) / $all * 100;
                    $this->withChart($ct4);
                    break;
                case '4':
                    // 卡片内容
                    $ct1 = EmsQuestion::where('questype_id', 4)->count();
                    $this->withContent($ct1);
                    // 卡片底部
                    $ct2 = EmsQuestion::where('questype_id', 4)->where('que_status', 1)->count();
                    $ct3 = EmsQuestion::where('questype_id', 4)->where('que_status', 0)->count();
                    $this->withFooter($ct2, $ct3);
                    // 图表数据
                    $ct4 = ($ct2 + $ct3) / $all * 100;
                    $this->withChart($ct4);
                    break;
                case '5':
                    // 卡片内容
                    $ct1 = EmsQuestion::where('questype_id', 5)->where('q')->count();
                    $this->withContent($ct1);
                    // 卡片底部
                    $ct2 = EmsQuestion::where('questype_id', 5)->where('que_status', 1)->count();
                    $ct3 = EmsQuestion::where('questype_id', 5)->where('que_status', 0)->count();
                    $this->withFooter($ct2, $ct3);
                    // 图表数据
                    $ct4 = ($ct2 + $ct3) / $all * 100;
                    $this->withChart($ct4);
                    break;
                case '6':
                    // 卡片内容
                    $ct1 = EmsQuestion::where('questype_id', 6)->count();
                    $this->withContent($ct1);
                    // 卡片底部
                    $ct2 = EmsQuestion::where('questype_id', 6)->where('que_status', 1)->count();
                    $ct3 = EmsQuestion::where('questype_id', 6)->where('que_status', 0)->count();
                    $this->withFooter($ct2, $ct3);
                    // 图表数据
                    $ct4 = ($ct2 + $ct3) / $all * 100;
                    $this->withChart($ct4);
                    break;
                case '7':
                    // 卡片内容
                    $ct1 = EmsQuestion::where('questype_id', 7)->count();
                    $this->withContent($ct1);
                    // 卡片底部
                    $ct2 = EmsQuestion::where('questype_id', 7)->where('que_status', 1)->count();
                    $ct3 = EmsQuestion::where('questype_id', 7)->where('que_status', 0)->count();
                    $this->withFooter($ct2, $ct3);
                    // 图表数据
                    $ct4 = ($ct2 + $ct3) / $all * 100;
                    $this->withChart($ct4);
                    break;
                default:
                    // 卡片内容
                    $ct1 = EmsQuestion::all()->count();
                    $this->withContent($ct1);
                    // 卡片底部
                    $ct2 = EmsQuestion::where('que_status', 1)->count();
                    $ct3 = EmsQuestion::where('que_status', 0)->count();
                    $this->withFooter($ct2, $ct3);
                    // 图表数据
                    $this->withChart(100);
            }
        }catch (\Exception $e){
            $this->withFooter(0, 0);
            // 图表数据
            $this->withChart(0);
        }
    }

    /**
     * 设置图表数据.
     *
     * @param int $data
     *
     * @return $this
     */
    public function withChart(int $data)
    {
        return $this->chart([
            'series' => [$data],
        ]);
    }

    /**
     * 卡片内容
     *
     * @param string $content
     *
     * @return $this
     */
    public function withContent($content)
    {
        return $this->content(
            <<<HTML
<div class="d-flex flex-column flex-wrap text-center">
    <h1 class="font-lg-2 mt-2 mb-0">{$content}</h1>
    <small>总题量</small>
</div>
HTML
        );
    }

    /**
     * 卡片底部内容.
     *
     * @param string $new
     * @param string $open
     * @param string $response
     *
     * @return $this
     */
    public function withFooter($new, $open)
    {
        return $this->footer(
            <<<HTML
<div class="d-flex justify-content-between p-1" style="padding-top: 0!important;">
    <div class="text-center">
        <p>已启用</p>
        <span class="font-lg-1">{$new}</span>
    </div>
    <div class="text-center">
        <p>已停用</p>
        <span class="font-lg-1">{$open}</span>
    </div>
</div>
HTML
        );
    }

    public function question_tool()
    {
        $data = EmsQuestype::all(['id', 'type_name']);
        $arr = [];
        array_push($arr, '总计');
        foreach ($data as $key) {
            $name = $key->type_name;
            array_push($arr, $name);
        }
        return $arr;
    }
}

