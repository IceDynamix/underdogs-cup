<?php

namespace App\Console\Commands;

use App\Jobs\UserSnapshotJob;
use App\Models\Tournament;
use Illuminate\Console\Command;

class UsersSnapshotCommand extends Command
{
    protected $signature = 'users:snapshot {tournamentId}';

    protected $description = 'Creates the stat snapshot used to compare stats against for a tournament';

    public function handle()
    {
        $tournament = Tournament::withoutGlobalScopes()->findOrFail($this->argument('tournamentId'));
        UserSnapshotJob::dispatch($tournament);
    }
}
