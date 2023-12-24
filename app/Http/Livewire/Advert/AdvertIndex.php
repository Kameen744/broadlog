<?php

namespace App\Http\Livewire\Advert;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Advert\Advert;
use App\Models\Advert\AdvertFile;
use App\Models\Advert\AdvertType;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use App\Models\Advert\AdvertSchedule;

class AdvertIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'advertSaved' => 'newAdvertCreated',
        'advertUpdated' => 'endEdit',
        'newFileUploaded' => 'newFileUploaded',
        'bookedSlots' => 'getCurrentSchedules'
    ];

    public $files = null;
    public $edit = null;
    public $advert = null;
    public $viewingAdvert = null;
    public $c_schedules = null;
    public $currentPage = 'index';
    // public $editFile = null;
    public $todaySchedules;
    public $today;

    public $discount = '%';
    public $commission = '%';
    public $seconds = 'Seconds';

    public $searchAdvertScheduleText = '';

    public $form = [
        'client'            => '',
        'email'             => '',
        'phone_no'          => '',
        'source'            => '',
        'duration'          => '',
        'rate'              => '',
        'slots'             => '',
        'discount'          => '',
        'commision'         => '',
        'paid'              => '',
        'start_date'        => '',
        'finish_date'       => '',
        'advert_type_id'    => ''
    ];

    public function store()
    {
        $this->ValidateRequest();
        $this->convertPercent();
        $this->toSeconds();
        $advert = Advert::create($this->form);
        $this->advert = $advert;

        $this->emit('plashMessage', [
            'type' => 'success',
            'message' => 'Advert successfully saved.'
        ]);

        $this->emit('advertSaved');
        $this->emit('addFileEvent', $advert);
    }

    public function newAdvert()
    {
        if($this->edit) {
            $this->edit = null;
            $this->clearForm();
        }

        $this->currentPage = 'new';
    }

    public function newAdvertCreated()
    {
        $this->clearForm();
    }

    public function edit(Advert $advert)
    {
        $this->edit = $advert->id;
        $this->commission = '₦';
        $this->discount = '₦';

        $this->form['client']            = $advert->client;
        $this->form['email']             = $advert->email;
        $this->form['phone_no']          = $advert->phone_no;
        $this->form['source']            = $advert->source;
        $this->form['duration']          = $advert->duration;
        $this->form['rate']              = $advert->rate;
        $this->form['slots']             = $advert->slots;
        $this->form['discount']          = $advert->discount;
        $this->form['commision']         = $advert->commision;
        $this->form['paid']              = $advert->paid;
        $this->form['start_date']        = $advert->start_date;
        $this->form['finish_date']       = $advert->finish_date;
        $this->form['advert_type_id']    = $advert->advert_type_id;

        $this->currentPage = 'new';
    }

    public function editFile($file_id)
    {
        $this->emit('editFile', $file_id);
    }

    public function editSchedule($schedule_id)
    {
        $this->emit('editSchedule', $schedule_id);
    }

    public function endEdit()
    {
        $this->edit = null;
        $this->clearForm();
    }

    public function view(Advert $advert)
    {
        $this->viewingAdvert = $advert;
        $this->newFileUploaded($advert->id);
        $this->getCurrentSchedules($advert->id);
        $this->currentPage = 'view';
        $this->render();
    }

    public function endViewing()
    {
        $this->emit('endViewingAdvert');
    }

    public function update(Advert $advert)
    {
        $this->ValidateRequest();
        $advert->update($this->form);

        $this->emit('plashMessage', [
            'type' => 'success',
            'message' => 'Advert successfully updated'
        ]);

        $this->emit('advertUpdated');
        $this->render();
    }

    public function newFileUploaded($advert_id)
    {
        $this->files = AdvertFile::latest()->where('advert_id', $advert_id)->get();
    }

    public function delete(Advert $advert)
    {
        $advert->delete();
        AdvertSchedule::where('advert_id', $advert->id)->delete();
        $this->emit('plashMessage', [
            'type' => 'error',
            'message' => 'Advert deleted'
        ]);
        $this->render();
    }

    public function deleteFile(AdvertFile $file)
    {
        $file_path = public_path('/adverts/uploads/' . $file->file);
        if (file_exists($file_path)) {
            unlink($file_path);
            $file->delete();
            $this->emit('plashMessage', [
                'type' => 'error',
                'message' => $file->file . ' deleted.'
            ]);
            $this->newFileUploaded($file->advert_id);
        }
    }

    public function deleteSchedule($schedule_id)
    {
        $this->emit('deleteSchedule', $schedule_id);
    }

    public function clearForm()
    {
        $this->form['client']            = '';
        $this->form['email']             = '';
        $this->form['phone_no']          = '';
        $this->form['source']            = '';
        $this->form['duration']          = '';
        $this->form['rate']              = '';
        $this->form['slots']             = '';
        $this->form['discount']          = '';
        $this->form['commision']         = '';
        $this->form['paid']              = '';
        $this->form['start_date']        = '';
        $this->form['finish_date']       = '';
        $this->form['advert_type_id']    = '';
    }
    // add current advert files event
    public function addFile(Advert $advert)
    {
        $this->emit('addFileEvent', $advert);
    }
    // add current advert schedule event
    public function addSchedule(Advert $advert)
    {
        $this->emit('addScheduleEvent', $advert);
    }
    // get advert shedules for the current advert
    public function getCurrentSchedules($advert_id)
    {
        $this->c_schedules =  AdvertSchedule::where('advert_id', $advert_id)->get();
    }

    public function ValidateRequest()
    {
        $this->validate([
            'form.client'            => 'required',
            'form.email'             => 'required|email',
            'form.phone_no'          => 'required|numeric',
            'form.source'            => 'required',
            'form.duration'          => 'required|numeric',
            'form.rate'              => 'required|numeric',
            'form.slots'             => 'required|numeric',
            'form.discount'          => 'required|numeric',
            'form.commision'         => 'required|numeric',
            'form.paid'              => 'required|numeric',
            'form.start_date'        => 'required|date',
            'form.finish_date'       => 'required|date',
            'form.advert_type_id'    => 'required|numeric'
        ]);
    }

    public function ValidateRequestFile()
    {
    }

    public function changePercent($feild)
    {
        $this->setDefaultValues();

        if ($feild === 'commision') {
            if ($this->commission === '%') {
                $this->commission = '₦';
                $this->form['commision'] = $this->toCurrency('commision');
            } else {
                $this->commission = '%';
                $this->form['commision'] = $this->toPercent('commision');
            }
        } elseif ($feild === 'discount') {
            if ($this->discount === '%') {
                $this->discount = '₦';
                $this->form['discount'] = $this->toCurrency('discount');
            } else {
                $this->discount = '%';
                $this->form['discount'] = $this->toPercent('discount');
            }
        }
    }
    public function getAdvertTotalAmount()
    {
        $this->setDefaultValues();
        return ($this->form['rate'] * $this->form['slots']);
    }

    public function toPercent($value)
    {
        if ($value === 'commision') {
            $amount = $this->getAdvertTotalAmount();
            if ($this->form['commision'] > 0) {
                return ($this->form['commision'] / $amount) * 100;
            }
        } elseif ($value === 'discount') {
            $amount = $this->getAdvertTotalAmount();
            if ($this->form['discount'] > 0) {
                return ($this->form['discount'] / $amount) * 100;
            }
        }
    }

    public function toCurrency($value)
    {
        if ($value === 'commision') {
            $amount = $this->getAdvertTotalAmount();
            return ($amount / 100) * $this->form['commision'];
        } elseif ($value === 'discount') {
            $amount = $this->getAdvertTotalAmount();
            return ($amount / 100) * $this->form['discount'];
        }
    }

    public function setDefaultValues()
    {
        $form_elements = ['commision', 'discount', 'rate', 'slots', 'duration'];
        foreach ($form_elements as $element) {
            if ($this->form[$element] === '') {
                $this->form[$element] = 0;
            }
        }
    }

    public function convertPercent()
    {
        $this->setDefaultValues();

        if ($this->commission === '%') {
            $this->form['commision'] = $this->toCurrency('commision');
        }

        if ($this->discount === '%') {
            $this->form['discount'] = $this->toCurrency('discount');
        }
    }

    public function changeDuration()
    {
        $this->setDefaultValues();

        if ($this->seconds === 'Seconds') {
            $this->seconds = 'Minutes';
            $this->form['duration'] = $this->toMinutes();
        } else {
            $this->seconds = 'Seconds';
            $this->form['duration'] = $this->toSeconds();
        }
    }

    public function toSeconds()
    {
        return $this->form['duration'] * 60;
    }

    public function toMinutes()
    {
        return $this->form['duration'] / 60;
    }
    // View advert schedule
    public function viewAdvertSchedule()
    {
        // $this->now =  date_format(now(), 'h:i A');
        $this->today = date_format(now(), 'D d-m-Y');
        $today = date_format(now(), 'Y-m-d');
        $this->getAdvertSchedule($today);
        $this->currentPage = 'viewSchedule';
        // $this->emit('viewTodayAdvertSchedules');
    }

    public function getAdvertSchedule($date) {
        $this->todaySchedules = AdvertSchedule::where('play_date', $date)
            ->where('status', 1)
            ->orderBy('play_time', 'asc')
            ->get();
    }

    public function saveSchedulesPDF()
    {
        if ($this->todaySchedules) {
            $today = date_format(now(), 'Y-m-d');
            $path = public_path('adverts/reports');
            $fileName =  env('STATION_NAME') . env('STATION_LOCATION') . 'Schedule' . $today . '.pdf';

            $pdf = PDF::loadView(
                'reports.adverts.advert-schedule',
                [
                    'schedules' => $this->todaySchedules,
                    'today' => $this->today
                ]
            );

            $pdf->save($path . '/' . $fileName);
            return response()->download($path . '/' . $fileName);
        } else {
            $this->emit('plashMessage', [
                'type' => 'warning',
                'message' => 'No record found.'
            ]);
        }
    }

    public function genInvoice()
    {

    }

    public function genCot()
    {

    }

    public function searchSchedules()
    {
        if(!empty($this->searchAdvertScheduleText)) {
            $date = Carbon::createFromFormat('Y-m-d', $this->searchAdvertScheduleText);
            $this->today = date_format($date, 'D d-m-Y');

            $this->getAdvertSchedule($this->searchAdvertScheduleText);
        } else {
            $this->emit('plashMessage', [
                'type' => 'warning',
                'message' => 'Select date to search for schedule'
            ]);
        }
    }

    public function changePage($page)
    {
        $this->currentPage = $page;
    }

    public function render()
    {
        $adverts = Advert::latest()->with('type')->paginate(10);
        $types = AdvertType::all();
        $cadvert = $this->viewingAdvert;
        return view('livewire.advert.advert-index', compact('adverts', 'types', 'cadvert'))
            ->extends('layouts.app')
            ->section('content');
    }
}
