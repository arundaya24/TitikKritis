<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Tandai satu notifikasi sudah dibaca lalu arahkan ke halaman terkait.
     */
    public function read(string $id): RedirectResponse
    {
        $notification = Auth::user()->notifications()->findOrFail($id);

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        $url = $notification->data['url'] ?? null;

        return $url
            ? redirect($url)
            : redirect()->back();
    }

    /**
     * Tandai semua notifikasi milik user yang login sebagai sudah dibaca.
     */
    public function readAll(): RedirectResponse
    {
        Auth::user()->unreadNotifications->markAsRead();

        return redirect()->back();
    }

    /**
     * Hapus satu notifikasi.
     */
    public function destroy(string $id): RedirectResponse
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();

        return redirect()->back();
    }

    /**
     * Hapus semua notifikasi milik user yang login.
     */
    public function destroyAll(): RedirectResponse
    {
        Auth::user()->notifications()->delete();

        return redirect()->back();
    }
}
