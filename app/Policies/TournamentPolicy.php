<?php

namespace App\Policies;

use App\Enums\TournamentStatus;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TournamentPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Tournament $tournament): bool
    {
        return !$tournament->is_hidden;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Tournament $tournament): bool
    {
        return false;
    }

    public function delete(User $user, Tournament $tournament): bool
    {
        return false;
    }

    public function restore(User $user, Tournament $tournament): bool
    {
        return false;
    }

    public function forceDelete(User $user, Tournament $tournament): bool
    {
        return false;
    }

    public function register(User $user, Tournament $tournament): bool
    {
        return $this->viewRegister($user, $tournament) && !$user->is_blacklisted && $user->tetrio_user_id != null;
    }

    public function viewRegister(User $user, Tournament $tournament): bool
    {
        return true;
    }

    public function unregister(User $user, Tournament $tournament): bool
    {
        return $user->isRegisteredAt($tournament) && $tournament->status == TournamentStatus::RegOpen;
    }
}
