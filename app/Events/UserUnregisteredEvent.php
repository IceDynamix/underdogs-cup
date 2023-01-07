<?php

namespace App\Events;

use App\Models\Tournament;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class UserUnregisteredEvent
{
    use Dispatchable;

    public User $user;
    public Tournament $tournament;

    public function __construct(User $user, Tournament $tournament)
    {
        $this->user = $user;
        $this->tournament = $tournament;
    }
}
