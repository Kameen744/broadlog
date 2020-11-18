<?php

namespace App\Http\Livewire\Program;

use Livewire\Component;

class ProgramIndex extends Component
{
    public $form = [
        'name'          => '',
        'description'   => '',
        'status'        => ''
    ];

    public function render()
    {
        return view('livewire.program.program-index');
    }
}
