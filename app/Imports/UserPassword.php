<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;

class UserPassword implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        //
        foreach ($collection as $data) {
            $user = User::where('id', $data[1] + 1)->first();
            $user->password = Hash::make($data[2]);
            $user->save();
        }
    }
}
