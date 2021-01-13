<?php

namespace App\Models\KaoShi;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class EmsSubject extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'ems_subject';
    
}
