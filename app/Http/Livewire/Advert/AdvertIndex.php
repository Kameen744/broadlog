<?php

namespace App\Http\Livewire\Advert;

use Livewire\Component;
use App\Models\Advert\Advert;
use App\Models\Advert\AdvertType;
use Illuminate\Support\Facades\Auth;

class AdvertIndex extends Component
{
    public $edit = null;
    public $from = [
        'client'            =>'',
        'email'             =>'',
        'phone_no'          =>'',
        'duration'          =>'',
        'rate'              =>'',
        'slots'             =>'',
        'discount'          =>'',
        'commision'         =>'',
        'start_date'        =>'',
        'finish_date'       =>'',
        'advert_type_id'    =>''
    ];

    public function store()
    {
        
    }

    public function edit(Advert $advert)
    {

    }

    public function update(Advert $advert)
    {

    }

    public function render()
    {
        $adverts = Advert::latest()->paginate(10);
        $types = AdvertType::all();

        return view('livewire.advert.advert-index', compact('adverts', 'types'))
            ->extends('layouts.app')
            ->section('content');
    }
}
