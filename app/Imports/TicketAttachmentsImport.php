<?php

namespace App\Imports;

use App\TicketAttachment;
use Maatwebsite\Excel\Concerns\ToModel;

class TicketAttachmentsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new TicketAttachment([
            'ticket_id' => $row[1],
            'attachment' => $row[2],
            'add_by' => $row[6],
            'add_ip' => request()->ip(),
        ]);
    }
}
