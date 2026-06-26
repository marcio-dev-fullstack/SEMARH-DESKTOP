<?php

namespace App\Livewire\Admin;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class InspectionList extends Component
{
    use WithPagination;

    #[Url(keep: true)]
    public $statusFilter = '';

    /**
     * Renderiza o componente com a lista de fiscalizações paginada.
     */
    public function render()
    {
        // Placeholder: Em uma aplicação real, isso viria do banco de dados.
        // Ex: $inspections = Fiscalizacao::with('agente')->latest()->paginate(15);
        $allInspections = collect([
            ['id' => 1, 'protocol' => 'FSC-2026-001', 'origin' => 'Denúncia DEN-2026-002', 'agent' => 'Agente Fiscal 001', 'status' => 'Realizada', 'date' => '2026-06-25'],
            ['id' => 2, 'protocol' => 'FSC-2026-002', 'origin' => 'Processo 202601-12345', 'agent' => 'Agente Fiscal 002', 'status' => 'Agendada', 'date' => '2026-06-28'],
            ['id' => 3, 'protocol' => 'FSC-2026-003', 'origin' => 'Ofício', 'agent' => 'Agente Fiscal 001', 'status' => 'Em Campo', 'date' => '2026-06-26'],
            ['id' => 4, 'protocol' => 'FSC-2026-004', 'origin' => 'Denúncia DEN-2026-003', 'agent' => 'Agente Fiscal 003', 'status' => 'Concluída com Auto', 'date' => '2026-06-20'],
            ['id' => 5, 'protocol' => 'FSC-2026-005', 'origin' => 'Rotina', 'agent' => 'Agente Fiscal 002', 'status' => 'Concluída sem Auto', 'date' => '2026-06-18'],
        ]);

        $filteredInspections = $allInspections->when($this->statusFilter, function ($query) {
            return $query->where('status', $this->statusFilter);
        });

        // Paginação manual da coleção de dados de exemplo.
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentPageItems = $filteredInspections->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $inspections = new LengthAwarePaginator($currentPageItems, $filteredInspections->count(), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('livewire.admin.inspection-list', compact('inspections'));
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }
}