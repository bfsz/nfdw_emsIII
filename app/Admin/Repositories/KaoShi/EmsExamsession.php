<?php

namespace App\Admin\Repositories\KaoShi;

use App\Models\KaoShi\EmsExamsession as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class EmsExamsession extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
