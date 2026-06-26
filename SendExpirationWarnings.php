<?php

namespace App\Console\Commands;

use App\Models\ProcessoLicenciamento;
use App\Notifications\DailyExpirationSummary;
use App\Notifications\LicenseExpirationWarning;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendExpirationWarnings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'warnings:send-license-expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia avisos para licenças que estão prestes a expirar em 5 dias.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Buscando licenças que expiram em 5 dias...');

        // Placeholder: A lógica exata dependeria de como a data de vencimento é armazenada.
        // Assumindo que a data de vencimento está em uma coluna 'data_vencimento' na tabela de licenças.
        $targetDate = now()->addDays(5)->toDateString();
        $expiringProcesses = ProcessoLicenciamento::whereDate('data_vencimento', $targetDate)->get();

        if ($expiringProcesses->isEmpty()) {
            $this->info('Nenhuma licença encontrada para a data de hoje. Nenhuma ação necessária.');
            return;
        }

        $this->info("Encontradas {$expiringProcesses->count()} licenças. Enviando notificações...");

        // 1. Envia notificação para cada comerciante
        foreach ($expiringProcesses as $processo) {
            Notification::route('mail', $processo->email_requerente)
                        ->route('whatsapp', $processo->telefone_requerente)
                        ->notify(new LicenseExpirationWarning($processo));
        }

        $this->info('Notificações individuais enviadas.');

        // 2. Envia relatório consolidado para o administrador
        Notification::route('mail', 'cda.marcio@gmail.com')
                    ->route('whatsapp', '5594992500073') // Formato internacional sem '+' ou '00'
                    ->notify(new DailyExpirationSummary($expiringProcesses));

        $this->info('Relatório consolidado enviado para o administrador.');
        $this->info('Processo concluído com sucesso!');
    }
}