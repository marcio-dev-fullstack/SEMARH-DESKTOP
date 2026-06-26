<?php

namespace App\Livewire\Admin;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class UserList extends Component
{
    use WithPagination;

    #[Url(keep: true)]
    public $search = '';

    /**
     * Renderiza o componente com a lista de usuários paginada.
     */
    public function render()
    {
        // Placeholder: Em uma aplicação real, isso viria do banco de dados.
        // Ex: $users = User::paginate(15);
        $allUsers = collect([
            ['id' => 1, 'name' => 'Márcio Rodrigues', 'email' => 'marcio.oliveira@semarh.gov.br', 'role' => 'Administrador', 'status' => 'Ativo'],
            ['id' => 2, 'name' => 'Carlos Ferreira', 'email' => 'carlos.ferreira@semarh.gov.br', 'role' => 'Analista', 'status' => 'Ativo'],
            ['id' => 3, 'name' => 'Ana Souza', 'email' => 'ana.souza@semarh.gov.br', 'role' => 'Analista', 'status' => 'Ativo'],
            ['id' => 4, 'name' => 'Agente Fiscal 001', 'email' => 'agente.001@semarh.gov.br', 'role' => 'Agente Fiscal', 'status' => 'Ativo'],
            ['id' => 5, 'name' => 'Agente Fiscal 002', 'email' => 'agente.002@semarh.gov.br', 'role' => 'Agente Fiscal', 'status' => 'Inativo'],
        ]);

        $filteredUsers = $allUsers->when($this->search, function ($query) {
            return $query->filter(function ($user) {
                return str_contains(strtolower($user['name']), strtolower($this->search)) ||
                       str_contains(strtolower($user['email']), strtolower($this->search));
            });
        });

        // Paginação manual da coleção de dados de exemplo.
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentPageItems = $filteredUsers->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $users = new LengthAwarePaginator($currentPageItems, $filteredUsers->count(), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('livewire.admin.user-list', compact('users'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}