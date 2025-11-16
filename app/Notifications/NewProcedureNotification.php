<?php

namespace App\Notifications;

use App\Models\Procedure;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewProcedureNotification extends Notification
{
    use Queueable;

    protected $procedure;

    /**
     * Create a new notification instance.
     */
    public function __construct(Procedure $procedure)
    {
        $this->procedure = $procedure;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_procedure',
            'message' => "Une nouvelle procédure '{$this->procedure->title}' a été créée.",
            'procedure_id' => $this->procedure->id,
            'procedure_title' => $this->procedure->title,
            'created_by' => $this->procedure->creator->name,
        ];
    }
}
