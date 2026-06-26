<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Rule;

class ForgotPasswordForm extends Component
{
    #[Rule('required|email', as: 'E-mail')]
    public $email = '';

    public $emailSentMessage = '';

    /**
     * Envia o link de redefinição de senha.
     */
    public function sendResetLink()
    {
        $this->validate();

        // Placeholder: Lógica para enviar o e-mail de redefinição.
        // Ex: Password::sendResetLink(['email' => $this->email]);

        $this->emailSentMessage = 'Se um e-mail correspondente for encontrado, um link de redefinição de senha será enviado.';
    }

    public function render()
    {
        return view('livewire.auth.forgot-password-form');
    }
}