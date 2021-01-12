<?php

namespace App\Imports;

use App\Models\KaoShi\AdminUser;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AdminUsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new AdminUser([
            'name' => $row['name'],
            'project_dept' => $row['project_dept'],
            'organ_name' => $row['organ_name'],
            'pid_number' => $row['pid_number'],
            'user_phone' => $row['user_phone']
        ]);
    }
}
