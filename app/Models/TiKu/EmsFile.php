<?php

namespace App\Models\TiKu;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class EmsFile extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'ems_files';
    
}
