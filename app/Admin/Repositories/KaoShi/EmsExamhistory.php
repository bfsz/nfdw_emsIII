<?php

namespace App\Admin\Repositories\KaoShi;

use App\Models\KaoShi\EmsExamhistory as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class EmsExamhistory extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
