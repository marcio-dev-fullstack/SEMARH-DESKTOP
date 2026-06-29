<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Rule;

class SystemSettingsForm extends Component
{
    #[Rule('required|string|max:255', as: 'Nome do Sistema')]
    public $system_name;

    #[Rule('boolean', as: 'Modo de Manutenção')]
    public $maintenance_mode;

    // Propriedades do Trial
    public $trial_end_date;
    public $days_remaining;
    public $generated_token;

    #[Rule('required|string|size:40', as: 'Token de Ativação')]
    public $token_to_validate = '';

    public function mount()
    {
        // Placeholder: Carrega as configurações de um arquivo de configuração ou do banco de dados.
        $this->system_name = config('app.name', 'SEMARH Fiscaliza');
        $this->maintenance_mode = false; // Em um app real: app()->isDownForMaintenance();

        $startDate = \Carbon\Carbon::parse(config('trial.start_date'));
        $this->trial_end_date = $startDate->copy()->addDays(60);
        $this->days_remaining = now()->diffInDays($this->trial_end_date, false);
    }

    public function saveSettings()
    {
        $this->validate();

        // Placeholder: Lógica para salvar as configurações.
        // Isso poderia envolver a escrita em um arquivo de configuração ou a atualização de uma tabela no banco de dados.
        // Ex:
        // if ($this->maintenance_mode) {
        //     Artisan::call('down');
        // } else {
        //     Artisan::call('up');
        // }

        session()->flash('message', 'Configurações salvas com sucesso!');
    }

    public function generateActivationToken()
    {
        // Gera um token hexadecimal seguro
        $token = Str::random(40);

        // Armazena o token no cache por 2 minutos
        Cache::put('activation_token', $token, now()->addMinutes(2));

        $this->generated_token = $token;
        session()->flash('token_message', 'Token gerado com sucesso! Válido por 2 minutos.');
    }

    /**
     * Valida o token de ativação inserido pelo usuário.
     */
    public function validateToken()
    {
        $this->validateOnly('token_to_validate');

        $cachedToken = Cache::get('activation_token');

        if ($cachedToken && hash_equals($cachedToken, $this->token_to_validate)) {
            // Placeholder: Lógica de ativação do sistema aqui.
            // Ex: Settings::update(['is_activated' => true]);

            Cache::forget('activation_token'); // Remove o token após o uso
            session()->flash('message', 'Sistema ativado com sucesso!');
            $this->reset('token_to_validate', 'generated_token');
        } else {
            $this->addError('token_to_validate', 'Token inválido ou expirado.');
        }
    }

    public function render()
    {
        return view('livewire.admin.system-settings-form');
    }
}