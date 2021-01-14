<?php


namespace App\Renderable;


use App\Models\KaoShi\EmsExam;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;

class EmsExamTable extends LazyRenderable
{

    public function grid(): Grid
    {
        // 获取外部传递的参数
        $id = $this->id;
        return Grid::make(new EmsExam(), function (Grid $grid) {
            $grid->column('id');
            $grid->column('exam_name', '试卷名');
            $grid->rowSelector()->titleColumn('试卷息');
            $grid->quickSearch(['id', 'exam_name']);
            $grid->paginate(20);
            $grid->disableActions();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('exam_name', '试卷名')->width(4);
            });
        });
    }
}
