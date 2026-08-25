<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Critique;

class CritiquePolicy
{
    public function view(User $user, Critique $critique)
    {
        return $user->id === $critique->user_id || $user->isAdmin();
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Critique $critique)
    {
        if ($user->isAdmin()) {
            return false;
        }

        return $user->id === $critique->user_id && $critique->status === 'dikirim';
    }

    public function delete(User $user, Critique $critique)
    {
        if ($user->isAdmin()) {
            return false;
        }

        return $user->id === $critique->user_id && $critique->status === 'dikirim';
    }

    public function viewAny(User $user)
    {
        return true;
    }

    public function respond(User $user, Critique $critique)
    {
        return $user->isAdmin();
    }

    public function updateStatus(User $user, Critique $critique)
    {
        return $user->isAdmin();
    }
}
