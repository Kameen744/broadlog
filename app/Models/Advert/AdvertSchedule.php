<?php

namespace App\Models\Advert;

use App\Models\Advert\Advert;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdvertSchedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function advert()
    {
        return $this->belongsTo(Advert::class);
    }

    public function file()
    {
        return $this->belongsTo(AdvertFile::class);
    }
}
