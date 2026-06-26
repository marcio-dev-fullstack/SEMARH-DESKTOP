<?php

namespace App\Livewire;

use Livewire\Component;

class ProcessSearch extends Component
{
    public $protocolNumber = '';
    public $process = null;
    public $searched = false;

    protected $rules = [
        'protocolNumber' => 'required|string|min:5',
    ];

    protected $messages = [
        'protocolNumber.required' => 'O campo número de protocolo é obrigatório.',
        'protocolNumber.min' => 'O número de protocolo deve ter no mínimo 5 caracteres.',
    ];

    /**
     * Realiza a busca do processo.
     */
    public function search()
    {
        $this->validate();
        $this->searched = true;
        $this->process = null; // Reseta em cada busca

        // --- Lógica de Busca (Placeholder) ---
        // No futuro, isso buscará no banco de dados.
        // Ex: $this->process = ProcessoLicenciamento::where('protocolo', $this->protocolNumber)->first();

        if ($this->protocolNumber === '202601-12345') {
            $this->process = [
                'protocol' => '202601-12345',
                'requester' => 'Empresa Exemplo LTDA',
                'type' => 'Licença de Operação (LO)',
                'status' => 'Em Análise Técnica',
                'last_update' => '2026-06-25',
            ];
        }
    }

    public function render()
    {
        return view('livewire.process-search');
    }
}