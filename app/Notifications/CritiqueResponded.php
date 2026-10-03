<?php

namespace App\Notifications;

use App\Models\Critique;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CritiqueResponded extends Notification
{
    use Queueable;

    public function __construct(protected Critique $critique)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'critique_responded',
            'critique_id' => $this->critique->id,
            'title' => $this->critique->title,
            'message' => 'Admin telah menanggapi kritik Anda: "'.$this->critique->title.'"',
            'url' => route('critique.show', $this->critique->id),
        ];
    }
}
