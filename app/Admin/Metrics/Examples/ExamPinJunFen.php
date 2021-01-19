<?php

namespace App\Admin\Metrics\Examples;

use App\Models\KaoShi\EmsExamhistory;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Card;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class ExamPinJunFen extends Card
{
    /**
     * 卡片底部内容.
     *
     * @var string|Renderable|\Closure
     */
    protected $footer;

    /**
     * 初始化卡片.
     */
    protected function init()
    {
        parent::init();

        $this->title('平均分');
    }

    /**
     * 处理请求.
     *
     * @param Request $request
     *
     * @return void
     */
    public function handle(Request $request)
    {
        try {
            $user_id = Admin::user()->id; //登录用户ID
            $score = EmsExamhistory::where('ems_user_id', $user_id)->get('ems_score');
            $data = json_decode($score);
            $score = [];
            foreach ($data as $datum) {
                array_push($score, $datum->ems_score);
            }

            //目前得分
            $sum = array_sum($score);
            $count = count($score);
            $avg = sprintf("%01.2f", $sum / $count);
            //上次得分
            $score_last = array_pop($score);
            $sum1 = $sum - $score_last;
            $count1 = $count - 1;
            $avg1 = sprintf("%01.2f", $sum1 / $count1);

            $this->content($avg . ' 分');
            if ($avg >= $avg1) {
                $this->up($avg - $avg1);
            } else {
                $this->down($avg1 - $avg);
            }
        }catch (\Exception $e){
            $this->content( '0 分');
            $this->up(0);
        }
    }

    /**
     * @param int $percent
     *
     * @return $this
     */
    public function up($percent)
    {
        return $this->footer(
            "<i class=\"feather icon-trending-up text-danger\"></i> {$percent}% 上升"
        );
    }

    /**
     * @param int $percent
     *
     * @return $this
     */
    public function down($percent)
    {
        return $this->footer(
            "<i class=\"feather icon-trending-down text-success\"></i> {$percent}% 下降"
        );
    }

    /**
     * 设置卡片底部内容.
     *
     * @param string|Renderable|\Closure $footer
     *
     * @return $this
     */
    public function footer($footer)
    {
        $this->footer = $footer;

        return $this;
    }

    /**
     * 渲染卡片内容.
     *
     * @return string
     */
    public function renderContent()
    {
        $content = parent::renderContent();

        return <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px">
    <h2 class="ml-1 font-lg-1">{$content}</h2>
</div>
<div class="ml-1 mt-1 font-weight-bold text-80">
    {$this->renderFooter()}
</div>
HTML;
    }

    /**
     * 渲染卡片底部内容.
     *
     * @return string
     */
    public function renderFooter()
    {
        return $this->toString($this->footer);
    }
}
