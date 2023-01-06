<?php

namespace Tests\Feature;

use App\Http\Enums\TournamentStatus;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TournamentRegistrationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Tournament $closedTournament;
    private Tournament $openTournament;

    public function testRegOpen()
    {
        $this->actingAs($this->user)
            ->get(route('tournaments.register', $this->openTournament))
            ->assertOk();

        $this->actingAs($this->user)
            ->post(route('tournaments.apply', $this->openTournament))
            ->assertOk();
    }

    public function testRegClosed()
    {
        $this->actingAs($this->user)
            ->get(route('tournaments.register', $this->closedTournament))
            ->assertForbidden();

        $this->actingAs($this->user)
            ->post(route('tournaments.apply', $this->closedTournament))
            ->assertForbidden();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['is_blacklisted' => false]);
        $this->closedTournament = Tournament::factory()->create(['status' => TournamentStatus::Upcoming]);
        $this->openTournament = Tournament::factory()->create(['status' => TournamentStatus::RegOpen]);
    }
}
