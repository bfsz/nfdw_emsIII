<?php


namespace App\Admin\Metrics\Examples;


use App\Models\KaoShi\EmsExam;
use App\Models\TiKu\EmsQuestion;
use Dcat\Admin\Support\LazyRenderable;
use Dcat\Admin\Widgets\Table;

class EmsExamQuestions extends LazyRenderable
{
    public function render()
    {
        // 获取ID
        $id = $this->key;

        $data = EmsExam::where('id', $id)
            ->get(['exam_questions']);
        $data_a = json_decode($data[0]->exam_questions);

        if ($data_a) {
            $questionsId = []; //题目
            foreach ($data_a as $iValue) {
                $questions = $iValue->questions;
                foreach ($questions as $jValue) {
                    array_push($questionsId, $jValue->id);
                }
            }
            //一般题
            $questions_yiban = EmsQuestion::whereIn('id', $questionsId)->where('que_head_satuts', 0)->get(['id', 'questype_id', 'que_index', 'que_select', 'que_answer'])->toArray();
            //题冒题 题干
            $questions_timao_a = EmsQuestion::whereIn('id', $questionsId)->where('que_head_satuts', 1)->get(['id', 'questype_id', 'que_index', 'que_select', 'que_answer'])->toArray();
            //题冒题 子题
            $questions_timao_b = EmsQuestion::whereIn('que_head_id', $questionsId)->where('que_head_satuts', 1)->get(['id', 'questype_id', 'que_index', 'que_select', 'que_answer'])->toArray();

            $questions_datas = array_merge($questions_yiban, $questions_timao_a, $questions_timao_b);
        } else {
            $questions_datas = [];
        }
        $titles = [
            '题目ID',
            '题型ID',
            '题目',
            '选项',
            '答案',
        ];

        return Table::make($titles, $questions_datas);
    }
}
