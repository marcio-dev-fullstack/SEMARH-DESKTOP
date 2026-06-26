<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Rule;

class CreateUserForm extends Component
{
    #[Rule('required|min:3', as: 'Nome Completo')]
    public $name = '';

    #[Rule('required|email|unique:users,email', as: 'E-mail')]
    public $email = '';

    #[Rule('required', as: 'Perfil de Acesso')]
    public $role = '';

    #[Rule('required_if:role,Analista|required_if:role,Agente Fiscal|string|min:11', as: 'CPF')]
    public $cpf = '';

    #[Rule('required_if:role,Analista|required_if:role,Agente Fiscal|string|min:10', as: 'Celular')]
    public $celular = '';

    #[Rule('required_if:role,Analista|required_if:role,Agente Fiscal|string', as: 'Matrícula Funcional')]
    public $matricula = '';

    /**
     * Salva o novo usuário e envia o convite.
     */
    public function submit()
    {
        $this->validate();

        // Placeholder: Lógica para criar o usuário e enviar um e-mail de convite/definição de senha.
        // 1. Criar o usuário com uma senha temporária ou nula.
        // 2. Gerar um token de convite (o "ticket").
        // 3. Enviar um e-mail para $this->email com um link contendo o token.
        // Ex: User::create([
        //      'name' => $this->name, 'email' => $this->email, 'role' => $this->role,
        //      'cpf' => $this->cpf, 'celular' => $this->celular, 'matricula' => $this->matricula
        // ]);

        // Ex: User::create([...]);

        session()->flash('message', 'Convite enviado com sucesso para ' . $this->email . '.');

        return $this->redirect(route('admin.users.index'));
    }

    public function render()
    {
        return view('livewire.admin.create-user-form');
    }
}