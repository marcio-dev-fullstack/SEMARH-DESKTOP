<?php

namespace App\Livewire\Admin;

use App\Models\ProcessoLicenciamento;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;

class ProcessDetails extends Component
{
    use WithFileUploads;

    public ProcessoLicenciamento $process;
    public $activeTab = 'general';

    #[Rule('required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240')] // 10MB Max
    public $newDocument;
    public $documentMessage = '';

    #[Rule('required|min:10', as: 'Descrição do Histórico')]
    public $newHistoryEntry = '';

    public $historyMessage = '';

    public $analysts = [];
    public $selectedAnalystId;

    /**
     * Monta o componente com os dados do processo.
     *
     * @param int $processId
     */
    public function mount($processId)
    {
        // Busca os analistas do banco de dados.
        $this->analysts = User::where('role', 'Analista')->get();

        // Busca o processo do banco de dados, já carregando as relações.
        $this->process = ProcessoLicenciamento::with('analista', 'documentos', 'historico.user')->findOrFail($processId);

        // Define o analista atualmente selecionado no dropdown
        $this->selectedAnalystId = $this->process->analista_id;
    }

    public function setTab(string $tabName)
    {
        $this->activeTab = $tabName;
    }

    /**
     * Atribui o analista selecionado ao processo.
     */
    public function assignAnalyst()
    {
        $this->validate([
            'selectedAnalystId' => 'required|exists:users,id', // Em um cenário real, validaria na tabela de usuários
        ]);
        
        // Atualiza o processo com o ID do analista e salva.
        // O trait Auditable registrará esta alteração automaticamente.
        $this->process->analista_id = $this->selectedAnalystId;
        $this->process->save();
        
        session()->flash('message', 'Analista atribuído com sucesso!');
    }

    /**
     * Adiciona um novo registro ao histórico do processo.
     */
    public function addHistoryEntry()
    {
        $this->validateOnly('newHistoryEntry');

        // Cria um registro de auditoria manual (comentário)
        $this->process->historico()->create([
            'user_id' => Auth::id(),
            'action' => 'comment',
            'new_values' => ['comment' => $this->newHistoryEntry],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        
        $this->process->refresh(); // Recarrega o processo para exibir o novo histórico
        $this->reset('newHistoryEntry');
        $this->historyMessage = 'Registro de histórico adicionado com sucesso!';
    }

    /**
     * Realiza o upload de um novo documento para o processo.
     */
    public function uploadDocument()
    {
        $this->validateOnly('newDocument');

        $path = $this->newDocument->store('processos/' . $this->process->id . '/documentos', 'public');

        // Cria o registro do documento no banco de dados, associado a este processo.
        $this->process->documentos()->create([
            'name' => $this->newDocument->getClientOriginalName(),
            'path' => $path,
            'user_id' => Auth::id(),
        ]);

        $this->process->refresh(); // Recarrega o processo para exibir o novo documento
        $this->reset('newDocument');
        $this->documentMessage = 'Documento enviado com sucesso!';
    }

    public function render()
    {
        return view('livewire.admin.process-details');
    }
}