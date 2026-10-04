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

    public function update(User $user, Critique $critique)
    {
        if ($user->hasAnyRole(['admin', 'superadmin'])) {
            return false;
        }

        return $user->can('update reports')
            && $user->id === $critique->user_id
            && $critique->status === 'dikirim';
    }

    public function delete(User $user, Critique $critique)
    {
        if ($user->hasAnyRole(['admin', 'superadmin'])) {
            return false;
        }

        return $user->can('delete reports')
            && $user->id === $critique->user_id
            && $critique->status === 'dikirim';
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
