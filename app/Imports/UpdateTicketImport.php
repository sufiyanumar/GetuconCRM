<?php

namespace App\Imports;

use App\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UpdateTicketImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        //
        foreach ($collection as $data) {
            $ticket = Ticket::where('id', $data[0])->first();
            if ($data[12] && $data[12] != NULL && $data[12] != 'NULL')
                $ticket->due_date = Carbon::parse($data[12])->format('Y/m/d');
            else
                $ticket->due_date = Carbon::now();
            // $ticket->due_date = Carbon::parse('000-00-00 00:00:00')->format('Y/m/d');
            $ticket->created_at = Carbon::parse($data[22])->toDateTime();
            $ticket->save();
        }
    }
}
