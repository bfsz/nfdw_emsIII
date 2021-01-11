<?php

namespace App\Imports;

use App\Models\KaoShi\AdminUsers;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AdminUsersImport implements ToModel,WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new AdminUsers([
            'name' => $row['name'],
            'project_dept' => $row['project_dept'],
            'organ_name' => $row['organ_name'],
            'pid_number' => $row['pid_number'],
        ]);
    }
}
