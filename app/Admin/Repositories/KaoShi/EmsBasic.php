<?php

namespace App\Admin\Repositories\KaoShi;

use App\Models\KaoShi\EmsBasic as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class EmsBasic extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
