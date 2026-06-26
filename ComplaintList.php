<?php

namespace App\Livewire\Admin;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class ComplaintList extends Component
{
    use WithPagination;

    #[Url(keep: true)]
    public $statusFilter = '';

    /**
     * Renderiza o componente com a lista de denúncias paginada.
     */
    public function render()
    {
        // Placeholder: Em uma aplicação real, isso viria do banco de dados.
        // Ex: $complaints = Denuncia::latest()->paginate(15);
        $allComplaints = collect([
            ['id' => 1, 'protocol' => 'DEN-2026-001', 'is_anonymous' => true, 'status' => 'Recebida', 'date' => '2026-06-25', 'location' => 'Rua das Flores, próximo ao córrego'],
            ['id' => 2, 'protocol' => 'DEN-2026-002', 'is_anonymous' => false, 'status' => 'Em Verificação', 'date' => '2026-06-24', 'location' => 'Av. Brasil, esquina com a Rua 10'],
            ['id' => 3, 'protocol' => 'DEN-2026-003', 'is_anonymous' => true, 'status' => 'Aguardando Laudo', 'date' => '2026-06-22', 'location' => 'Fazenda Boa Esperança, zona rural'],
            ['id' => 4, 'protocol' => 'DEN-2026-004', 'is_anonymous' => false, 'status' => 'Concluída', 'date' => '2026-06-15', 'location' => 'Parque Industrial, Lote 14'],
            ['id' => 5, 'protocol' => 'DEN-2026-005', 'is_anonymous' => true, 'status' => 'Arquivada', 'date' => '2026-06-10', 'location' => 'Coordenadas: -16.68, -49.25'],
        ]);

        $filteredComplaints = $allComplaints->when($this->statusFilter, function ($query) {
            return $query->where('status', $this->statusFilter);
        });

        // Paginação manual da coleção de dados de exemplo.
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentPageItems = $filteredComplaints->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $complaints = new LengthAwarePaginator($currentPageItems, $filteredComplaints->count(), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('livewire.admin.complaint-list', compact('complaints'));
    }
}