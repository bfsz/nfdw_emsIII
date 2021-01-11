<?php

namespace App\Admin\Forms;

use App\Imports\QuestionImport;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;

class QuestionData extends Form
{
    // 增加一个自定义属性保存用户ID
    protected $id = 'DATA_IMPORT';

    // 构造方法的参数必须设置默认值
    public function __construct($id = null)
    {
        $this->id = $id;

        parent::__construct();
    }

    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return \Dcat\Admin\Http\JsonResponse|Response
     */
    public function handle(array $input)
    {
        // 下面的代码获取到上传的文件，然后使用`maatwebsite/excel`等包来处理上传你的文件，保存到数据库
        $file = $input['file'];
        if (!$file) {
            return $this->response()->error('请先上传文件');
        }
        try {
            // 导入
            Excel::import(new QuestionImport(), $file, 'admin');
            //导入成功后删除文件
            $disk = Storage::disk('admin');
            $disk->delete($file);
        } catch (\Exception $e) {
            return $this->response()->error('导入失败')->refresh();
        }
        return $this->response()->success('导入成功')->refresh();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->file('file', '请选择文件')
            ->disk('admin')
            ->autoUpload()
            ->accept('xlsx,xls,csv');
    }
}
