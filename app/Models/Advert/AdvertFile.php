<?php

namespace App\Models\Advert;

use App\Models\Advert\Advert;
use App\Models\Advert\AdvertSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdvertFile extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function advert()
    {
        return $this->belongsTo(Advert::class);
    }

    public function schedules()
    {
        return $this->hasMany(AdvertSchedule::class);
    }
}
