<?php

namespace App\Models\KaoShi;

use App\Models\TiKu\EmsDeclaration;
use App\Models\TiKu\EmsMajor;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class EmsExam extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'ems_exams';
    public function major()
    {
        return $this->belongsTo(EmsMajor::class, 'exam_major');
    }

    public function subject()
    {
        return $this->belongsTo(EmsSubject::class, 'exam_subject_id');
    }

    public function declaration()
    {
        return $this->belongsTo(EmsDeclaration::class, 'exam_type');
    }
}
