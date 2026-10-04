<?php

namespace App\Policies;

use App\Models\Critique;
use App\Models\User;

class CritiquePolicy
{
    public function view(User $user, Critique $critique)
    {
        return $user->id === $critique->user_id
            || $user->hasAnyRole(['admin', 'superadmin']);
    }

    public function create(User $user)
    {
        return $user->can('create reports');
    }

    // PERBAIKAN: pengecekan status 'dikirim' dihapus dari policy.
    // Sebelumnya archive, unarchive, forceDelete, dan deleteArchived selalu 403
    // karena memanggil authorize('update'/'delete') pada kritik berstatus selesai/ditolak.
    // Pembatasan status tetap dijaga di controller (edit, update, destroy, dan where() pada aksi lain).
    public function update(User $user, Critique $critique)
    {
        if ($user->hasAnyRole(['admin', 'superadmin'])) {
            return false;
        }

        return $user->can('update reports')
            && $user->id === $critique->user_id;
    }

    public function delete(User $user, Critique $critique)
    {
        if ($user->hasAnyRole(['admin', 'superadmin'])) {
            return false;
        }

        return $user->can('delete reports')
            && $user->id === $critique->user_id;
    }

    public function viewAny(User $user)
    {
        return $user->can('view reports');
    }

    public function respond(User $user, Critique $critique)
    {
        return $user->hasAnyRole(['admin', 'superadmin'])
            && $user->can('update reports');
    }

    public function updateStatus(User $user, Critique $critique)
    {
        return $user->hasAnyRole(['admin', 'superadmin'])
            && $user->can('update reports');
    }
}
