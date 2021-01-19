<?php

namespace App\Admin\Metrics\Examples;

use App\Models\KaoShi\EmsExamhistory;
use App\Models\KaoShi\EmsExamsession;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Donut;

class ExamInfoHome extends Donut
{
    protected $labels = ['已提交', '未提交'];

    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();

        $color = Admin::color();
        $colors = [$color->primary(), $color->alpha('blue2', 0.5)];

        $this->title('考试情况');
        $this->subTitle('最新考试情况');
        $this->height(193);
        $this->chartLabels($this->labels);
        // 设置图表颜色
        $this->chartColors($colors);
    }

    /**
     * 渲染模板
     *
     * @return string
     */
    public function render()
    {
        $this->fill();

        return parent::render();
    }

    /**
     * 写入数据.
     *
     * @return void
     */
    public function fill()
    {
        try {
            $a_num = EmsExamhistory::all()->count();
            $b_num = EmsExamsession::all()->count();
            $this->withContent($a_num, $b_num);
            // 图表数据
            $this->withChart([$a_num, $b_num]);
        }catch (\Exception $e){
            $this->withContent(0, 0);
            // 图表数据
            $this->withChart([1, 1]);
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
            'series' => $data
        ]);
    }

    /**
     * 设置卡片头部内容.
     *
     * @param mixed $desktop
     * @param mixed $mobile
     *
     * @return $this
     */
    protected function withContent($desktop, $mobile)
    {
        $blue = Admin::color()->alpha('blue2', 0.5);

        $style = 'margin-bottom: 8px';
        $labelWidth = 220;

        return $this->content(
            <<<HTML
<br>
<div class="d-flex pl-1 pr-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle text-primary ml-1 font-md-2"></i> <span class="ml-1 font-md-2">{$this->labels[0]}</span>
    </div>
    <div class="ml-1 font-md-2 font-weight-bold text-primary">{$desktop}</div>
</div>
<br>
<div class="d-flex pl-1 pr-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle ml-1 font-md-2" style="color: $blue"></i><span class="ml-1 font-md-2"> {$this->labels[1]}</span>
    </div>
    <div class="ml-1 font-md-2 font-weight-bold" style="color: $blue">{$mobile}</div>
</div>
HTML
        );
    }
}
