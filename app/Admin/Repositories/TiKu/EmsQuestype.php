<?php

namespace App\Admin\Repositories\TiKu;

use App\Models\TiKu\EmsQuestype as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class EmsQuestype extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
