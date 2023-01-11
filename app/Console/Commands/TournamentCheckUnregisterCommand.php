<?php

namespace App\Console\Commands;

use App\Jobs\TournamentCheckUnregisterJob;
use Illuminate\Console\Command;

class TournamentCheckUnregisterCommand extends Command
{
    protected $signature = 'tournament:check-unregister';

    protected $description = 'Unregisters all invalid participants';

    public function handle()
    {
        TournamentCheckUnregisterJob::dispatch();
    }
}
