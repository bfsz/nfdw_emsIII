<?php

namespace App\Models\KaoShi;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class EmsBasic extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'ems_basic';

    public function emsSubject()
    {
        return $this->belongsTo(EmsSubject::class, 'basic_subject_id');
    }

    public function emsExam()
    {
        return $this->belongsTo(EmsExamsession::class, 'basic_subject_id', 'session_subject_id');
    }
}
