<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AdminAddCommand extends Command
{
    protected $signature = 'admin:add {discordId}';

    protected $description = 'Add a Discord user as admin';

    public function handle()
    {
        $user = User::findOrFail($this->argument('discordId'));
        $user->is_admin = true;
        $user->save();
        $this->info("Added $user->name as admin");
    }
}
