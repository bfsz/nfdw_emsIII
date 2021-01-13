<?php

namespace App\Admin\Repositories\TiKu;

use App\Models\TiKu\EmsMajor as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class EmsMajor extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
