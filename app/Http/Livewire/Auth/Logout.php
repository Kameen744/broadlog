<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Logout extends Component
{
    public $user = '';

    public function logout()
    {

        switch ($this->user) {
            case 'admin':
                    Auth::guard('admin')->logout();
                    return redirect('/admin');
                break;
            default:
                    Auth::logout();
                    return redirect('/');
                break;
        }
    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}
