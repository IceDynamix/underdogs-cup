<?php

namespace App\Console\Commands;

use App\Jobs\UsersUpdateJob;
use Illuminate\Console\Command;

class UsersUpdateCommand extends Command
{
    protected $signature = 'users:update';

    protected $description = 'Updates the tetrio stats for users';

    public function handle()
    {
        UsersUpdateJob::dispatch();
    }
}
