<?php


namespace App\Exceptions\Tools;


use App\Models\TiKu\EmsFile;
use Dcat\Admin\Grid\Tools\AbstractTool;

class UserFileGender extends AbstractTool
{
    public function render()
    {
        $data = EmsFile::where('file_name', '考生模板')->get('file_path')->toArray();
        $url = '/uploads/' . $data[0]['file_path'];
        return view('admin.fileDownloadTools', ['url' => $url]);
    }
}
