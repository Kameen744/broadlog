<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SideBar extends Component
{
    public $username;

    public $links;

    public function mount()
    {
        $this->links = [
            [
                'title' => 'Station',
                'props' => [
                    ['name' => 'Opening Days', 'route' => 'opening.days.index']
                ]
            ],
            [
                'title' => 'Adverts',
                'props' => [
                    ['name' => 'Adverts Type', 'route' => 'advert.type.index'],
                    ['name' => 'Adverts', 'route' => 'advert.index']
                ],
            ],
            [
                'title' => 'Programs',
                'props' => [
                    ['name' => 'Programs', 'route' => 'program.index'],
                    ['name' => 'Programs Schedule', 'route' => 'program.index']
                ],
            ]

        ];
    }

    public function render()
    {
        $this->username = Auth::guard('admin')->user()->username;

        return view('livewire.side-bar', ['username' => $this->username]);
    }
}
