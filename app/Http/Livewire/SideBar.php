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
                    ['name' => 'Opening Days', 'route' => 'opening.days.index', 'icon' => 'fas fa-door-open']
                ]
            ],
            [
                'title' => 'Adverts',
                'props' => [
                    ['name' => 'Adverts Type', 'route' => 'advert.type.index', 'icon' => 'fas fa-id-badge'],
                    ['name' => 'Adverts', 'route' => 'advert.index', 'icon' => 'fas fa-calendar']
                ],
            ],
            [
                'title' => 'Programs',
                'props' => [
                    ['name' => 'Programs', 'route' => 'program.index', 'icon' => 'fas fa-procedures']
                ],
            ],
            [
                'title' => 'Digital Log',
                'props' => [
                    ['name' => 'Players/Log', 'route' => 'log.index', 'icon' => 'fas fa-stack']
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
