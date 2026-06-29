<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class UserPermissions extends Component
{
    public User $user;
    public $allPermissions = [];
    public $userPermissions = [];

    public function mount($userId)
    {
        // Carrega o usuário do banco de dados. O método findOrFail irá
        // gerar um erro 404 se o usuário não for encontrado.
        $this->user = User::findOrFail($userId);

        // Carrega todas as permissões do sistema, agrupadas por módulo.
        // Presume-se que exista um arquivo de configuração para isso.
        $this->allPermissions = config('permissions.map');

        // Verifica se o usuário tem uma role de super-administrador.
        // Esta é uma abordagem comum com pacotes como spatie/laravel-permission.
        // Se for admin, preenchemos todas as permissões.
        if ($this->user->hasRole('Administrador')) {
            $this->userPermissions = array_keys(config('permissions.map'));
        } else {
            // Caso contrário, carrega as permissões diretas do usuário.
            // O método getPermissionNames() é fornecido pelo pacote spatie/laravel-permission.
            $this->userPermissions = $this->user->getPermissionNames()->toArray();
        }
    }

    public function submit()
    {
        // Sincroniza as permissões selecionadas com o usuário no banco de dados.
        // O método syncPermissions é uma forma segura de atualizar, adicionando
        // e removendo permissões conforme necessário.
        $this->user->syncPermissions($this->userPermissions);

        session()->flash('message', 'Permissões do usuário atualizadas com sucesso!');
        return $this->redirect(route('admin.users.index'));
    }

    public function render()
    {
        return view('livewire.admin.user-permissions');
    }
}