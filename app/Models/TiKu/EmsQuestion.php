<?php

namespace App\Models\TiKu;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class EmsQuestion extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'ems_questions';
    protected $fillable = ['id', 'questype_id', 'que_index', 'que_create_byid', 'que_create_byname', 'que_last_byid', 'que_last_byname', 'que_select', 'que_selectnum', 'que_answer', 'que_describe', 'que_status', 'que_level', 'que_sequence', 'declaration_id', 'major_id', 'created_at', 'updated_at', 'que_head_id', 'que_head_satuts', 'que_son_num', 'que_son_value'];

    public function questype()
    {
        return $this->belongsTo(EmsQuestype::class);
    }
}
