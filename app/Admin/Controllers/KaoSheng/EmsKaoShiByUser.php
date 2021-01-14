<?php


namespace App\Admin\Controllers\KaoSheng;


use App\Admin\Controllers\KaoShi\EmsExamByUserPaper;
use App\Http\Controllers\Controller;
use Dcat\Admin\Layout\Content;

class EmsKaoShiByUser extends Controller
{
    public function index(Content $content)
    {
        return $content->full()->body(new EmsExamByUserPaper());
    }
}
