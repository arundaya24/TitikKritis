<?php

namespace App\Notifications;

use App\Models\Critique;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewCritiqueSubmitted extends Notification
{
    use Queueable;

    public function __construct(protected Critique $critique)
    {
        //
    }

    /**
     * Disimpan sebagai notifikasi database saja (muncul di lonceng notifikasi admin).
     * Tambahkan 'mail' di sini kalau nanti mau dikirim email juga.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'new_critique',
            'critique_id' => $this->critique->id,
            'title' => $this->critique->title,
            'submitter_name' => $this->critique->submitter_name,
            'category' => $this->critique->category?->name,
            'message' => $this->critique->is_anonymous
                ? 'Ada kritik baru (anonim) yang perlu ditinjau: "'.$this->critique->title.'"'
                : $this->critique->submitter_name.' mengirim kritik baru: "'.$this->critique->title.'"',
            'url' => route('admin.critiques.show', $this->critique->id),
        ];
    }
}
