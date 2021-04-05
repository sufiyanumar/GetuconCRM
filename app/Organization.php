<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    //
    protected $guarded = [];
    function getParsedStartDateAttribute()
    {
        $parsedDate = '';
        if ($this->contract_start_date)
            $parsedDate = date("Y-m-d", strtotime($this->contract_start_date));
        return $parsedDate;
    }
    function getParsedEndDateAttribute()
    {
        $parsedDate = '';
        if ($this->contract_end_date)
            $parsedDate = date("Y-m-d", strtotime($this->contract_end_date));
        return $parsedDate;
    }
    protected $appends = ['ParsedStartDate', 'ParsedEndDate'];
}
