<?php

namespace App\Jobs;

use App\Http\TetrioApi\TetrioApi;
use App\Models\TetrioUserSnapshot;
use App\Models\Tournament;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserSnapshotJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Tournament $tournament;

    public function __construct(Tournament $tournament)
    {
        $this->tournament = $tournament;
    }

    public function handle()
    {
        info('Fetching leaderboard');
        $users = TetrioApi::getFullLeaderboardExport();
        if (empty($users)) {
            error_log('Failed to get the leaderboard export');

            return;
        }

        info('Deleting all snapshot entries');
        TetrioUserSnapshot::where('tournament_id', $this->tournament->id)->delete();

        info('Creating users');

        $count = 0;
        $max = count($users);
        foreach ($users as $user) {
            TetrioUserSnapshot::create([
                'user_id' => $user['_id'],
                'tournament_id' => $this->tournament->id,
                'rank' => $user['league']['rank'],
                'best_rank' => $user['league']['bestrank'],
                'rating' => $user['league']['rating'],
                'rd' => $user['league']['rd'],
                'pps' => $user['league']['pps'],
                'apm' => $user['league']['apm'],
                'vs' => $user['league']['vs'],
                'games_played' => $user['league']['gamesplayed'],
            ]);

            $count++;
            if ($count % 250 == 0) {
                info("    $count/$max done");
            }
        }

        info("Finished creating $count user snapshots");
    }
}
