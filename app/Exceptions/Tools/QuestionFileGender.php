<?php


namespace App\Exceptions\Tools;


use App\Models\TiKu\EmsFile;
use Dcat\Admin\Grid\Tools\AbstractTool;

class QuestionFileGender extends AbstractTool
{
    public function render()
    {
        $data = EmsFile::where('file_name', '题库模板')->get('file_path')->toArray();
        $url = '/uploads/' . $data[0]['file_path'];
        return view('admin.fileDownloadTools', ['url' => $url]);
    }
}
