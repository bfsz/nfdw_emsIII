<?php

namespace App\Admin\Repositories\KaoSheng;

use App\Models\KaoSheng\EmsMockexam as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class EmsMockexam extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
