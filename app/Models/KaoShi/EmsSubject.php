<?php

namespace App\Models\KaoShi;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class EmsSubject extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'ems_subject';

    public function emsBasic()
    {
        return $this->hasOne(EmsBasic::class, 'id');
    }

    public function major()
    {
        return $this->belongsTo(EmsMajor::class, 'subject_set');
    }

    public function emsExam()
    {
        return $this->hasOne(EmsExam::class);
    }
}
