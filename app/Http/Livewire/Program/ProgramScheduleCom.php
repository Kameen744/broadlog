<?php

namespace App\Http\Livewire\Program;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Station\OpeningDays;
use App\Models\Program\ProgramSchedule;

class ProgramScheduleCom extends Component
{
    use WithPagination;
    protected $listeners = [
        'AddNewProgramSchedule' => 'newProgSchedule',
        'editProgSchedule' => 'edit'
    ];

    public $edit = null;
    public $program = null;
    public $schedule = [
        'time_from'         => '',
        'time_to'           => '',
        'duration'          => '',
        'program_id'        => '',
        'opening_day_id'    => ''
    ];

    public function newProgSchedule($program)
    {
        $this->program = $program;
    }

    public function create()
    {
    }

    public function store()
    {
        $this->validateForm();
        $this->addProgramDuration();

        $time = ProgramSchedule::where('opening_day_id', $this->schedule['opening_day_id'])
            ->where('time_from', $this->schedule['time_from'])
            ->count();

        if (!$time) {
            ProgramSchedule::create($this->schedule);
            $this->emit('plashMessage', [
                'type'      => 'success',
                'message'   => $this->program['program'] . ' scheduled for ' . $this->schedule['duration'] . ' minutes successfully.'
            ]);
            $this->CurrentProgramScheduleUpdate();
        } else {
            $this->emit('plashMessage', [
                'type'      => 'error',
                'message'   => $this->program['program'] . ' already scheduled for this time.'
            ]);
        }
    }

    public function edit(ProgramSchedule $schedule)
    {
        $this->edit = $schedule;
        $this->schedule['time_from']        = $schedule->time_from;
        $this->schedule['time_to']          = $schedule->time_to;
        $this->schedule['duration']         = $schedule->duration;
        $this->schedule['program_id']       = $schedule->program_id;
        $this->schedule['opening_day_id']   = $schedule->opening_day_id;
    }

    public function update(ProgramSchedule $schedule)
    {
        $schedule->update($this->schedule);
        $this->emit('plashMessage', [
            'type'      => 'success',
            'message'   => 'Schedule updated successfully.'
        ]);
        $this->CurrentProgramScheduleUpdate();
    }

    public function delete(ProgramSchedule $schedule)
    {
        $schedule->delete();
        $this->emit('plashMessage', [
            'type'      => 'error',
            'message'   => ' Schedule deleted.'
        ]);
    }

    public function validateForm()
    {
        $this->validate([
            'schedule.time_from'        => 'required',
            'schedule.time_to'          => 'required',
            'schedule.opening_day_id'   => 'required'
        ]);
    }

    public function addProgramDuration()
    {
        $start  = new Carbon($this->schedule['time_from']);
        $end    = new Carbon($this->schedule['time_to']);
        $duration = $start->diff($end)->i;

        $this->schedule['duration'] = "$duration";

        $program_id = $this->program['id'];
        $this->schedule['program_id'] = "$program_id";
    }

    public function CurrentProgramScheduleUpdate()
    {
        $this->emit('CurrentProgramScheduleUpdated');
    }

    public function finishSchedule()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->schedule = [
            'time_from'         => '',
            'time_to'           => '',
            'duration'          => '',
            'program_id'        => '',
            'opening_day_id'    => ''
        ];
    }

    public function render()
    {
        // $schedules = ProgramSchedule::latest()->with('program')->paginate(10);
        $days = OpeningDays::all();
        return view('livewire.program.program-schedule-com', compact('days'))->extends('layouts.app')->section('content');
    }
}
