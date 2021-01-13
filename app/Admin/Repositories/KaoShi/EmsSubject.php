<?php

namespace App\Admin\Repositories\KaoShi;

use App\Models\KaoShi\EmsSubject as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class EmsSubject extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
