<?php

namespace App\Models\KaoSheng;

use App\Models\TiKu\EmsDeclaration;
use App\Models\TiKu\EmsMajor;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class EmsMockexam extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'ems_mockexam';

    public function major()
    {
        return $this->belongsTo(EmsMajor::class, 'mkems_major_id');
    }

    public function declaration()
    {
        return $this->belongsTo(EmsDeclaration::class, 'mkems_declaration_id');
    }

}
