<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Rule;

class InspectionOrderForm extends Component
{
    public $complaint;
    public $agents = [];

    // Campos do formulário
    #[Rule('required', as: 'Agente Fiscal')]
    public $selectedAgentId;

    #[Rule('required|date', as: 'Data da Fiscalização')]
    public $inspectionDate;

    #[Rule('required|min:20', as: 'Objetivos da Fiscalização')]
    public $objectives;

    public $relatedProtocol;

    /**
     * Monta o componente, carregando dados da denúncia e pré-preenchendo o formulário.
     */
    public function mount($complaintId)
    {
        // Placeholder: Carrega os dados da denúncia
        $allComplaints = collect([
            ['id' => 1, 'protocol' => 'DEN-2026-001', 'location' => 'Rua das Flores, próximo ao córrego', 'description' => 'Despejo irregular de resíduos no córrego, ocorrendo principalmente à noite.'],
            ['id' => 2, 'protocol' => 'DEN-2026-002', 'location' => 'Av. Brasil, esquina com a Rua 10', 'description' => 'Fumaça preta saindo da chaminé de uma pequena fábrica, com forte odor químico.'],
            ['id' => 3, 'protocol' => 'DEN-2026-003', 'location' => 'Fazenda Boa Esperança, zona rural', 'description' => 'Suspeita de desmatamento ilegal em área de preservação permanente.'],
        ]);
        $this->complaint = $allComplaints->firstWhere('id', (int) $complaintId);

        // Pré-preenche o formulário com dados da denúncia
        if ($this->complaint) {
            $this->relatedProtocol = $this->complaint['protocol'];
            $this->objectives = "Verificar a denúncia de '{$this->complaint['description']}' na localização '{$this->complaint['location']}'.";
        }

        // Placeholder: Carrega a lista de agentes fiscais
        $this->agents = collect([
            ['id' => 1, 'name' => 'Agente Fiscal 001'],
            ['id' => 2, 'name' => 'Agente Fiscal 002'],
            ['id' => 3, 'name' => 'Agente Fiscal 003'],
        ]);
    }

    /**
     * Salva a nova ordem de fiscalização.
     */
    public function submit()
    {
        $this->validate();

        // Placeholder: Lógica para salvar a Ordem de Fiscalização no banco de dados.
        // Fiscalizacao::create([...]);
        // $this->complaint->update(['status' => 'Fiscalização Agendada']);

        session()->flash('message', 'Ordem de Fiscalização gerada e atribuída com sucesso!');
        // Redireciona para a lista de denúncias após o sucesso
        return $this->redirect(route('admin.complaints.index'));
    }

    public function render()
    {
        return view('livewire.admin.inspection-order-form');
    }
}