<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TicketAttachment extends Model
{
    //
    protected $guarded = [];
    function getUserNameAttribute()
    {
        $name = '';
        $user = User::where('id', $this->add_by)->first();
        if ($user)
            $name = $user->first_name;
        else
            $name = '';
        return $name;
    }
    function getSurNameAttribute()
    {
        $name = '';
        $user = User::where('id', $this->add_by)->first();
        if ($user)
            $name = $user->surname;
        else
            $name = '';
        return $name;
    }
    function getTicketNameAttribute()
    {
        $name = '';
        $ticket = Ticket::where('id', $this->ticket_id)->first();
        if ($ticket)
            $name = $ticket->name;
        return $name;
    }
    function getOrganizationNameAttribute()
    {
        $name = '';
        $ticket = Ticket::where('id', $this->ticket_id)->first();
        $organization = Organization::where('id', $ticket->org_id)->first();
        if ($organization)
            $name = $organization->org_name;
        return $name;
    }
    function getParsedCreatedAtAttribute()
    {
        $parsedDate = '';
        if ($this->created_at)
            $parsedDate = Carbon::parse($this->created_at)->format('d.m.Y [h:i:s]');
        return $parsedDate;
    }
    protected $appends = ['UserName', 'TicketName', 'OrganizationName', 'ParsedCreatedAt', 'SurName'];
}
