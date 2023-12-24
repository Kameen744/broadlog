<?php

namespace App\Models\Advert;

use App\Models\Advert\AdvertFile;
use App\Models\Advert\AdvertType;
use App\Models\Advert\AdvertSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Advert extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(AdvertType::class, 'advert_type_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(AdvertFile::class);
    }

    public function schedules()
    {
        return $this->hasMany(AdvertSchedule::class);
    }

    public function adDuration()
    {
        if ($this->duration > 60) {
            return $this->duration / 60 . ' Min';
        } else {
            return $this->duration . ' Sec';
        }
    }
}
