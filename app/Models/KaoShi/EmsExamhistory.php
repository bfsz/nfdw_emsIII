<?php

namespace App\Models\KaoShi;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class EmsExamhistory extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'ems_examhistory';

    //关联考场模型
    public function ems_basic()
    {
        return $this->belongsTo(EmsBasic::class, 'ems_basic_id');
    }

    //关联试卷模型
    public function ems_exam()
    {
        return $this->belongsTo(EmsExam::class, 'ems_exam_id');
    }

    //关联科目模型
    public function ems_subject()
    {
        return $this->belongsTo(EmsSubject::class, 'ems_subject_id');
    }

    //关联用户
    public function kao_shi_users()
    {
        return $this->belongsTo(AdminUser::class, 'ems_user_id');
    }
}
