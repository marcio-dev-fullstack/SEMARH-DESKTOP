<?php

namespace App\Livewire\Admin;

use App\Models\ProcessoLicenciamento;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class ProcessList extends Component
{
    use WithPagination;

    #[Url(keep: true)]
    public $search = '';

    #[Url(keep: true)]
    public $statusFilter = '';

    /**
     * Renderiza o componente com a lista de processos paginada.
     */
    public function render()
    {
        $processes = ProcessoLicenciamento::query()
            ->when($this->search, function ($query) {
                $query->where('protocolo', 'like', '%' . $this->search . '%')
                      ->orWhere('nome_requerente', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest() // Ordena pelos mais recentes
            ->paginate(10);

        return view('livewire.admin.process-list', compact('processes'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    /**
     * Exporta os processos filtrados para um arquivo CSV.
     */
    public function exportCsv()
    {
        $filteredProcesses = ProcessoLicenciamento::query()
            ->when($this->search, function ($query) {
                $query->where('protocolo', 'like', '%' . $this->search . '%')
                      ->orWhere('nome_requerente', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })->latest()->get();

        $fileName = 'processos-' . date('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($filteredProcesses) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Protocolo', 'Requerente', 'Tipo de Licença', 'Status', 'Data da Solicitação']);

            foreach ($filteredProcesses as $process) {
                fputcsv($file, [$process->protocolo, $process->nome_requerente, $process->tipo_licenca, $process->status, $process->created_at->format('Y-m-d')]);
            }

            fclose($file);
        }, $fileName);
    }
}