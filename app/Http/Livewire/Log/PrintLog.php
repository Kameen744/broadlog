<?php

namespace App\Http\Livewire\Log;

use Livewire\Component;

class PrintLog extends Component
{
    protected $listeners = ['PrintEvent'];

    public $logs = null;
    public $data;

    public function PrintEvent($data)
    {
        $this->logs = $data;
        $this->emit('printResult');
    }

    public function render()
    {
        return view('livewire.log.print-log')
            ->extends('layouts.app')
            ->section('content');
        // ->extends('reports.main')->section('report');
    }
}
