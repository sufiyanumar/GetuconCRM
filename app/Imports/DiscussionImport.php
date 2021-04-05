<?php

namespace App\Imports;

use App\Discussion;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DiscussionImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $i = 0;
        foreach ($collection as $data) {
            $user = User::where('id', $data[3] + 1)->first();
            $discussion = new Discussion();
            $discussion->id = 135 + $i;
            $discussion->message = $data[2];
            $discussion->user_id = $user->id;
            $discussion->ticket_id = $data[1];
            $discussion->org_id = $user->org_id;
            $discussion->is_private = $data[7];
            $discussion->created_at = Carbon::parse($data[4])->toDateTime();
            $discussion->save();
            $i++;
        }
    }
}
