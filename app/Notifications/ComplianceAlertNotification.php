<?php

namespace App\Notifications;

use App\Models\ComplianceRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ComplianceAlertNotification extends Notification
{
    use Queueable;

    protected $complianceRecord;

    /**
     * Create a new notification instance.
     */
    public function __construct(ComplianceRecord $complianceRecord)
    {
        $this->complianceRecord = $complianceRecord;
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
            'type' => 'compliance_alert',
            'message' => "Non-conformité détectée pour la procédure '{$this->complianceRecord->procedure->title}'.",
            'procedure_id' => $this->complianceRecord->procedure_id,
            'procedure_title' => $this->complianceRecord->procedure->title,
            'checked_by' => $this->complianceRecord->user->name,
            'is_compliant' => $this->complianceRecord->is_compliant,
        ];
    }
}
