<?php

namespace App\Livewire\Mobile;

use Livewire\Component;
use Carbon\Carbon;

class TaskList extends Component
{
    public $tasksByDate = [];

    public function mount()
    {
        // Placeholder: Em uma aplicação real, buscaria as fiscalizações
        // atribuídas ao agente logado. Ex: Auth::user()->fiscalizacoes()->...
        $tasks = collect([
            ['id' => 2, 'protocol' => 'FSC-2026-002', 'status' => 'Agendada', 'date' => today()->toDateString(), 'location' => 'Av. Industrial, 123', 'description' => 'Verificar condicionantes do Processo 202601-12345.'],
            ['id' => 3, 'protocol' => 'FSC-2026-003', 'status' => 'Agendada', 'date' => today()->addDay()->toDateString(), 'location' => 'Zona Rural, Fazenda Santa Fé', 'description' => 'Apuração de denúncia de desmatamento.'],
            ['id' => 6, 'protocol' => 'FSC-2026-006', 'status' => 'Agendada', 'date' => today()->addDays(3)->toDateString(), 'location' => 'Centro, Praça da Matriz', 'description' => 'Verificação de alvarás de funcionamento.'],
            ['id' => 1, 'protocol' => 'FSC-2026-001', 'status' => 'Realizada', 'date' => today()->subDay()->toDateString(), 'location' => 'Rua das Flores, próximo ao córrego', 'description' => 'Despejo irregular de resíduos sólidos.'],
        ]);

        $this->tasksByDate = $tasks->groupBy(function($task) {
            $date = Carbon::parse($task['date']);
            if ($date->isToday()) return 'Hoje';
            if ($date->isTomorrow()) return 'Amanhã';
            return 'Próximas Datas';
        });
    }

    public function render()
    {
        return view('livewire.mobile.task-list');
    }
}