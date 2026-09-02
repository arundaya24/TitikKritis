<?php

namespace App\Notifications;

use App\Models\Critique;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CritiqueStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(
        protected Critique $critique,
        protected string $oldStatus,
        protected string $newStatus
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'critique_status_updated',

            'critique_id' => $this->critique->id,

            'title' => $this->critique->title,

            'message' =>
                'Status laporan "' .
                $this->critique->title .
                '" telah diubah dari "' .
                ucfirst($this->oldStatus) .
                '" menjadi "' .
                ucfirst($this->newStatus) .
                '".',

            'url' => route(
                'critique.show',
                $this->critique->id
            ),
        ];
    }
}
