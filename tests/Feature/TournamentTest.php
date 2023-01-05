<?php

namespace Tests\Feature;

use App\Http\Enums\TournamentStatus;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TournamentTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private User $admin;

    private Tournament $tournament;

    public function testSeeIndex()
    {
        $this->get('/tournaments')
            ->assertStatus(200)
            ->assertSee($this->tournament->name);
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

    public function testCreateSuccess()
    {
        $newTour = [
            'id' => 'ababa',
            'name' => 'ababa',
            'status' => TournamentStatus::Upcoming->value,
            'hidden' => false,
        ];

        $this
            ->actingAs($this->admin)
            ->post('tournaments', $newTour)
            ->assertRedirectToRoute('tournaments.index');

        $this->assertDatabaseHas('tournaments', $newTour);

        $this->actingAs($this->user)
            ->get('tournaments')
            ->assertSee($newTour['name']);
    }

    public function testCreateFailDuplicate()
    {
        $newTour = [
            'id' => $this->tournament->id,
            'name' => 'ababa',
            'status' => TournamentStatus::Upcoming->value,
            'hidden' => false,
        ];

        $this
            ->actingAs($this->admin)
            ->post('tournaments', $newTour)
            ->assertSessionHasErrors(['id']);

        $this->assertDatabaseMissing('tournaments', $newTour);
    }

    public function testCreateHidden()
    {
        $tournament = [
            'id' => 'ababa',
            'name' => 'ababa',
            'status' => TournamentStatus::Upcoming->value,
            'hidden' => true,
        ];

        $this
            ->actingAs($this->admin)
            ->post('tournaments', $tournament)
            ->assertSessionHasNoErrors()
            ->assertRedirectToRoute('tournaments.index');

        $this->actingAs($this->admin)
            ->get('tournaments')
            ->assertSee($tournament['name']);

        $this->actingAs($this->user)
            ->get('tournaments')
            ->assertDontSee($tournament['name']);
    }

    public function testUserDoesntSeeEditButton()
    {
        $this->actingAs($this->user)
            ->get('/tournaments')
            ->assertStatus(200)
            ->assertDontSee('Edit');
    }

    public function testAdminSeeEditButton()
    {
        $this->actingAs($this->admin)
            ->get('/tournaments')
            ->assertStatus(200)
            ->assertSee('Edit');
    }

    public function testUserCantAccessEdit()
    {
        $this->actingAs($this->user)
            ->get('/tournaments/'.$this->tournament->id.'/edit')
            ->assertStatus(403);
    }

    public function testAdminCanAccessEdit()
    {
        $this->actingAs($this->admin)
            ->get('/tournaments/'.$this->tournament->id.'/edit')
            ->assertStatus(200);
    }

    public function testEditSuccess()
    {
        $oldName = $this->tournament->name;
        $newName = 'newname';

        $params = ['name' => $newName];

        $this->actingAs($this->user)
            ->get('tournaments')
            ->assertDontSee($newName)
            ->assertSee($oldName);

        $this
            ->actingAs($this->admin)
            ->patch('/tournaments/'.$this->tournament->id, $params)
            ->assertSessionHasNoErrors()
            ->assertRedirectToRoute('tournaments.index');

        $this->actingAs($this->user)
            ->get('tournaments')
            ->assertSee($newName)
            ->assertDontSee($oldName);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->admin = User::factory()->create(['is_admin' => true]);

        $this->tournament = Tournament::factory()->create();
    }
}
