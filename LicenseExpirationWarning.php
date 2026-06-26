<?php

namespace App\Notifications;

use App\Models\ProcessoLicenciamento;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LicenseExpirationWarning extends Notification
{
    use Queueable;

    public $processo;

    public function __construct(ProcessoLicenciamento $processo)
    {
        $this->processo = $processo;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'whatsapp']; // Canais de envio
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Aviso de Vencimento de Licença Ambiental')
                    ->greeting('Olá, ' . $this->processo->nome_requerente . '!')
                    ->line('Sua licença ambiental, protocolo ' . $this->processo->protocolo . ', está prestes a vencer.')
                    ->line('A data de vencimento é em 5 dias.')
                    ->action('Acessar Portal para Renovação', url('/'))
                    ->line('Por favor, inicie o processo de renovação para evitar irregularidades.');
    }

    /**
     * Get the WhatsApp representation of the notification.
     */
    public function toWhatsApp(object $notifiable): string
    {
        $message  = "*Aviso de Vencimento de Licença Ambiental*\n\n";
        $message .= "Olá, *{$this->processo->nome_requerente}*!\n";
        $message .= "Sua licença (protocolo *{$this->processo->protocolo}*) vence em 5 dias.\n";
        $message .= "Inicie o processo de renovação para evitar irregularidades.";

        return $message;
    }
}