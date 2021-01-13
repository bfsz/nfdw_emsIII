<?php


namespace App\Renderable;


use App\Admin\Repositories\TiKu\EmsQuestion;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;

class TikuTable extends LazyRenderable
{

    public function grid(): Grid
    {
        // 获取外部传递的参数
        $id = $this->id;
        return Grid::make(new EmsQuestion(), function (Grid $grid) {
            $grid->column('id');
            $grid->column('que_index', '题干')->limit(50);
            $grid->rowSelector()->titleColumn('试题');
            $grid->quickSearch(['id', 'que_index']);
            $grid->paginate(20);
            $grid->disableActions();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('que_index')->width(4);
            });
        });
    }
}
