<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPassword extends Component
{
    public string $email = '';

    public function sendPasswordResetLink()
    {
        $this->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
        }

        $this->reset('email');
    }

    public function render()
    {
        return view('livewire.auth.forgot-password')
            ->layout('components.layouts.guest');
    }
}