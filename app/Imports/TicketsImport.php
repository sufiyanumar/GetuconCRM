<?php

namespace App\Imports;

use App\Ticket;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class TicketsImport implements ToModel
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

        if (!$row[2] || !$row[2] == 0)
            $userId = 1;
        else
            $userId = $row[20] + 1;

        if ($row[7] && $row[7] != 'NULL') {
            if ($row[7] == 1)
                $status = 1;

            if ($row[7] == 2)
                $status = 2;

            if ($row[7] == 3)
                $status = 3;

            if ($row[7] == 4)
                $status = 4;

            if ($row[7] == 5)
                $status = 6;

            if ($row[7] == 6)
                $status = 7;

            if ($row[7] == 7)
                $status = 9;

            if ($row[7] == 8)
                $status = 5;
        } else {
            $status = 1;
        }
        if ($row[4]) {
            if ($row[4] == 1)
                $priority = 0;
            if ($row[4] == 2)
                $priority = 1;
            if ($row[4] == 3)
                $priority = 2;
            if ($row[4] == 4)
                $priority = 3;
        } else {
            $priority = 0;
        }
        if ($row[12] && $row[12] != 'NULL') {
            $dueDate = strtotime($row[12]);
            if ($dueDate == 0)
                $dueDate = Carbon::now();
        } else
            $dueDate = Carbon::now();
        if ($row[19] && $row[19] != 'NULL') {
            $createdAt = strtotime($row[19]);
            if ($createdAt == 0)
                $createdAt = Carbon::now();
        } else
            $createdAt = Carbon::now();
        return new Ticket([
            'id' => $row[0],
            'name' => $row[8],
            'description' => strip_tags($row[9], '<b><i>'),
            'org_id' => $row[1] + 1,
            'user' => $userId,
            'personnel' => 1,
            'status_id' => $status,
            'due_date' => $dueDate,
            'priority' => $priority,
            'category' => ($row[5] != 'NULL') ? $row[5] : 1,
            'good_will' => 0,
            'coding' => $row[14],
            'consulting' => $row[15],
            'testing' => $row[16],
            'total_time' => '0',
            'add_by' => $insert_user,
            'add_ip' => request()->ip(),
            'update_by' => $update_user,
            'update_ip' => request()->ip(),
            'created_at' => $createdAt,
        ]);
    }
}
