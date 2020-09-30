<?php

namespace App\Http\Livewire\Advert;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Advert\AdvertType as Types;

class AdvertType extends Component
{
    use WithPagination;

    public $edit = null;
    public $type = '';

    public function store()
    {
        $this->ValidateRquest();
        Types::create(['type' => $this->type]);
        $this->ClearType();
    }

    public function edit(Types $typ)
    {
        $this->type = $typ->type;
        $this->edit = $typ->id;
    }

    public function update(Types $typ)
    {
        $this->ValidateRquest();
        $typ->update(['type' => $this->type]);
        $this->ClearType();
        $this->edit = null;
        $this->render();
    }

    public function ClearType()
    {
        $this->type = '';
    }

    public function ValidateRquest()
    {
        $this->validate([
            'type' => 'required'
        ]);
    }

    public function render()
    {
        $types = Types::paginate(10);

        return view('livewire.advert.advert-type', compact('types'))
            ->extends('layouts.app')
            ->section('content');
    }
}
