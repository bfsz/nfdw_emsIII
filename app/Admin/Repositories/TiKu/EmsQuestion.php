<?php

namespace App\Admin\Repositories\TiKu;

use App\Models\TiKu\EmsQuestion as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class EmsQuestion extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
