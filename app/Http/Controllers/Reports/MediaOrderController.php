<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Models\Advert\AdvertType;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;

class MediaOrderController extends Controller
{
    public function download($logs)
    {
        $types = AdvertType::all();
        $pdf = PDF::loadView('reports.media', compact('types', 'logs'));
        return $pdf->download('media.pdf');

        // return view('reports.media');
    }
}
