<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Rule;

class LicenseApplicationForm extends Component
{
    // Informações do Requerente
    #[Rule('required|min:3', as: 'Nome Completo')]
    public $requesterName = '';

    #[Rule('required', as: 'CPF/CNPJ')]
    public $requesterDocument = '';

    #[Rule('required|email', as: 'E-mail')]
    public $requesterEmail = '';

    #[Rule('required', as: 'Telefone')]
    public $requesterPhone = '';

    // Informações do Empreendimento
    #[Rule('required', as: 'Tipo de Licença')]
    public $licenseType = '';

    #[Rule('required|min:20', as: 'Descrição do Empreendimento/Atividade')]
    public $activityDescription = '';

    #[Rule('required|accepted', as: 'Termos de Responsabilidade')]
    public $termsAccepted = false;

    /**
     * Processa o envio do formulário de solicitação.
     */
    public function submit()
    {
        // Valida os dados do formulário com base nas regras definidas.
        $this->validate();

        // Placeholder: Lógica para salvar os dados no banco de dados.
        // Ex:
        // ProcessoLicenciamento::create([
        //     'nome_requerente' => $this->requesterName,
        //     'documento' => $this->requesterDocument,
        //     'email' => $this->requesterEmail,
        //     'telefone' => $this->requesterPhone,
        //     'tipo_licenca' => $this->licenseType,
        //     'descricao_atividade' => $this->activityDescription,
        //     'status' => 'protocolado',
        // ]);

        // Exibe uma mensagem de sucesso e reseta o formulário.
        session()->flash('message', 'Solicitação de licença enviada com sucesso!');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.license-application-form');
    }
}