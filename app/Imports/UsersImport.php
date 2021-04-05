<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        if ($row[3] && $row[3] != 0) {
            if ($row[3] == 1)
                $role = 1;
            if ($row[3] == 2)
                $role = 3;
            if ($row[3] == 3)
                $role = 5;
            if ($row[3] == 4)
                $role = 4;
            if ($row[3] == 5)
                $role = 6;
        } else
            $role = 1;
        if (!$row[12] || !$row[12] == 0)
            $insert_user = 1;
        else
            $insert_user = $row[12] + 1;
        if (!$row[15] || !$row[15] == 0)
            $update_user = 1;
        else
            $update_user = $row[15] + 1;
        return new User([
            'id' => $row[0] + 1,
            'password' => Hash::make('user@123'),
            'role_id' => $role,
            'org_id' => $row[12] + 1,
            'first_name' => $row[1],
            'surname' => $row[2],
            'email' => $row[4],
            'get_email' => $row[5],
            'phone_no' => $row[4],
            'gsm' => $row[7],
            'ip' =>  request()->ip(),
            'add_by' => $insert_user,
            'add_ip' => request()->ip(),
            'update_by' => $update_user,
            'update_ip' => request()->ip(),
        ]);
    }
}
