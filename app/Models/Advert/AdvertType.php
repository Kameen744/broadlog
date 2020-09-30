<?php

namespace App\Models\Advert;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertType extends Model
{
    use HasFactory;

    protected $fillable = ['type'];
}
