<?php

namespace App\Admin\Actions\Grid;

use App\Admin\Forms\QuestionData;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Tools\AbstractTool;

class GridQuestionData extends AbstractTool
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
        $id = "DATA_IMPORT";
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
        $form = new QuestionData();

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
      </div>
    </div>
  </div>
</div>
HTML
        );
    }
}
