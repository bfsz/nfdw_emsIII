<?php


namespace App\Admin\Metrics\Examples;


use App\Models\KaoShi\EmsExamhistory;
use App\Models\TiKu\EmsQuestion;
use Dcat\Admin\Support\LazyRenderable;
use Dcat\Admin\Widgets\Table;

class EmsUserQuestions extends LazyRenderable
{
    public function render()
    {
        // 获取key值ID
        $id = $this->key;

        $data = EmsExamhistory::where('id', $id)
            ->get(['ems_scorelist']);

        $data_a = json_decode($data[0]->ems_scorelist);

        if ($data_a) {
            for ($i = 0, $iMax = count($data_a); $i < $iMax; $i++) {
                if ($data_a[$i]->tm == 0) {
                    //一般题
                    $questions_yiban = EmsQuestion::where('id', $data_a[$i]->id)->where('que_head_satuts', 0)->get(['id', 'questype_id', 'que_index', 'que_select', 'que_answer']);
                    if ($data_a[$i]->status == 1) {
                        $data_a[$i]->status = '正确';
                    } else {
                        $data_a[$i]->status = '错误';
                    }
                    $data_a[$i]->id = $i+1;
                    unset($data_a[$i]->answer);
                    $data_a[$i]->tm ='是';
                    $data_a[$i]->que_head_index = '';
                    $data_a[$i]->que_index = $questions_yiban[0]->que_index;
                    $data_a[$i]->que_select = $questions_yiban[0]->que_select;
                } elseif ($data_a[$i]->tm == 1) {
                    //题冒题子题ID
                    $questions_timao_a = EmsQuestion::where('id', $data_a[$i]->id)->where('que_head_satuts', 1)->get(['id', 'que_head_id', 'que_index', 'que_select', 'que_answer']);
                    //题冒题题干
                    $questions_timao_b = EmsQuestion::where('id', $questions_timao_a[0]->que_head_id)->where('que_head_satuts', 1)->get(['id', 'que_index']);
                    if ($data_a[$i]->status == 1) {
                        $data_a[$i]->status = '正确';
                    } else {
                        $data_a[$i]->status = '错误';
                    }
                    $data_a[$i]->id = $i+1;
                    unset($data_a[$i]->answer);
                    $data_a[$i]->tm ='否';
                    $data_a[$i]->que_head_index = $questions_timao_b[0]->que_index;
                    $data_a[$i]->que_index = $questions_timao_a[0]->que_index;
                    $data_a[$i]->que_select = $questions_timao_a[0]->que_select;
                } else {
                    continue;
                }
            }
        } else {
            $data_a = [];
        }
        $titles = [
            'ID',
            '题冒',
            '你的答案',
            '得分',
            '是否答对',
            '题冒题干',
            '选项题干',
            '选项',
        ];
        return Table::make($titles, $data_a);
    }
}
