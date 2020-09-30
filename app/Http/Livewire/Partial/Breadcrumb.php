<?php

namespace App\Http\Livewire\Partial;

use Livewire\Component;

class Breadcrumb extends Component
{
    public $links;
    public $page;

    public function render()
    {
        return view('livewire.partial.breadcrumb');
    }
}
