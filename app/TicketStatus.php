<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model
{
    //
    protected $table = 'tickets_status';
    function getTicketStatusNameAttribute()
    {
        $status = Status::where('id', $this->status)->first();
        return $status->name;
    }
    function getStatusUserNameAttribute()
    {
        $user = User::where('id', $this->add_by)->first();
        return $user->first_name;
    }
    protected $appends = ['TicketStatusName', 'StatusUserName'];
}
