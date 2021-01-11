<?php

namespace App\Imports;


use App\Models\TiKu\EmsQuestion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class QuestionImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new EmsQuestion([
            'questype_id' => $row['questype_id'],
            'que_index' => $row['que_index'],
            'que_select' => $row['que_select'],
            'que_selectnum' => $row['que_selectnum'],
            'que_answer' => $row['que_answer'],
            'que_describe' => $row['que_describe'],
            'declaration_id' => $row['declaration_id'],
            'major_id' => $row['major_id'],
        ]);
    }
}
