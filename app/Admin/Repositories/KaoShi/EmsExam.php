<?php

namespace App\Admin\Repositories\KaoShi;

use App\Models\KaoShi\EmsExam as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class EmsExam extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
