<?php

namespace Tests\Feature;

use App\Models\PlayerBlacklistEntry;
use App\Models\TetrioUser;
use Carbon\Carbon;
use Tests\TestCase;

class BlacklistTest extends TestCase
{
    public function testIsNotBlacklisted()
    {
        $this->assertFalse(TetrioUser::factory()->create()->isBlacklisted());
    }

    public function testIsBlacklistedWithEnd()
    {
        $this->assertTrue(
            TetrioUser::factory()
                ->has(PlayerBlacklistEntry::factory()->state(['until' => Carbon::now()->addHour()]),
                    'blacklistEntries')
                ->create()
                ->isBlacklisted()
        );
    }

    public function testIsBlacklistedWithNoEnd()
    {
        $this->assertTrue(
            TetrioUser::factory()
                ->has(PlayerBlacklistEntry::factory()->state(['until' => null]),
                    'blacklistEntries')
                ->create()
                ->isBlacklisted()
        );
    }

    public function testBlacklistExpired()
    {
        $this->assertFalse(
            TetrioUser::factory()
                ->has(PlayerBlacklistEntry::factory()->state(['until' => Carbon::now()->subYear()]),
                    'blacklistEntries')
                ->create()
                ->isBlacklisted()
        );
    }
}
