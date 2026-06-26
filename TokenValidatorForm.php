<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\Attributes\Rule;

class TokenValidatorForm extends Component
{
    #[Rule('required|string|size:40', as: 'Token')]
    public $token = '';

    public function validateToken()
    {
        $this->validate();

        $validToken = Cache::get('activation_token');

        if ($this->token === $validToken) {
            // Placeholder: Lógica para reativar o sistema.
            // Por exemplo, atualizar a data do trial no banco ou arquivo de config.
            // config(['trial.start_date' => now()->toDateString()]);

            Cache::forget('activation_token'); // Invalida o token após o uso

            return redirect()->route('login')->with('status', 'Sistema reativado com sucesso!');
        }

        session()->flash('error', 'Token inválido ou expirado.');
    }

    public function render()
    {
        // Renderizado inline na view 'locked.blade.php'
        return <<<'HTML'
            <div></div>
        HTML;
    }
}