<?php

namespace Tests\Feature;

use App\Enums\TetrioRank;
use App\Enums\TournamentStatus;
use App\Helper\RegistrationHelper;
use App\Models\TetrioUser;
use App\Models\TetrioUserSnapshot;
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

    public function testViewRegOpen()
    {
        $user = $this->okUser()->create();
        $tour = $this->tournament()->create(['status' => TournamentStatus::RegOpen]);

        $this->actingAs($user)
            ->get(route('tournaments.register', $tour))
            ->assertOk();

        $tour->update(['status' => TournamentStatus::RegClosed]);

        $this->actingAs($user)
            ->get(route('tournaments.register', $tour))
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

    public function testRegOk()
    {
        $tournament = $this->tournament()->create();
        $user = $this->okUser()->create();
        $this->snapshot($user->tetrio, $tournament);

        self::assertEmpty(RegistrationHelper::getRegistrationErrors($tournament, $user));
    }

    public function testNoSnapshot()
    {
        $tournament = $this->tournament()->create();
        $user = $this->okUser()->create();

        self::assertNotEmpty(RegistrationHelper::getRegistrationErrors($tournament, $user));
    }

    public function testCurrentRankLow()
    {
        $tournament = $this->tournament()->create(['lower_reg_rank_cap' => TetrioRank::S]);
        $user = $this->okUser(['rank' => TetrioRank::A])->create();
        $this->snapshot($user->tetrio, $tournament);

        self::assertNotEmpty(RegistrationHelper::getRegistrationErrors($tournament, $user));
    }

    public function testCurrentRankHigh()
    {
        $tournament = $this->tournament()->create(['upper_reg_rank_cap' => TetrioRank::S]);
        $user = $this->okUser(['rank' => TetrioRank::SPlus])->create();
        $this->snapshot($user->tetrio, $tournament);

        self::assertNotEmpty(RegistrationHelper::getRegistrationErrors($tournament, $user));
    }

    public function testRegistrationRankLow()
    {
        $tournament = $this->tournament()->create(['lower_reg_rank_cap' => TetrioRank::S]);
        $user = $this->okUser(['rank' => TetrioRank::S])->create();
        $this->snapshot($user->tetrio, $tournament, ['rank' => TetrioRank::A]);

        self::assertNotEmpty(RegistrationHelper::getRegistrationErrors($tournament, $user));
    }

    public function testRegistrationRankHigh()
    {
        $tournament = $this->tournament()->create(['upper_reg_rank_cap' => TetrioRank::S]);
        $user = $this->okUser(['rank' => TetrioRank::S])->create();
        $this->snapshot($user->tetrio, $tournament, ['rank' => TetrioRank::SPlus]);

        self::assertNotEmpty(RegistrationHelper::getRegistrationErrors($tournament, $user));
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

    private function okUser(array $tetrioAttrs = []): UserFactory
    {
        return User::factory()->state([
            'is_blacklisted' => false,
            'tetrio_user_id' => TetrioUser::factory()->create($tetrioAttrs)->id,
        ]);
    }

    private function snapshot(TetrioUser $tetrio, Tournament $tournament, array $attrs = []): TetrioUserSnapshot
    {
        $base = [
            'user_id' => $attrs->id ?? $tetrio->id,
            'tournament_id' => $tournament->id,
            'rank' => $attrs->rank ?? $tetrio->rank,
            'best_rank' => $attrs->best_rank ?? $tetrio->best_rank,
            'rating' => $attrs->rating ?? $tetrio->rating,
            'rd' => $attrs->rd ?? $tetrio->rd,
            'pps' => $attrs->pps ?? $tetrio->pps,
            'apm' => $attrs->apm ?? $tetrio->apm,
            'vs' => $attrs->vs ?? $tetrio->vs,
            'games_played' => $attrs->games_played ?? $tetrio->games_played,
        ];

        return TetrioUserSnapshot::create(array_replace($base, $attrs));
    }
}
