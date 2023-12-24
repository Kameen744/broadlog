<?php

namespace App\Models\Program;

use App\Models\Program\ProgramSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function schedule()
    {
        return $this->hasMany(ProgramSchedule::class);
    }
}
