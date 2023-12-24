<?php

namespace App\Models\Log;

use Carbon\Carbon;
use App\Models\Advert\AdvertFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function file()
    {
        return $this->belongsTo(AdvertFile::class, 'file_id', 'id');
    }

    public function formatDatePlayed()
    {
        try {
            return Carbon::parse($this->date_played)->format('d/m/Y');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function formatTimePlayed()
    {
        try {
            return Carbon::parse($this->time_played)->format('h:i A');
        } catch (\Throwable $th) {

        }
    }
}
