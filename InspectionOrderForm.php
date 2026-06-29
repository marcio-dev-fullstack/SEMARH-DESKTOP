<?php

namespace App\Livewire\Admin;

use App\Models\Complaint; // Presume que você tem um Model Complaint
use App\Models\User;      // Presume que você tem um Model User

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
        // Busca a denúncia real do banco de dados
        $this->complaint = Complaint::findOrFail($complaintId);

        // Pré-preenche o formulário com dados da denúncia
        if ($this->complaint) {
            $this->relatedProtocol = $this->complaint->protocol;
            $this->objectives = "Verificar a denúncia de '{$this->complaint->description}' na localização '{$this->complaint->location}'.";
        }

        // Busca os agentes fiscais reais do banco de dados
        // Supondo que agentes tenham uma role específica ou um campo 'is_agent'
        $this->agents = User::where('role', 'Agente Fiscal')
                            ->orWhere('role', 'Agente') // Adicionando flexibilidade
                            ->get(['id', 'name']);
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