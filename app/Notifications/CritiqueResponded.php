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
        $isAdmin = $notifiable->hasAnyRole(['admin', 'superadmin']);

        return [
            'type' => 'critique_responded',
            'critique_id' => $this->critique->id,
            'title' => $this->critique->title,
            'message' => $isAdmin
                ? 'User telah membalas kritik: "'.$this->critique->title.'"'
                : 'Admin telah menanggapi kritik Anda: "'.$this->critique->title.'"',
            'url' => $isAdmin
                ? route('admin.critiques.show', $this->critique->id)
                : route('critique.show', $this->critique->id),
        ];
    }
}
