<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLogin extends Component
{

    public $form = [
        'username' => '',
        'password' => '',
    ];

    public $remember = false;

    public function submit()
    {
        $this->validate([
            'form.username' => 'required|min:4',
            'form.password' => 'required|min:4'
        ]);

        if (Auth::guard('admin')->attempt($this->form, $this->remember)) {
            return redirect(route('admin.dashboard'));
            // return redirect()->intended(route('admin.dashboard'))->with(['message' => 'Successfully logged in']);
        }

        throw ValidationException::withMessages([
            'form.username' => [trans('auth.failed')],
        ]);
    }

    public function CheckAuth()
    {
        if (Auth::guard('admin')->check()) {
            return redirect(route('admin.dashboard'));
        }
    }

    public function render()
    {
        $this->CheckAuth();

        return view('livewire.auth.admin-login')
            ->extends('layouts.app')
                ->section('content');
    }
}
