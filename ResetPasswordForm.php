<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Password;

class ResetPasswordForm extends Component
{
    public $token;

    #[Rule('required|email')]
    public $email;

    #[Rule('required|min:8|same:password_confirmation', as: 'Senha')]
    public $password;

    public $password_confirmation;

    public function mount($token)
    {
        $this->token = $token;
        $this->email = request()->query('email', '');
    }

    public function resetPassword()
    {
        $this->validate();

        // Placeholder: Lógica para redefinir a senha.
        // Em um projeto real, isso usaria o broker de senhas do Laravel.
        // $status = Password::broker()->reset([...]);

        // Simulação de sucesso para o protótipo
        $status = Password::PASSWORD_RESET;

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('status', 'Sua senha foi redefinida com sucesso!');
            return $this->redirect(route('login'));
        }

        // Em caso de falha (ex: token inválido), adiciona um erro.
        $this->addError('email', __($status));
    }

    public function render()
    {
        // Este componente será renderizado inline na página Blade.
        return <<<'HTML'
            <div></div>
        HTML;
    }
}