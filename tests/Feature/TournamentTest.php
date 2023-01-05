<?php

namespace Tests\Feature;

use App\Models\Tournament;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TournamentTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private User $admin;

    public function testSeeIndex()
    {
        $tournament = Tournament::factory()->create();
        $this->get('/tournaments')
            ->assertStatus(200)
            ->assertSee($tournament->name);
    }

    public function testUserDoesntSeeCreateButton()
    {
        $this->actingAs($this->user)->get('/tournaments')
            ->assertStatus(200)
            ->assertDontSee('Create new tournament');
    }

    public function testAdminSeeCreateButton()
    {
        $this->actingAs($this->admin)
            ->get('/tournaments')
            ->assertStatus(200)
            ->assertSee('Create new tournament');
    }

    public function testUserCantAccessCreate()
    {
        $this->actingAs($this->user)
            ->get('/tournaments/create')
            ->assertStatus(403);
    }

    public function testAdminCanAccessCreate()
    {
        $this->actingAs($this->admin)
            ->get('/tournaments/create')
            ->assertStatus(200);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->admin = User::factory()->create(['is_admin' => true]);
    }
}
