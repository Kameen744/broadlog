<?php

namespace App\Http\Livewire\Program;

use Livewire\Component;
use Barryvdh\DomPDF\Facade as PDF;
use Livewire\WithPagination;
use App\Models\Program\Program;
use App\Models\Program\ProgramSchedule;

class ProgramIndex extends Component
{
    use WithPagination;
    protected $listeners = [
        'CurrentProgramScheduleUpdated' => 'GetProgramSchedules'
    ];
    public $edit = null;
    public $CurrentProgram = null;
    public $CurrentProgramSchedule = null;
    public $currentPage = 'index';
    public $searchText = '';
    public $searchResult = null;
    public $Program = [
        'name'          => '',
        'description'   => '',
        'status'        => false
    ];

    public $name = '';

    public function create()
    {
        $this->edit = null;
        $this->currentPage = 'new';
        // $this->emit('addNewProgram');
        $this->resetForm();
    }

    public function store()
    {
        $this->validateData();
        Program::create(
            [
                'program'       => $this->Program['name'],
                'description'   => $this->Program['description'],
                'status'        => $this->Program['status']
            ]
        );

        $this->emit('plashMessage', [
            'type'      => 'success',
            'message'   => $this->Program['name'] . ' saved successfully.'
        ]);
    }

    public function view(Program $program)
    {
        $this->CurrentProgram = $program;
        $this->GetProgramSchedules();
        // $this->emit('viewProgram');
        $this->currentPage = 'view';
    }

    public function edit(Program $program)
    {
        $this->edit = $program;
        $this->Program['name']          = $program->program;
        $this->Program['description']   = $program->description;
        $this->Program['status']        = $program->status;
        $this->currentPage = 'new';
        // $this->emit('editProgram');
    }

    public function editSchedule(ProgramSchedule $schedule)
    {
        $this->emit('editProgSchedule', $schedule);
    }

    public function update(Program $program)
    {
        $program->update([
            'program'       => $this->Program['name'],
            'description'   => $this->Program['description'],
            'status'        => $this->Program['status']
        ]);
        $this->emit('plashMessage', [
            'type'      => 'success',
            'message'   => $this->Program['name'] . ' updated successfully.'
        ]);
    }

    public function delete(Program $program)
    {
        $program->delete();
        $this->emit('plashMessage', [
            'type'      => 'error',
            'message'   => $program->program . ' deleted.'
        ]);
    }

    public function deleteSchedule(ProgramSchedule $schedule)
    {
        $schedule->delete();
        $this->emit('plashMessage', [
            'type'      => 'error',
            'message'   => 'Schedule deleted.'
        ]);
    }

    public function AddProgSchedule()
    {
        $this->emit('AddNewProgramSchedule', $this->CurrentProgram);
    }

    public function GetProgramSchedules()
    {
        $this->CurrentProgramSchedule = ProgramSchedule::where('program_id', $this->CurrentProgram->id)->get();
    }

    public function validateData()
    {
        $this->validate([
            'Program.name'         => 'required',
            'Program.description'  => 'required',
            'Program.status'       => 'required'
        ]);
    }

    public function resetForm()
    {
        $this->Program['name']         = '';
        $this->Program['description']  = '';
        $this->Program['status']       = false;
    }

    public function changePage($page)
    {
        $this->currentPage = $page;
    }

    public function searchReport()
    {
        $text = '%' . $this->searchText . '%';
        if($this->searchText) {
            $programs = Program::where('program', 'like', $text)->with('schedule')->get();
            if($programs) {
                $this->searchResult = $programs;
            } else {
                $this->emit('plashMessage', [
                    'type'      => 'warning',
                    'message'   => ' No record found'
                ]);
                $this->searchResult = null;
            }
        } else {
            $this->searchResult = Program::with('schedule')->get();
        }
    }

    public function printReport()
    {
        if ($this->searchResult) {
            $path = public_path('adverts/reports');
            $data = [
                'programs'      => $this->searchResult,
                'searchText'    => $this->searchText
            ];

            $pdf = PDF::loadView('reports.program', $data);
            $fileName =  'programs-schedule' .env('STATION_NAME') .'-' .env('STATION_LOCATION') .'.pdf';

            $pdf->save($path . '/' . $fileName);
            return response()->download($path . '/' . $fileName);
        }
    }

    public function render()
    {
        $programs = Program::latest()->with('schedule')->paginate(10);
        return view('livewire.program.program-index', compact('programs'))->extends('layouts.app')->section('content');
    }
}
