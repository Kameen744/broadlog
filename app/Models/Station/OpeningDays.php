<?php

namespace App\Models\Station;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpeningDays extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function formatTimeFrom()
    {
        return Carbon::parse($this->time_from)->format('g:ia');
    }

    public function formatTimeTo()
    {
        // return Carbon::createFromFormat('g:ia', $this->time_to);
        return Carbon::parse($this->time_to)->format('g:ia');
    }
}
