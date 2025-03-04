<?php

namespace App\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VerifyEmail extends Component
{
    public function resend()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        Auth::user()->sendEmailVerificationNotification();

        $this->dispatch('resent');

        session()->flash('status', 'verification-link-sent');
    }

    public function render()
    {
        return view('livewire.auth.verify-email')
            ->layout('components.layouts.guest');
    }
}