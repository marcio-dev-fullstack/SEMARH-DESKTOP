<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class InspectionDetails extends Component
{
    public $inspection;

    /**
     * Monta o componente com os dados da fiscalização.
     *
     * @param int $inspectionId
     */
    public function mount($inspectionId)
    {
        // Placeholder: Em uma aplicação real, isso buscaria do banco de dados.
        // Ex: $this->inspection = Fiscalizacao::with('agente', 'evidencias')->findOrFail($inspectionId);
        $allInspections = collect([
            ['id' => 1, 'protocol' => 'FSC-2026-001', 'origin' => 'Denúncia DEN-2026-002', 'agent' => 'Agente Fiscal 001', 'status' => 'Realizada', 'date' => '2026-06-25', 'report' => 'Visita realizada no local. Constatado despejo de resíduos sólidos no córrego. Foram coletadas amostras e fotos. O responsável não foi encontrado no momento da visita.', 'evidence' => [['type' => 'image', 'path' => 'https://via.placeholder.com/600x400.png?text=Evidência+1'], ['type' => 'image', 'path' => 'https://via.placeholder.com/600x400.png?text=Evidência+2']]],
            ['id' => 2, 'protocol' => 'FSC-2026-002', 'origin' => 'Processo 202601-12345', 'agent' => 'Agente Fiscal 002', 'status' => 'Agendada', 'date' => '2026-06-28', 'report' => 'Fiscalização agendada para verificar o cumprimento das condicionantes da licença.', 'evidence' => []],
            ['id' => 3, 'protocol' => 'FSC-2026-003', 'origin' => 'Ofício', 'agent' => 'Agente Fiscal 001', 'status' => 'Em Campo', 'date' => '2026-06-26', 'report' => 'Agente em deslocamento para o local da fiscalização.', 'evidence' => []],
            ['id' => 4, 'protocol' => 'FSC-2026-004', 'origin' => 'Denúncia DEN-2026-003', 'agent' => 'Agente Fiscal 003', 'status' => 'Concluída com Auto', 'date' => '2026-06-20', 'report' => 'Desmatamento ilegal confirmado. Foi lavrado o Auto de Infração nº 123/2026.', 'evidence' => [['type' => 'image', 'path' => 'https://via.placeholder.com/600x400.png?text=Evidência+3']]],
            ['id' => 5, 'protocol' => 'FSC-2026-005', 'origin' => 'Rotina', 'agent' => 'Agente Fiscal 002', 'status' => 'Concluída sem Auto', 'date' => '2026-06-18', 'report' => 'Visita de rotina realizada. Nenhuma irregularidade encontrada.', 'evidence' => []],
        ]);

        $this->inspection = $allInspections->firstWhere('id', (int) $inspectionId);
    }

    public function render()
    {
        return view('livewire.admin.inspection-details');
    }
}