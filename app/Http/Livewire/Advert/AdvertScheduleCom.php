<?php

namespace App\Http\Livewire\Advert;

use App\Models\Advert\Advert;
use Carbon\Carbon;
use Livewire\Component;
use Carbon\CarbonPeriod;
use App\Models\Advert\AdvertFile;
use App\Models\Advert\AdvertSchedule;

class AdvertScheduleCom extends Component
{
    protected $listeners = [
        'addScheduleEvent' => 'addScheduleEvent',
        'editSchedule'     => 'editEvent',
        'deleteSchedule'   => 'deleteEvent'
    ];

    public $edit = null;
    public $advert = null;
    public $callendar = [];
    public $files = null;

    public $c_ad_time = null;
    public $c_ad_date = 'Select day';
    public $c_ad_file_id = null;
    public $c_schedules = null;
    public $all_date_schedules = null;

    public $p_ad_time = null;
    public $p_ad_date = null;
    public $p_ad_file_id = null;

    public $form = [];

    public function mount()
    {
        if ($this->advert) {
            $this->files =  AdvertFile::latest()->where('advert_id', $this->advert['id'])->get();
            $period = CarbonPeriod::create($this->advert['start_date'], $this->advert['finish_date']);

            $p = [];

            $key = 0;

            foreach ($period as $date) {
                $mdate = $date->format('Y-m-d');
                $this->c_ad_date = $mdate;
                $this->updateBookedSlots();
                $day = Carbon::parse($mdate);
                $month = $day->shortMonthName;
                if (!isset($p[$key])) {
                    $p[$key] = ['date' => $mdate, 'day' => substr($day->shortDayName, 0, 1), 'month' => $month];
                    array_push($p[$key], ['date' => $mdate, 'day' => substr($day->shortDayName, 0, 1), 'month' => $month]);
                } elseif ($month === $p[$key]['month']) {
                    array_push($p[$key], ['date' => $mdate, 'day' => substr($day->shortDayName, 0, 1), 'month' => $month]);
                } else {
                    $key++;
                    $p[$key] = ['date' => $mdate, 'day' => substr($day->shortDayName, 0, 1), 'month' => $month];
                    array_push($p[$key], ['date' => $mdate, 'day' => substr($day->shortDayName, 0, 1), 'month' => $month]);
                }
                $this->c_ad_date = 'Select day';
            }

            $this->callendar = $p;
        }
    }

    public function selectDate($adv_date)
    {
        $this->edit = null;
        $this->c_ad_date = date('Y-m-d', $adv_date);
        $this->updateBookedSlots();
        $this->updateCurrentSchedules();
    }

    public function store()
    {
        $this->validateRequest();

        AdvertSchedule::create([
            'play_date' => $this->c_ad_date,
            'play_time' => $this->c_ad_time,
            'advert_id' => $this->advert['id'],
            'file_id'   => $this->c_ad_file_id
        ]);

        $this->updateBookedSlots();
        $this->updateCurrentSchedules();
    }

    public function edit(AdvertSchedule $schedule)
    {

        $this->c_ad_date    = $schedule->play_date;
        $this->c_ad_time    = $schedule->play_time;
        $this->c_ad_file_id = $schedule->file_id;
        $this->edit         = $schedule->id;
    }

    public function editEvent(AdvertSchedule $schedule)
    {
        $this->edit($schedule);
        $advert = Advert::find($schedule->advert_id);

        $this->addScheduleEvent([
            'id' => $advert->id,
            'start_date' => $advert->start_date,
            'finish_date' => $advert->finish_date
        ]);
    }

    public function deleteEvent(AdvertSchedule $schedule)
    {
        $advert = Advert::find($schedule->advert_id);
        $this->addScheduleEvent([
            'id' => $advert->id,
            'start_date' => $advert->start_date,
            'finish_date' => $advert->finish_date
        ]);

        $this->delete($schedule);
    }

    public function update(AdvertSchedule $schedule)
    {
        $this->validateRequest();
        $schedule->update([
            'play_date' => $this->c_ad_date,
            'play_time' => $this->c_ad_time,
            'advert_id' => $this->advert['id'],
            'file_id'   => $this->c_ad_file_id
        ]);
        $this->edit = null;
        $this->c_ad_date = 'Select day';
        $this->updateCurrentSchedules();
    }

    public function delete(AdvertSchedule $schedule)
    {
        $this->edit = null;
        $schedule->delete();
        $this->updateBookedSlots();
        $this->updateCurrentSchedules();
    }

    public function updateBookedSlots()
    {
        $booked_slots = AdvertSchedule::where('play_date', $this->c_ad_date)
            ->where('advert_id', $this->advert['id'])
            ->count();
        $booked_date = strtotime($this->c_ad_date);
        $this->form[$booked_date] = $booked_slots;
    }

    public function updateCurrentSchedules()
    {
        $this->all_date_schedules = AdvertSchedule::where('play_date', $this->c_ad_date)->get();
        $this->c_schedules =  $this->all_date_schedules->where('advert_id', $this->advert['id']);

        $this->emit('bookedSlots', $this->advert['id']);
    }

    public function addScheduleEvent($advert)
    {
        $this->advert = $advert;
        $this->mount();
    }

    // public function addSchedule($ddate)
    // {
    // }

    public function finishScheduling()
    {
        $this->reset(['edit', 'c_schedules', 'advert', 'form', 'callendar', 'files', 'c_ad_date', 'c_ad_time', 'c_ad_file_id']);
    }

    public function validateRequest()
    {
        $this->validate([
            'c_ad_date'     => 'required',
            'c_ad_time'     => 'required',
            'c_ad_file_id'  => 'required'
        ]);
    }

    public function render()
    {
        return view('livewire.advert.advert-schedule-com');
    }
}

// sms api
// IBoNvO0KmFkSg1UxPrV6PPCLjTFUuvdzafmODhr8J8ggrymJpG0SUcKxGkU6Whk1flgWqq2HBqdmIReNIm81WuijS4RoVkFtUhiw
