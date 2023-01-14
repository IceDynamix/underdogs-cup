<?php

namespace App\Policies;

use App\Models\PlayerBlacklistEntry;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlayerBlacklistEntriesPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->is_admin;
    }

    public function view(User $user, PlayerBlacklistEntry $playerBlacklistEntry): bool
    {
        return $user->is_admin;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, PlayerBlacklistEntry $playerBlacklistEntry): bool
    {
        return false;
    }

    public function delete(User $user, PlayerBlacklistEntry $playerBlacklistEntry): bool
    {
        return false;
    }

    public function restore(User $user, PlayerBlacklistEntry $playerBlacklistEntry): bool
    {
        return false;
    }

    public function forceDelete(User $user, PlayerBlacklistEntry $playerBlacklistEntry): bool
    {
        return false;
    }
}
