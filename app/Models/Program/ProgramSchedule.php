<?php

namespace App\Models\Program;

use Carbon\Carbon;
use App\Models\Program\Program;
use App\Models\Station\OpeningDays;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgramSchedule extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function day()
    {
        return $this->belongsTo(OpeningDays::class, 'opening_day_id');
    }

    public function formatTimeFrom()
    {
        return Carbon::parse($this->time_from)->format('h:i A');
    }

    public function formatTimeTo()
    {
        return Carbon::parse($this->time_to)->format('h:i A');
    }
}
