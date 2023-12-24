<?php

namespace App\Http\Livewire;

use DateTime;
use Carbon\Carbon;
use Livewire\Component;
use App\Mail\AdvertPlayed as MailAdvertPlayed;
use App\Models\Advert\Advert;
use App\Notifications\AdvertPlayed;
use Illuminate\Support\Facades\Mail;
use App\Models\Advert\AdvertSchedule;
use App\Models\Log\Log;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\Process\Process;

class UserDashboard extends Component
{
    protected $listeners = [
        'PlayingNow' => 'addPlayed',
    ];

    public $schedules = null;
    public $today = null;
    public $now = null;
    public $next;
    public $nowplaying = null;

    public $notifyTimeToPlay;
    public $notifyTimeRemaining;
    public $notifyName;
    public $autoPlay = true;
    public $schedules_iterator;
    public $offNotification = false;
    public $notificationsOn = true;
    public $todayYMD = null;

    public function mount()
    {
        // $today = date('Y-m-d');
        $today = date_format(now(), 'Y-m-d');
        $this->todayYMD = $today;
        $this->now =  date_format(now(), 'h:i A');
        $this->today = date_format(now(), 'D d m Y');

        $this->schedules = AdvertSchedule::where('play_date', $today)
            ->where('status', 1)
            ->orderBy('played', 'desc')
            ->orderBy('play_time', 'asc')
            ->get();
    }

    public function play(AdvertSchedule $schedule)
    {
        if($this->nowplaying === null) {
            $this->emit('PlayingNow', $schedule);
        }
    }

    public function addPlayed(AdvertSchedule $schedule)
    {
        if ($schedule->played === 0) {
            $this->nowplaying = $schedule;

            $schedule->update([
                'played' => 1
            ]);

            if (env('SMS_NOTIFICATION')) {
                $schedule->update([
                    'played' => 1
                ]);
            }

            $this->addToLog($schedule);
            $advert = Advert::where('id', $schedule->advert_id)->first();

            // no longer need this code
            // $advert->notify(new AdvertPlayed($schedule, $advert->phone_no));
            // Mail::to($advert->email)->queue(new AdvertPlayed($schedule));

            try {
                Notification::route('mail', $advert->email)->notify(new AdvertPlayed($schedule, $advert->phone_no));
            } catch (\Throwable $th) {
                // dd($th);
            }
            // No longer need this code but it works
            // try {
            //     Mail::to($advert->email)->queue(new MailAdvertPlayed($schedule));
            // } catch (\Throwable $th) {
            //     dd($th);
            // }
        }
    }

    // check the advert to be played now or next five minutes
    public function checkToPlay()
    {
        $now = date_format(now(), 'H:i:00');
        $dateTime = new DateTime(now());

        // $next_five = $dateTime->modify('+5 minutes');
        // $next_two = $dateTime->modify('+2 minutes');

        // $next_five = date_format($next_five, 'H:i:00');
        $next_two = date_format($dateTime->modify('+2 minutes'), 'H:i:00');

        try {

            if ($this->autoPlay) {
                $playNow = $this->schedules
                    ->where('play_time', $now)
                    ->where('played', 0)
                    ->first();
                if ($playNow) {
                    $this->play($playNow);
                }
            }

            if($this->notificationsOn & $this->offNotification == false) {
                $playNexTwoMinutes = $this->schedules->where('play_time', $next_two)->first();
                if ($playNexTwoMinutes) {
                    $this->notifyName = $playNexTwoMinutes->file->name;
                    $this->notifyTimeToPlay = date('h:i A', strtotime($playNexTwoMinutes->play_time));
                    $this->emit('PlayingNext', $playNexTwoMinutes);
                } else {
                    if($this->offNotification === true) {
                        $this->offNotification = false;
                    }
                }
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // add the advert being played to the played log table
    public function addToLog($schedule)
    {
        try {
            $log = Log::insert([
                'name'          => $schedule->file->name,
                'date_played'   => $schedule->play_date,
                'time_played'   => $schedule->play_time,
                'file_id'       => $schedule->file_id
            ]);
        } catch (\Throwable $th) {
            // throw $th;
        }
    }

    // check and load advert schedule changes and update timer
    public function LoadScheduledAdverts()
    {
        try {
            if($this->nowplaying === null) {
                $dateTime = now();

                $this->now =  date_format(now(), 'h:i A');
                $this->today = date_format(now(), 'D d m Y');

                // Count adverts schedule and compare with the current if theres changes
                $countDBAds = AdvertSchedule::where('play_date', $this->todayYMD)->count();
                $countLoadedAds = count($this->schedules);

                // if theres changes load new advert schedules
                if($countDBAds > $countLoadedAds) {
                    $this->mount();
                    $this->render();
                }

                $this->checkToPlay();
            }
            // check adverts to be played using timestamp
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function endNowPlaying()
    {
        // exec('sdvol/SetVolume AllAppVolume 100');
        exec('sdvol/SetVolume virtual 100');
        exec('sdvol/SetVolume jazler 100');
        exec('sdvol/SetVolume vlc 100');
        $this->nowplaying = null;
    }

    public function setAdvertPlayingVolume()
    {
        exec('sdvol/SetVolume AllAppVolume 0');
        exec('sdvol/SetVolume "chrome" 100');
        exec('sdvol/SetVolume "edge" 100');
        exec('sdvol/SetVolume "firefox" 100');
        exec('sdvol/SetVolume "opera" 100');
    }

    public function toggleAutoPlay()
    {
        if ($this->autoPlay) {
            $this->autoPlay = false;
        } else {
            $this->autoPlay = true;
        }
    }

    public function toggleNotifications()
    {
        if ($this->notificationsOn) {
            $this->notificationsOn = false;
        } else {
            $this->notificationsOn = true;
        }
    }

    public function suspendNotification() {
        $this->offNotification = true;
    }

    public function render()
    {
        return view('livewire.user-dashboard')
            ->extends('layouts.app')
            ->section('content');
    }
}
