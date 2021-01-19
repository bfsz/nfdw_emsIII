<?php


namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\tiKu\EmsMajor;
use Illuminate\Http\Request;
use App\Models\TiKu\EmsQuestype;
use App\Models\TiKu\EmsDeclaration;


class TikuController extends Controller
{
    public function questype(Request $request)
    {
        $q = $request->get('q');
        $data = EmsQuestype::Where('type_name', 'like', "%$q%")->paginate(null, ['id', 'type_name as text']);
        return $data;
    }

    public function declaration(Request $request)
    {
        $q = $request->get('q');
        $data = EmsDeclaration::Where('decl_name', 'like', "%$q%")->paginate(null, ['id', 'decl_name as text']);
        return $data;
    }

    public function major(Request $request)
    {
        $q = $request->get('q');
        $data = EmsMajor::Where('major_name', 'like', "%$q%")->paginate(null, ['id', 'major_name as text']);
        return $data;
    }

    public function questype1()
    {
        return EmsQuestype::pluck('type_name');
    }

    public function declaration1()
    {
        return EmsDeclaration::pluck('decl_name');
    }

    public function major1()
    {
        return EmsMajor::pluck('major_name');
    }
}
