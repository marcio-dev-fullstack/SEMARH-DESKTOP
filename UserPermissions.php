<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class UserPermissions extends Component
{
    public $user;
    public $allPermissions = [];
    public $userPermissions = [];

    public function mount($userId)
    {
        // Placeholder: Carrega o usuário e suas permissões do banco de dados.
        $allUsers = collect([
            ['id' => 1, 'name' => 'Márcio Rodrigues', 'role' => 'Administrador', 'permissions' => ['*']],
            ['id' => 2, 'name' => 'Carlos Ferreira', 'role' => 'Analista', 'permissions' => ['processes.view', 'processes.edit', 'complaints.view']],
            ['id' => 3, 'name' => 'Ana Souza', 'role' => 'Analista', 'permissions' => ['processes.view', 'processes.edit']],
            ['id' => 4, 'name' => 'Agente Fiscal 001', 'role' => 'Agente Fiscal', 'permissions' => ['inspections.view', 'inspections.create', 'complaints.view']],
            ['id' => 5, 'name' => 'Agente Fiscal 002', 'role' => 'Agente Fiscal', 'permissions' => ['inspections.view']],
        ]);
        $this->user = $allUsers->firstWhere('id', (int) $userId);

        // Se o usuário for admin, marca todas as permissões e desabilita a edição.
        if (in_array('*', $this->user['permissions'])) {
            $this->userPermissions = array_keys(config('permissions.map'));
        } else {
            $this->userPermissions = $this->user['permissions'];
        }

        // Carrega todas as permissões do sistema, agrupadas por módulo.
        $this->allPermissions = config('permissions.map');
    }

    public function submit()
    {
        // Placeholder: Lógica para salvar as permissões no banco de dados.
        // Ex: $this->user->syncPermissions($this->userPermissions);

        session()->flash('message', 'Permissões do usuário atualizadas com sucesso!');
        return $this->redirect(route('admin.users.index'));
    }

    public function render()
    {
        return view('livewire.admin.user-permissions');
    }
}