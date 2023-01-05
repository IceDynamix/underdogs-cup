<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AdminRemoveCommand extends Command
{
    protected $signature = 'admin:remove {discordId}';

    protected $description = 'Remove a Discord user from admin';

    public function handle()
    {
        $user = User::findOrFail($this->argument('discordId'));
        $user->is_admin = false;
        $user->save();
        $this->info("Removed $user->name from admin");
    }
}
