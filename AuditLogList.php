<?php

namespace App\Livewire\Admin;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class AuditLogList extends Component
{
    use WithPagination;

    #[Url(keep: true)]
    public $search = '';

    public function render()
    {
        // Placeholder: Em uma aplicação real, isso viria do banco de dados.
        // Ex: $logs = AuditLog::with('user')->latest()->paginate(20);
        $allLogs = collect([
            ['id' => 1, 'user' => 'Márcio Rodrigues', 'action' => 'updated', 'auditable' => 'Usuário: Carlos Ferreira', 'ip_address' => '192.168.1.10', 'created_at' => now()->subMinutes(5)],
            ['id' => 2, 'user' => 'Carlos Ferreira', 'action' => 'created', 'auditable' => 'Processo: 202601-12345', 'ip_address' => '192.168.1.12', 'created_at' => now()->subMinutes(30)],
            ['id' => 3, 'user' => 'Ana Souza', 'action' => 'updated', 'auditable' => 'Denúncia: DEN-2026-002', 'ip_address' => '192.168.1.15', 'created_at' => now()->subHours(1)],
            ['id' => 4, 'user' => 'Márcio Rodrigues', 'action' => 'login', 'auditable' => 'Autenticação', 'ip_address' => '192.168.1.10', 'created_at' => now()->subHours(2)],
        ]);

        $filteredLogs = $allLogs->when($this->search, function ($query) {
            return $query->filter(fn ($log) => str_contains(strtolower(implode(' ', $log)), strtolower($this->search)));
        });

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        $currentPageItems = $filteredLogs->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $logs = new LengthAwarePaginator($currentPageItems, $filteredLogs->count(), $perPage, $currentPage);

        return view('livewire.admin.audit-log-list', compact('logs'));
    }
}