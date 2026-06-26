<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Rule;

class EditUserForm extends Component
{
    public $user;

    #[Rule('required|min:3', as: 'Nome Completo')]
    public $name = '';

    #[Rule('required|email', as: 'E-mail')]
    public $email = '';

    #[Rule('required', as: 'Perfil de Acesso')]
    public $role = '';

    #[Rule('required', as: 'Status')]
    public $status = '';

    #[Rule('required_if:role,Analista|required_if:role,Agente Fiscal|string|min:11', as: 'CPF')]
    public $cpf = '';

    #[Rule('required_if:role,Analista|required_if:role,Agente Fiscal|string|min:10', as: 'Celular')]
    public $celular = '';

    #[Rule('required_if:role,Analista|required_if:role,Agente Fiscal|string', as: 'Matrícula Funcional')]
    public $matricula = '';

    public function mount($userId)
    {
        // Placeholder: Em uma aplicação real, buscaria o usuário do banco de dados.
        // Ex: $this->user = User::findOrFail($userId);
        $allUsers = collect([
            ['id' => 1, 'name' => 'Márcio Rodrigues', 'email' => 'marcio.oliveira@semarh.gov.br', 'role' => 'Administrador', 'status' => 'Ativo'],
            ['id' => 2, 'name' => 'Carlos Ferreira', 'email' => 'carlos.ferreira@semarh.gov.br', 'role' => 'Analista', 'status' => 'Ativo', 'cpf' => '111.222.333-44', 'celular' => '(62) 91111-2222', 'matricula' => '12345'],
            ['id' => 3, 'name' => 'Ana Souza', 'email' => 'ana.souza@semarh.gov.br', 'role' => 'Analista', 'status' => 'Ativo', 'cpf' => '222.333.444-55', 'celular' => '(62) 92222-3333', 'matricula' => '12346'],
            ['id' => 4, 'name' => 'Agente Fiscal 001', 'email' => 'agente.001@semarh.gov.br', 'role' => 'Agente Fiscal', 'status' => 'Ativo', 'cpf' => '333.444.555-66', 'celular' => '(62) 93333-4444', 'matricula' => '78901'],
            ['id' => 5, 'name' => 'Agente Fiscal 002', 'email' => 'agente.002@semarh.gov.br', 'role' => 'Agente Fiscal', 'status' => 'Inativo', 'cpf' => '444.555.666-77', 'celular' => '(62) 94444-5555', 'matricula' => '78902'],
        ]);
        $this->user = $allUsers->firstWhere('id', (int) $userId);

        $this->name = $this->user['name'];
        $this->email = $this->user['email'];
        $this->role = $this->user['role'];
        $this->status = $this->user['status'];
        $this->cpf = $this->user['cpf'] ?? '';
        $this->celular = $this->user['celular'] ?? '';
        $this->matricula = $this->user['matricula'] ?? '';
    }

    public function submit()
    {
        // A validação de e-mail único deve ignorar o próprio usuário.
        $this->validate([
            'email' => 'required|email|unique:users,email,' . $this->user['id'],
            'name' => 'required|min:3',
            'role' => 'required',
            'status' => 'required',
        ]);

        // Placeholder: Lógica para atualizar o usuário no banco de dados.
        // Ex: $this->user->update([...]);

        session()->flash('message', 'Usuário atualizado com sucesso!');
        return $this->redirect(route('admin.users.index'));
    }

    /**
     * Envia um link de redefinição de senha para o usuário.
     */
    public function sendPasswordReset()
    {
        // Placeholder: Lógica para gerar um token e enviar o e-mail de reset de senha.
        // Ex: Password::sendResetLink(['email' => $this->user['email']]);

        session()->flash('password_reset_message', 'Link para redefinição de senha enviado para ' . $this->user['email'] . '.');
    }

    public function render()
    {
        return view('livewire.admin.edit-user-form');
    }
}