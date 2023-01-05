<?php

namespace App\Policies;

use App\Models\Tournament;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TournamentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Tournament $tournament): bool
    {
        return !$tournament->hidden || $user->is_admin;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Tournament $tournament): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Tournament $tournament): bool
    {
        return $user->is_admin;
    }

    public function restore(User $user, Tournament $tournament): bool
    {
        return $user->is_admin;
    }

    public function forceDelete(User $user, Tournament $tournament): bool
    {
        return $user->is_admin;
    }
}
