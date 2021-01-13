<?php

namespace App\Admin\Repositories\TiKu;

use App\Models\TiKu\EmsFile as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class EmsFile extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
