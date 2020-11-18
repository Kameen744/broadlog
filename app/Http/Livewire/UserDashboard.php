<?php

namespace App\Http\Livewire;

use DateTime;
use Carbon\Carbon;
use Livewire\Component;
// use App\Mail\AdvertPlayed;
use App\Models\Advert\Advert;
use App\Notifications\AdvertPlayed;
use Illuminate\Support\Facades\Mail;
use App\Models\Advert\AdvertSchedule;
use Illuminate\Support\Facades\Notification;

class UserDashboard extends Component
{
    protected $listeners = [
        'PlayingNow' => 'addPlayed'
    ];
    public $schedules = null;


    public function mount()
    {

        $today = date('Y-m-d');
        // $now = date('h:m:a');

        $this->schedules = AdvertSchedule::where('play_date', $today)
            // ->with('advert')
            // ->with('file')
            ->orderBy('play_time', 'asc')
            ->get();
    }

    public function play(AdvertSchedule $schedule)
    {
        $this->emit('PlayingNow', $schedule);
    }

    public function addPlayed(AdvertSchedule $schedule)
    {


        if (!$schedule->played) {
            $schedule->update([
                'played' => 1
            ]);
            $advert = Advert::where('id', $schedule->advert_id)->first();
            // $advert->notify(new AdvertPlayed($schedule));
            // Mail::to($advert->email)->queue(new AdvertPlayed($schedule));
            try {
                Notification::route('mail', $advert->email)->notify(new AdvertPlayed($schedule, $advert->phone_no));
            } catch (\Throwable $th) {
            }
        }
    }

    public function update()
    {
    }

    public function render()
    {
        return view('livewire.user-dashboard')
            ->extends('layouts.app')
            ->section('content');
    }
}
