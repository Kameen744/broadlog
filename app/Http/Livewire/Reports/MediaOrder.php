<?php

namespace App\Http\Livewire\Reports;

use Livewire\Component;
use Barryvdh\DomPDF\PDF;

class MediaOrder extends Component
{


    public function mediaOrderPdf()
    {
        $pdf = PDF::loadView($this->render());
        return $pdf->download('media.pdf');
    }

    public function render()
    {
        return view('livewire.reports.media-order')
            ->extends('layouts.app')
            ->section('content');
    }
}
