<?php

namespace App\Models\KaoShi;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class EmsExamsession extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'ems_examsession';

    //关联考场模型
    public function emsBasic()
    {
        return $this->belongsTo(EmsBasic::class, 'session_basic_id');
    }

    //关联试卷模型
    public function emsExam()
    {
        return $this->belongsTo(EmsExam::class, 'session_exam_id');
    }

    //关联科目模型
    public function emsSubject()
    {
        return $this->belongsTo(EmsSubject::class, 'session_subject_id');
    }
}
