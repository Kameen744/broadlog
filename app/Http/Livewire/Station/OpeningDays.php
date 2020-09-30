<?php

namespace App\Http\Livewire\Station;

use Carbon\Carbon;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use App\Models\Station\OpeningDays as Days;


class OpeningDays extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $edit = null;
    // protected $allDays;

    public $form = [
        'day'       => '',
        'time_from' => '',
        'time_to'   => ''
    ];

    // public function mount()
    // {
    //     $days = Days::paginate(10);
    //     $this->allDays = $days;
    // }

    public function store()
    {
        $this->ValidateRequest();
        Days::create($this->form);
        $this->ClearForm();
    }

    public function edit(Days $day)
    {
        $this->edit = $day->id;
        $this->form['day'] = $day->day;
        $this->form['time_from'] = $day->time_from;
        $this->form['time_to'] = $day->time_to;
    }

    public function update(Days $day)
    {
        // $this->authorize('update', $day);

        $this->ValidateRequest();
        $update = $day->update($this->form);
        $this->edit = null;
        $this->ClearForm();
        $this->render();
    }

    public function delete(Days $day)
    {
        $day->delete();
    }

    public function ClearForm()
    {
        $this->form['day'] = '';
        $this->form['time_from'] = '';
        $this->form['time_to'] = '';
    }

    public function ValidateRequest()
    {
        $this->validate([
            'form.day'       => 'required|string|unique:opening_days,day',
            'form.time_from' => 'required',
            'form.time_to'   => 'required'
        ]);
    }

    public function render()
    {
        $days = Days::paginate(10);
        return view('livewire.station.opening-days', compact('days'))
            ->extends('layouts.app')
            ->section('content');
    }
}
