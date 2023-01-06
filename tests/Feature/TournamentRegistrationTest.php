<?php

namespace Tests\Feature;

use App\Http\Enums\TournamentStatus;
use App\Models\TetrioUser;
use App\Models\Tournament;
use App\Models\User;
use Database\Factories\TournamentFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TournamentRegistrationTest extends TestCase
{
    use RefreshDatabase;

    private Tournament $tournament;

    public function testRegOpen()
    {
        $user = $this->okUser()->create();
        $tour = $this->tournament()->create(['status' => TournamentStatus::RegOpen]);

        $this->get(route('tournaments.register', $tour))
            ->assertRedirectToRoute('login');

        $this->actingAs($user)
            ->post(route('tournaments.register.post', $tour))
            ->assertOk();

        $tour->update(['status' => TournamentStatus::RegClosed]);

        $this->get(route('tournaments.register', $tour))
            ->assertForbidden();

        $this->actingAs($user)
            ->post(route('tournaments.register.post', $tour))
            ->assertForbidden();
    }

    public function testUserBlacklisted()
    {
        $blacklisted = $this->okUser()->create(['is_blacklisted' => true]);

        $this->actingAs($blacklisted)
            ->get(route('tournaments.register', $this->tournament))
            ->assertOk();

        $this->actingAs($blacklisted)
            ->post(route('tournaments.register.post', $this->tournament))
            ->assertForbidden();
    }

    public function testUserUnlinked()
    {
        $unlinked = $this->okUser()->create(['tetrio_user_id' => null]);

        $this->actingAs($unlinked)
            ->get(route('tournaments.register', $this->tournament))
            ->assertOk();

        $this->actingAs($unlinked)
            ->post(route('tournaments.register.post', $this->tournament))
            ->assertForbidden();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->tournament = $this->tournament()->create();
    }

    private function tournament(): TournamentFactory
    {
        return Tournament::factory()->state(['status' => TournamentStatus::RegOpen]);
    }

    private function okUser(): UserFactory
    {
        return User::factory()->state([
            'is_blacklisted' => false,
            'tetrio_user_id' => TetrioUser::factory()->create()->id,
        ]);
    }
}
