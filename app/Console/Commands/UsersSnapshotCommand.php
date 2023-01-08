<?php

namespace App\Console\Commands;

use App\Http\TetrioApi\TetrioApi;
use App\Models\TetrioUserSnapshot;
use App\Models\Tournament;
use Illuminate\Console\Command;

class UsersSnapshotCommand extends Command
{
    protected $signature = 'users:snapshot {tournamentId}';

    protected $description = 'Creates the stat snapshot used to compare stats against for a tournament';

    public function handle()
    {
        $tournament = Tournament::withoutGlobalScopes()->findOrFail($this->argument('tournamentId'));

        $this->info('Fetching leaderboard');
        $users = TetrioApi::getFullLeaderboardExport();
        if (empty($users)) {
            $this->error('Failed to get the leaderboard export');

            return;
        }

        $this->info('Deleting all snapshot entries');
        TetrioUserSnapshot::where('tournament_id', $tournament->id)->delete();

        $this->info('Creating users');

        $count = 0;
        $max = count($users);
        foreach ($users as $user) {
            TetrioUserSnapshot::create([
                'user_id' => $user['_id'],
                'tournament_id' => $tournament->id,
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
                $this->info("    $count/$max done");
            }
        }

        $this->info("Finished creating $count user snapshots");
    }
}
