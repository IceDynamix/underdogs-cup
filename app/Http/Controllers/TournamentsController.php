<?php

namespace App\Http\Controllers;

use App\Http\Requests\TournamentCreateRequest;
use App\Http\Requests\TournamentEditRequest;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Tournament::class, 'tournament');
    }

    public function index()
    {
        return view('tournaments.index', ['tournaments' => Tournament::all()]);
    }

    public function store(TournamentCreateRequest $request)
    {
        $validated = $request->validated();

        $tournament = Tournament::create($validated);

        return redirect()->route('tournaments.show', $tournament);
    }

    public function create()
    {
        return view('tournaments.create', [
            'action' => route('tournaments.store'),
            'method' => 'POST',
            'tournament' => new Tournament(),
        ]);
    }

    public function show(Tournament $tournament)
    {
        return view('tournaments.view', ['tournament' => $tournament]);
    }

    public function edit(Tournament $tournament)
    {
        return view('tournaments.edit', [
            'action' => route('tournaments.update', $tournament),
            'method' => 'PUT',
            'tournament' => $tournament,
        ]);
    }

    public function update(TournamentEditRequest $request, Tournament $tournament)
    {
        $validated = $request->validated();
        $tournament->update($validated);

        return redirect()->route('tournaments.show', $tournament);
    }

    public function destroy(Tournament $tournament)
    {
    }

    public function viewRegister(Tournament $tournament)
    {
        $this->authorize('viewRegister', $tournament);
    }

    public function register(Request $request, Tournament $tournament)
    {
        $this->authorize('register', $tournament);
    }
}
