<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    protected $guarded = [];
    function getStatusNameAttribute()
    {
        $name = '';
        $status = Status::where('id', $this->status_id)->first();
        if ($status)
            $name = $status->name;
        else
            $name = '';
        return $name;
    }
    function getOrganizationNameAttribute()
    {
        $name = '';
        $organization = Organization::where('id', $this->org_id)->first();
        if ($organization)
            $name = $organization->org_name;
        return $name;
    }
    function getUserNameAttribute()
    {
        $name = '';
        $user = User::where('id', $this->user)->first();
        if ($user)
            $name = $user->first_name;
        return $name;
    }
    function getPersonnelNameAttribute()
    {
        $name = '';
        $user = User::where('id', $this->personnel)->first();
        if ($user)
            $name = $user->first_name;
        return $name;
    }
    function getCategoryNameAttribute()
    {
        $name = '';
        $category = Category::where('id', $this->category)->first();
        if ($category)
            $name = $category->name;
        return $name;
    }
    function getParsedCreatedAtAttribute()
    {
        $parsedDate = '';
        if ($this->created_at)
            $parsedDate = Carbon::parse($this->created_at)->format('d/m/Y');
        return $parsedDate;
    }
    function getParsedDueDateAttribute()
    {
        $parsedDate = '';
        if ($this->due_date)
            $parsedDate = Carbon::parse($this->due_date)->format('d/m/Y');
        return $parsedDate;
    }
    function getPriorityNameAttribute()
    {
        $priority = '';
        if ($this->priority == 4)
            $priority = 'Low';
        if ($this->priority == 1)
            $priority = 'Normal';
        if ($this->priority == 2)
            $priority = 'High';
        if ($this->priority == 3)
            $priority = 'Very High';
        return $priority;
    }
    function getSurNameAttribute()
    {
        $name = '';
        $user = User::where('id', $this->user)->first();
        if ($user)
            $name = $user->surname;
        return $name;
    }
    function getPersonnelSurNameAttribute()
    {
        $name = '';
        $user = User::where('id', $this->personnel)->first();
        if ($user)
            $name = $user->surname;
        return $name;
    }
    protected $appends = ['StatusName', 'OrganizationName', 'UserName', 'PersonnelName', 'PriorityName', 'CategoryName', 'ParsedCreatedAt', 'SurName', 'PersonnelSurName', 'ParsedDueDate'];
}
