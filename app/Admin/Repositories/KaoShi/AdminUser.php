<?php

namespace App\Admin\Repositories\KaoShi;

use App\Models\KaoShi\AdminUser as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class AdminUser extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
