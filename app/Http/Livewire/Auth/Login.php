<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Login extends Component
{
    public $form = [
        'username' => '',
        'password' => '',
    ];

    public $remember = true;

    public function submit()
    {
        $this->validate([
            'form.username' => 'required|min:4',
            'form.password' => 'required|min:4'
        ]);

        if (Auth::attempt($this->form, $this->remember)) {
            return redirect()->route('user.dashboard');
        }

        throw ValidationException::withMessages([
            'form.username' => [trans('auth.failed')],
        ]);
    }

    public function CheckAuth()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
    }

    public function render()
    {
        $this->CheckAuth();

        return view('livewire.auth.login')
            ->extends('layouts.app')
            ->section('content');
    }
}
