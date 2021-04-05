<?php

namespace App\Imports;

use App\Organization;
use Maatwebsite\Excel\Concerns\ToModel;

class OrganizationImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!$row[18] || !$row[18] == 0)
            $insert_user = 1;
        else
            $insert_user = $row[12] + 1;
        if (!$row[20] || !$row[20] == 0)
            $update_user = 1;
        else
            $update_user = $row[20] + 1;
        return new Organization([
            'id' => $row[0] + 1,
            'org_name' => $row[2],
            'address' => $row[12],
            'city' => $row[2],
            'email' => $row[17],
            'gsm' => $row[16],
            'phone_no' => $row[15],
            'rating' => $row[3],
            'price' => $row[6],
            'transport_price' => $row[7],
            'add_by' => $insert_user,
            'add_ip' => request()->ip(),
            'update_by' => $update_user,
            'update_ip' => request()->ip(),
        ]);
    }
}
