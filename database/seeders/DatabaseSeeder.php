<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\PlayerBlacklistEntry;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Tournament::factory()->create(['id' => 'tt', 'name' => 'Test Tournament']);
        User::factory()->count(20)->create();
        PlayerBlacklistEntry::factory()->count(3)->create();
    }
}
