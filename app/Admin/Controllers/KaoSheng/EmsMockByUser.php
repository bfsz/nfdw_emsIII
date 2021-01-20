<?php


namespace App\Admin\Controllers\KaoSheng;

use App\Http\Controllers\Controller;
use Dcat\Admin\Layout\Content;

class EmsMockByUser extends Controller
{
    public function index(Content $content)
    {
        return $content->full()->body(new EmsMockByUserPaper());
    }
}
