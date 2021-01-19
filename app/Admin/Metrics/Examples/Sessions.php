<?php

namespace App\Admin\Metrics\Examples;

use App\Models\KaoShi\EmsExamhistory;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Bar;
use Illuminate\Http\Request;

class Sessions extends Bar
{
    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();

        $color = Admin::color();

        $dark35 = $color->blue();

        // 卡片内容宽度
        $this->contentWidth(4, 6);
        // 标题
        $this->title('考试情况');
        // 设置下拉选项
        $this->subTitle('最新统计');
        // 设置图表颜色
        $this->chartColors([
            $dark35,
            $dark35,
            $color->primary(),
            $dark35,
            $dark35,
            $dark35
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
        $count = EmsExamhistory::all()->count();
        $yes_count = EmsExamhistory::where('ems_ispass', 1)->count();
        if ($yes_count) {
            $value = ($yes_count / $count) * 100;
        } else {
            $value = 0;
        }

        $data = EmsExamhistory::select('ems_score')->orderBy('ems_decidetime', 'desc')->limit(10)->get();
        $datas = [];
        if ($data) {
            foreach (json_decode($data) as $t) {
                array_push($datas, $t->ems_score);
            }
        } else {
            $count = 0;
        }

        switch ($request->get('option')) {
            case '7':
            default:
                // 卡片内容
                $this->withContent($count . ' / 人', $value . ' %');
                // 图表数据
                $this->withChart([
                    [
                        'name' => '得分',
                        'data' => $datas,
                    ],
                ]);
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
            'series' => $data,
        ]);
    }

    /**
     * 设置卡片内容.
     *
     * @param string $title
     * @param string $value
     * @param string $style
     *
     * @return $this
     */
    public function withContent($title, $value, $style = 'success')
    {
        // 根据选项显示
        $label = strtolower(
            $this->dropdown[request()->option] ?? '考生通过考试'
        );

        $minHeight = '200px';

        return $this->content(
            <<<HTML
<div class="d-flex p-1 flex-column justify-content-between" style="padding-top: 0;width: 100%;height: 100%;min-height: {$minHeight}">
    <div class="text-left">
        <h1 class="font-lg-2 mt-2 mb-0">{$title}</h1>
        <h5 class="font-medium-2" style="margin-top: 10px;">
            <span class="text-{$style}">{$value} </span>
            <span>{$label}</span>
        </h5>
    </div>
    <a href="/admin/KaoShi/EmsExamhistory" class="btn btn-primary shadow waves-effect waves-light">查看详情<i class="feather icon-chevrons-right"></i></a>
</div>
HTML
        );
    }
}
