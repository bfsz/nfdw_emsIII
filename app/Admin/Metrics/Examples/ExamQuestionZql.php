<?php

namespace App\Admin\Metrics\Examples;
use App\Models\KaoShi\EmsExamhistory;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Donut;

class ExamQuestionZql extends Donut
{
    protected $labels = ['总题数', '正确数','答错数'];

    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();

        $color = Admin::color();
        $colors = [$color->primary(), $color->alpha('blue2', 0.5),$color->alpha('red', 0.5)];

        $this->title('试题分析（已做试题）');
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
            $user_id = Admin::user()->id; //登录用户ID
            $score = EmsExamhistory::where('ems_user_id', $user_id)->get('ems_scorelist');
            $score_data = json_decode($score);
            $all_count = 0; //总题数
            $sure_count = 0; //正确数
            for ($i = 0; $i < count($score); $i++) {
                $count = count(json_decode($score_data[$i]->ems_scorelist));
                $data = json_decode($score_data[$i]->ems_scorelist);
                $all_count += $count;
                for ($j = 0; $j < $count; $j++) {
                    if($data[$j]->status == 1){
                        $sure_count++;
                    }
                }
            }
            $error_count = $all_count-$sure_count;
            $this->withContent($all_count,$sure_count, $error_count);
            // 图表数据
            $this->withChart([$all_count,$sure_count, $error_count]);
        }catch (\Exception $e){
            $this->withContent(0,0, 0);
            // 图表数据
            $this->withChart([0,0,0]);
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
     * @param mixed $all
     * @param mixed $true
     * @param mixed $error
     *
     * @return $this
     */
    protected function withContent($all,$true,$error)
    {
        $blue = Admin::color()->alpha('blue2', 0.5);
        $blue1 = Admin::color()->alpha('red', 0.5);

        $style = 'margin-bottom: 8px';
        $labelWidth = 120;

        return $this->content(
            <<<HTML
<div class="d-flex pl-1 pr-1 pt-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle text-primary"></i> {$this->labels[0]}
    </div>
    <div>{$all}</div>
</div>
<div class="d-flex pl-1 pr-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle" style="color: $blue"></i> {$this->labels[1]}
    </div>
    <div>{$true}</div>
</div>
<div class="d-flex pl-1 pr-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle" style="color: $blue1"></i> {$this->labels[2]}
    </div>
    <div>{$error}</div>
</div>
HTML
        );
    }
}
