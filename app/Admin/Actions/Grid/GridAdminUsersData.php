<?php

namespace App\Admin\Actions\Grid;

use App\Admin\Forms\AdminUsersData;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Tools\AbstractTool;

class GridAdminUsersData extends AbstractTool
{
    /**
     * @return string
     */
    protected $title = '导入';

    protected function script()
    {
        $url = request()->fullUrlWithQuery(['gender' => '_gender_']);

        return <<<JS
$('input:radio.user-gender').change(function () {
    var url = "$url".replace('_gender_', $(this).val());
    Dcat.reload(url);
});
JS;
    }

    public function render()
    {
        Admin::script($this->script());
        $id = "DATA_USER";
        $this->modal($id);
        return <<<HTML
<span data-toggle="modal" data-target="#{$id}" style="float: right">
   <a class="btn btn-primary btn-outline" style="color: #4199de"><i class="feather icon-share"></i>  导入</a>
</span>
HTML;

    }

    protected function modal($id)
    {
        // 表单
        $form = new AdminUsersData();
        Admin::html(
            <<<HTML
<div class="modal fade" id="{$id}">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">导入数据</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        {$form->render()}
        <br>
        <div class="alert alert-success">
          <strong>登录用户名： zy@ + 身份证号后4位 + 4 位随机数</strong>
          <br>
          <strong>登录密码：  身份证后 6 位 + 手机号后 4 位</strong>
        </div>
      </div>
    </div>
  </div>
</div>
HTML
        );
    }
}
