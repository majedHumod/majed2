<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Login extends Component
{
    public LoginForm $form;

    public function login()
    {
        $this->validate([
            'form.email' => ['required', 'email'],
            'form.password' => ['required'],
        ]);

        try {
            $this->form->authenticate();

            Session::regenerate();

            return redirect()->intended(route('dashboard'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->addError('form.email', trans('auth.failed'));
            return null;
        }
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('components.layouts.guest');
    }
}