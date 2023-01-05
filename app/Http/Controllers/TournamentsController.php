<?php

namespace App\Http\Controllers;

use App\Http\Requests\TournamentCreateRequest;
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

        Tournament::create($validated);

        return redirect()->route('tournaments.index');
    }

    public function create()
    {
        return view('tournaments.create');
    }

    public function show(Tournament $tournament)
    {
    }

    public function edit(Tournament $tournament)
    {
    }

    public function update(Request $request, Tournament $tournament)
    {
    }

    public function destroy(Tournament $tournament)
    {
    }
}
