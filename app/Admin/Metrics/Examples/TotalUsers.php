<?php

namespace App\Admin\Metrics\Examples;

use App\Models\KaoShi\AdminUser;
use Dcat\Admin\Widgets\Metrics\Card;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class TotalUsers extends Card
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

        $this->title('用户数量');
        $this->height(193);
        $this->dropdown([
            '1' => '系统管理员',
            '2' => '题库管理员',
            '3' => '考试管理员',
            '4' => '申报管理员',
            '5' => '考生'
        ]);
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
            switch ($request->get('option')) {
                case '1':
                    $data = AdminUser::whereHasIn('adminRoles', function ($q) {
                        $q->where('id', 1);
                    })->count();
                    $this->content(random_int($data, $data));
                    break;
                case '2':
                    $data = AdminUser::whereHasIn('adminRoles', function ($q) {
                        $q->where('id', 2);
                    })->count();
                    $this->content(random_int($data, $data));
                    break;
                case '3':
                    $data = AdminUser::whereHasIn('adminRoles', function ($q) {
                        $q->where('id', 3);
                    })->count();
                    $this->content(random_int($data, $data));
                    break;
                case '4':
                    $data = AdminUser::whereHasIn('adminRoles', function ($q) {
                        $q->where('id', 4);
                    })->count();
                    $this->content(random_int($data, $data));
                    break;
                case '5':
                    $data = AdminUser::whereHasIn('adminRoles', function ($q) {
                        $q->where('id', 5);
                    })->count();
                    $this->content(random_int($data, $data));
                    break;
                default:
                    $data = AdminUser::whereHasIn('adminRoles', function ($q) {
                        $q->where('id', 1);
                    })->count();
                    $this->content(random_int($data, $data));
            }
        } catch (\Exception $e) {
            $this->content(random_int(0, 0));
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
            "<i class=\"feather icon-trending-up text-success\"></i> {$percent}% Increase"
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
            "<i class=\"feather icon-trending-down text-danger\"></i> {$percent}% Decrease"
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
    <h2 class="ml-1 font-lg-2"><i class="fa fa-users" style="color: rgba(65, 153, 222, 0.95)"></i>&nbsp;&nbsp;&nbsp;&nbsp;{$content}</h2>
</div>
<div class="ml-1 mt-1 font-weight-bold text-80">
<br>
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
