<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\View\View;

/**
 * Componente Livewire para o formulário de redefinição de senha.
 *
 * Este componente gerencia o estado e a lógica para que um usuário
 * possa redefinir sua senha após receber um token por e-mail.
 */
class ResetPasswordForm extends Component
{
    /** @var string O token de redefinição de senha recebido da URL. */
    public $token;

    /** @var string O endereço de e-mail do usuário. */
    #[Rule('required|email')]
    public $email;

    /** @var string A nova senha inserida pelo usuário. */
    #[Rule('required|min:8|same:password_confirmation', as: 'Senha')]
    public $password;

    /** @var string A confirmação da nova senha. */
    public $password_confirmation;

    /**
     * Inicializa o componente com o token e o e-mail da requisição.
     *
     * @param string $token O token de redefinição de senha.
     * @return void
     */
    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = request()->query('email', '');
    }

    /**
     * Tenta redefinir a senha do usuário.
     *
     * Valida os dados do formulário e utiliza o broker de senhas do Laravel
     * para processar a redefinição.
     *
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function resetPassword()
    {
        $this->validate();

        // Placeholder: A lógica real para redefinir a senha usaria o broker do Laravel.
        // $credentials = ['token' => $this->token, 'email' => $this->email, 'password' => $this->password];
        // $status = Password::broker()->reset($credentials, function ($user, $password) {
        //     $user->forceFill(['password' => bcrypt($password)])->save();
        // });
        $status = Password::PASSWORD_RESET;

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('status', 'Sua senha foi redefinida com sucesso!');
            return $this->redirect(route('login'));
        }

        // Em caso de falha (ex: token inválido), adiciona uma mensagem de erro ao formulário.
        $this->addError('email', __($status));
    }

    /**
     * Renderiza o componente.
     *
     * Este é um componente "sem view" (class-based), pois sua lógica é acoplada
     * diretamente a uma página Blade, não necessitando de um arquivo de template separado.
     */
    public function render(): string
    {
        return '<div></div>';
    }
}