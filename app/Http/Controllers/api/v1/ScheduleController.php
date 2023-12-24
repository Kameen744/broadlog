<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Advert\AdvertSchedule;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $today = date_format(now(), 'Y-m-d');

        $schedules = AdvertSchedule::where('play_date', $today)
            ->where('status', 1)
            ->with('file')
            ->orderBy('played', 'desc')
            ->orderBy('play_time', 'asc')
            ->get();

        return $schedules;
    }
}
