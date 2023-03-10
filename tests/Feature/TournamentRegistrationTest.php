<?php

namespace Tests\Feature;

use App\Enums\TetrioRank;
use App\Enums\TournamentStatus;
use App\Models\PlayerBlacklistEntry;
use App\Models\TetrioUser;
use App\Models\TetrioUserSnapshot;
use App\Models\Tournament;
use App\Models\TournamentRegistration;
use App\Models\User;
use App\Repositories\RegistrationRepository;
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

        $this->actingAs($user)
            ->get(route('tournaments.register', $this->tournament))
            ->assertOk();
    }

    public function testUserBlacklisted()
    {
        $blacklisted = $this->okUser()->create();
        PlayerBlacklistEntry::factory()->create(['tetrio_id' => $blacklisted->id]);

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

    public function testErrorCheckRegOk()
    {
        $tournament = $this->tournament()->create();
        $user = $this->okUser()->create();
        $this->snapshot($user->tetrio, $tournament);

        self::assertEmpty(RegistrationRepository::getRegistrationErrors($tournament, $user));
    }

    public function testErrorCheckNoSnapshot()
    {
        $tournament = $this->tournament()->create();
        $user = $this->okUser()->create();

        self::assertNotEmpty(RegistrationRepository::getRegistrationErrors($tournament, $user));
    }

    public function testErrorCheckNotInDiscord()
    {
        $tournament = $this->tournament()->create();
        $user = $this->okUser()->create(['is_in_discord' => false]);

        self::assertNotEmpty(RegistrationRepository::getRegistrationErrors($tournament, $user));
    }

    public function testErrorCheckCurrentRankLow()
    {
        $tournament = $this->tournament()->create(['lower_reg_rank_cap' => TetrioRank::S]);
        $user = $this->okUser(['rank' => TetrioRank::A])->create();
        $this->snapshot($user->tetrio, $tournament);

        self::assertNotEmpty(RegistrationRepository::getRegistrationErrors($tournament, $user));
    }

    public function testErrorCheckCurrentRankHigh()
    {
        $tournament = $this->tournament()->create(['upper_reg_rank_cap' => TetrioRank::S]);
        $user = $this->okUser(['rank' => TetrioRank::SPlus])->create();
        $this->snapshot($user->tetrio, $tournament);

        self::assertNotEmpty(RegistrationRepository::getRegistrationErrors($tournament, $user));
    }

    public function testErrorCheckRegistrationRankLow()
    {
        $tournament = $this->tournament()->create(['lower_reg_rank_cap' => TetrioRank::S]);
        $user = $this->okUser(['rank' => TetrioRank::S])->create();
        $this->snapshot($user->tetrio, $tournament, ['rank' => TetrioRank::A]);

        self::assertNotEmpty(RegistrationRepository::getRegistrationErrors($tournament, $user));
    }

    public function testErrorCheckRegistrationRankHigh()
    {
        $tournament = $this->tournament()->create(['upper_reg_rank_cap' => TetrioRank::S]);
        $user = $this->okUser(['rank' => TetrioRank::S])->create();
        $this->snapshot($user->tetrio, $tournament, ['rank' => TetrioRank::SPlus]);

        self::assertNotEmpty(RegistrationRepository::getRegistrationErrors($tournament, $user));
    }

    public function testRegOk()
    {
        $tournament = $this->tournament()->create();
        $user = $this->okUser()->create();
        $this->snapshot($user->tetrio, $tournament);

        $this->get(route('tournaments.register', $tournament))
            ->assertDontSee('Player List');

        $this->actingAs($user)
            ->post(route('tournaments.register.post', $tournament))
            ->assertRedirectToRoute('tournaments.register', $tournament);

        $this->assertModelExists(TournamentRegistration::firstWhere([
            'tetrio_user_id' => $user->tetrio->id,
            'tournament_id' => $tournament->id,
        ]));

        $this->get(route('tournaments.register', $tournament))
            ->assertSee('Player List');

        $this->get(route('tournaments.participants', $tournament))
            ->assertSee($user->tetrio->username);
    }

    public function testDoubleRegistration()
    {
        $tournament = $this->tournament()->create();
        $user = $this->okUser()->create();
        $this->snapshot($user->tetrio, $tournament);

        $this->actingAs($user)
            ->post(route('tournaments.register.post', $tournament))
            ->assertRedirectToRoute('tournaments.register', $tournament);

        $this->actingAs($user)
            ->post(route('tournaments.register.post', $tournament))
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

    private function okUser(array $tetrioAttrs = []): UserFactory
    {
        return User::factory()->state([
            'tetrio_user_id' => TetrioUser::factory()->create($tetrioAttrs)->id,
            'is_in_discord' => true,
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
