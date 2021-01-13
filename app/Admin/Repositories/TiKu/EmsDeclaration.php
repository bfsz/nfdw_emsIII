<?php

namespace App\Admin\Repositories\TiKu;

use App\Models\TiKu\EmsDeclaration as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class EmsDeclaration extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
