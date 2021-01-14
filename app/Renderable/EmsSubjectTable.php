<?php


namespace App\Renderable;


use App\Models\KaoShi\EmsSubject;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;

class EmsSubjectTable extends LazyRenderable
{

    public function grid(): Grid
    {
        // 获取外部传递的参数
        $id = $this->id;
        return Grid::make(new EmsSubject(), function (Grid $grid) {
            $grid->column('id');
            $grid->column('subject', '申报名称');
            $grid->column('subject_dept', '申报单位');
            $grid->column('subject_desc', '申报说明')->limit(50);
            $grid->rowSelector()->titleColumn('申报信息');
            $grid->quickSearch(['id', 'subject', 'subject_dept']);
            $grid->paginate(20);
            $grid->disableActions();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('subject','申报名称')->width(4);
                $filter->like('subject_dept','申报单位')->width(4);
                $filter->like('subject_desc','申报说明')->width(4);
            });
        });
    }
}
