<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class ProcessForm extends Form
{
    #[Rule('required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240')] // 10MB Max
    public $newDocument;

    #[Rule('required|min:10', as: 'Descrição do Histórico')]
    public function newHistoryEntry(): string
    {
        return $this->newHistoryEntry;
    }

    #[Rule('required|exists:users,id')]
    public $selectedAnalystId;
}