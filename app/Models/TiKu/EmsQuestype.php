<?php

namespace App\Models\TiKu;

use App\Models\KaoShi\EmsSubject;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class EmsQuestype extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'ems_questype';
    public function question()
    {
        return $this->hasMany(EmsQuestion::class);
    }

    public function subject()
    {
        return $this->hasMany(EmsSubject::class);
    }
}
