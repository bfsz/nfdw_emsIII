<?php

namespace App\Models\TiKu;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class EmsDeclaration extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'ems_declaration';
    public function question()
    {
        return $this->hasMany(EmsQuestion::class);
    }
}
