<?php

namespace App\Console\Commands;

use App\Http\TetrioApi\TetrioApi;
use App\Models\TetrioUserSnapshot;
use Illuminate\Console\Command;

class UsersSnapshotCommand extends Command
{
    protected $signature = 'users:snapshot';

    protected $description = 'Creates the stat snapshot used to compare stats against';

    public function handle()
    {
        $this->info('Fetching leaderboard');
        $users = TetrioApi::getFullLeaderboardExport();
        if (empty($users)) {
            $this->error('Failed to get the leaderboard export');
            return;
        }

        $this->info('Deleting all snapshot entries');
        TetrioUserSnapshot::truncate();


        $this->info('Creating users');

        $count = 0;
        $max = sizeof($users);
        foreach ($users as $user) {
            TetrioUserSnapshot::create([
                'id' => $user['_id'],
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