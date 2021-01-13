<?php

namespace App\Models\TiKu;

use App\Models\KaoShi\EmsExam;
use App\Models\KaoShi\EmsSubject;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class EmsMajor extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'ems_major';
    public function question()
    {
        return $this->hasMany(EmsQuestion::class);
    }

    public function emsSubject()
    {
        return $this->hasMany(EmsSubject::class);
    }

    public function emsExam()
    {
        return $this->hasMany(EmsExam::class);
    }
}
