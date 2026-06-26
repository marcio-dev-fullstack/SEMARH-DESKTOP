<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class DailyExpirationSummary extends Notification
{
    use Queueable;

    public $expiringProcesses;

    public function __construct(Collection $expiringProcesses)
    {
        $this->expiringProcesses = $expiringProcesses;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'whatsapp'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
                    ->subject('Relatório Diário: Licenças a Vencer em 5 Dias')
                    ->greeting('Relatório Diário de Licenças a Vencer');

        foreach ($this->expiringProcesses as $processo) {
            $mail->line("---")
                 ->line('**Requerente:** ' . $processo->nome_requerente)
                 ->line('**Protocolo:** ' . $processo->protocolo)
                 ->line('**Contato:** ' . $processo->email_requerente . ' / ' . $processo->telefone_requerente);
        }

        return $mail;
    }

    public function toWhatsApp(object $notifiable): string
    {
        $message = "*Relatório Diário: Licenças a Vencer em 5 Dias*\n\n";

        foreach ($this->expiringProcesses as $processo) {
            $message .= "------------------------\n";
            $message .= "*Requerente:* {$processo->nome_requerente}\n";
            $message .= "*Protocolo:* {$processo->protocolo}\n";
        }

        return $message;
    }
}