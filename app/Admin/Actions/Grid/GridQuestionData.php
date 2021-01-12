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
        <button type="button" class="btn btn-danger" data-toggle="collapse" data-target="#demo">Excel 表头字段</button>
          <div id="demo" class="collapse">
                <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>字段</th>
                        <th>解释</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>que_index</td>
                        <td>题型ID</td>
                      </tr>
                      <tr>
                        <td>que_select</td>
                        <td>选项</td>
                      </tr>
                      <tr>
                        <td>que_selectnum</td>
                        <td>选项数量</td>
                      </tr>
                      <tr>
                        <td>que_answer</td>
                        <td>答案</td>
                      </tr>
                      <tr>
                        <td>que_describe</td>
                        <td>解析</td>
                      </tr>
                      <tr>
                        <td>declaration_id</td>
                        <td>种类</td>
                      </tr>
                      <tr>
                        <td>major_id</td>
                        <td>专业</td>
                      </tr>
                    </tbody>
                </table>
          </div>
      </div>
    </div>
  </div>
</div>
HTML
        );
    }
}
