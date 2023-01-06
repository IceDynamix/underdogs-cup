<?php

namespace App\View\Components\User;

use App\Enums\TetrioRank;
use App\Models\TetrioUser;
use App\Models\TetrioUserSnapshot;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TetrioCard extends Component
{
    public bool $snapshotUsed;

    public TetrioUser $user;

    public string $username;

    public string $avatar;
    public string $country;

    public TetrioRank $rank;

    public TetrioRank $bestRank;

    public float $rating;

    public float $rd;

    public float $apm;

    public float $pps;

    public float $vs;

    public int $gamesPlayed;

    public Carbon $datetime;

    public function __construct(TetrioUser $user, bool $useSnapshot = false, TetrioUserSnapshot $snapshot = null)
    {
        $this->user = $user;
        $this->username = $user->username;
        $this->country = $user->country;
        $this->avatar = $user->avatarUrl();

        if ($useSnapshot) {
            $stats = $snapshot;
        } else {
            $stats = $user;
        }

        $this->snapshotUsed = $useSnapshot;

        $this->rank = $stats->rank;
        $this->bestRank = $stats->best_rank;
        $this->rating = $stats->rating;
        $this->rd = $stats->rd;
        $this->apm = $stats->apm;
        $this->pps = $stats->pps;
        $this->vs = $stats->vs;
        $this->gamesPlayed = $stats->games_played;
        $this->datetime = $stats->updated_at;
    }

    public function render(): View
    {
        return view('components.user.tetrio-card');
    }
}
