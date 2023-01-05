<?php

namespace App\Console\Commands;

use App\Http\TetrioApi\TetrioApi;
use App\Models\TetrioUser;
use Illuminate\Console\Command;

class UsersUpdateCommand extends Command
{
    protected $signature = 'users:update';

    protected $description = 'Updates the tetrio stats for users';

    public function handle()
    {
        $this->info('Fetching leaderboard');
        $users = TetrioApi::getFullLeaderboardExport();
        if (empty($users)) {
            $this->error('Failed to get the leaderboard export');

            return;
        }

        $this->info('Updating users');

        foreach ($users as $user) {
            $dbUser = TetrioUser::find($user['_id']);

            // only update users that already exist
            if (! $dbUser) {
                continue;
            }

            $dbUser->fill(TetrioUser::mapTetrioUserToDbFill($user));
            $this->info("Updated user $dbUser");
        }

        $this->info('Finished updating users');
    }
}
