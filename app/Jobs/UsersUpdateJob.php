<?php

namespace App\Jobs;

use App\Http\TetrioApi\TetrioApi;
use App\Models\TetrioUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UsersUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function handle()
    {
        info('Fetching leaderboard');
        $users = TetrioApi::getFullLeaderboardExport();
        if (empty($users)) {
            error_log('Failed to get the leaderboard export');

            return;
        }

        info('Updating users');

        foreach ($users as $user) {
            $dbUser = TetrioUser::find($user['_id']);

            // only update users that already exist
            if (!$dbUser) {
                continue;
            }

            $dbUser->update(TetrioUser::mapTetrioUserToDbFill($user));

            info("Updated user $dbUser");
        }

        info('Finished updating users');
    }
}
