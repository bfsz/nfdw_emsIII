<?php

namespace App\Admin\Repositories\KaoShi;

use App\Models\KaoShi\AdminRoles as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class AdminRole extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
