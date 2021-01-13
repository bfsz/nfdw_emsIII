<?php

namespace App\Models\KaoShi;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'admin_users';
    protected $fillable = ['name', 'project_dept', 'organ_name', 'pid_number', 'user_phone'];

    public function adminRoles()
    {
        return $this->belongsToMany(AdminRoles::class, 'admin_role_users', 'user_id', 'role_id');
    }
}
