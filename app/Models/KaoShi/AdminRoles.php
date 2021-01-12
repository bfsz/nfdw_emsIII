<?php

namespace App\Models\KaoShi;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;


class AdminRoles extends Model
{
    use HasDateTimeFormatter;
    protected $primaryKey = 'id';

    public function adminUsers()
    {
        return $this->belongsToMany(AdminUsers::class, 'admin_role_users', 'role_id', 'user_id');
    }
}
