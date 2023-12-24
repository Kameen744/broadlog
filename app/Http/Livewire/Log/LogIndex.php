<?php

namespace App\Http\Livewire\Log;

use App\Models\Log\Log;
use Livewire\Component;
use App\Http\Helper\ReadLog;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

class LogIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $searchText = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $searchResult = null;

    public function checkForm() {
        $no = 0;
        // searchtext = 1, dateFrom = 2 and dateTo = 3
        // if all three fields are filled = 6;
        $form = [$this->searchText, $this->dateFrom, $this->dateTo];
        foreach ($form as $key => $value) {
            if(!empty($value)) {
                $no += ($key + 1);
            }
        }
        return $no;
    }

    public function search()
    {

        if (!empty($this->searchText)) {
            $text = '%' . $this->searchText . '%';
            if(!empty($this->dateFrom)) {
                if(!empty($this->dateTo)) {
                    $this->searchResult = Log::where('name', 'like', $text)
                    ->where('date_played', '>=', $this->dateFrom)
                    ->where('date_played', '<=', $this->dateTo)
                    ->orderBy('date_played', 'asc')
                    // ->orderBy('time_played', 'asc')
                    ->get();
                } else {
                    $this->searchResult = Log::where('name', 'like', $text)
                    ->where('date_played', $this->dateFrom)
                    ->orderBy('date_played', 'asc')
                    ->orderBy('time_played', 'asc')
                    ->get();
                }
            } else {
                $this->searchResult = Log::where('name', 'like', $text)
                ->orderBy('date_played', 'asc')
                ->orderBy('time_played', 'asc')
                ->get();
            }
        } else {
            if(!empty($this->dateFrom)) {
                if(!empty($this->dateTo)) {
                    $this->searchResult = Log::where('date_played', '>=', $this->dateFrom)
                    ->where('date_played', '<=', $this->dateTo)
                    ->orderBy('date_played', 'asc')
                    ->orderBy('time_played', 'asc')
                    ->get();
                    // dd($this->searchResult->first());
                } else {
                    $this->searchResult = Log::where('date_played', $this->dateFrom)
                    ->orderBy('date_played', 'asc')
                    ->orderBy('time_played', 'asc')
                    ->get();
                }
            }
        }

        $this->render();
    }

    public function EmitPrint()
    {
        if ($this->searchResult) {
            $path = public_path('adverts/reports');
            $data = [
                'logs'          => $this->searchResult,
                'searchText'    => $this->searchText,
                'dateFrom'      => $this->dateFrom,
                'dateTo'        => $this->dateTo
            ];

            $fileName =  env('STATION_NAME') . env('STATION_LOCATION') . 'Log.pdf';

            $pdf = PDF::loadView('reports.log', $data);
            $pdf->save($path . '/' . $fileName);
            return response()->download($path . '/' . $fileName);
        } else {
            $this->emit('plashMessage', [
                'type' => 'warning',
                'message' => ' Search for record or use date-range to filter result.'
            ]);
        }
    }

    public function render()
    {
        if ($this->searchResult) {
            $logs = $this->searchResult;
        } else {
            if(env('VIRTUAL_DJ')) {
                $newRecords = ReadLog::VirtualDJ();
                $createRecords = [];
                foreach ($newRecords as $key => $record) {
                    $recordExist = Log::where('name', $record['name'])
                    ->where('date_played', $record['date_played'])
                    ->where('time_played', $record['time_played'])
                    ->first();
                    if($recordExist === null) {
                        array_push($createRecords, $record);
                    }
                }
                try {
                    Log::insert($createRecords);
                } catch (\Throwable $th) {

                }
            } else {
                $newRecords = ReadLog::Jazler();
            }

            $logs = Log::paginate(20);
        }

        return view('livewire.log.log-index', compact('logs'))
            ->extends('layouts.app')
            ->section('content');
    }
}
