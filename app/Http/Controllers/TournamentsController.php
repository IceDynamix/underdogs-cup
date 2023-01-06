<?php

namespace App\Http\Controllers;

use App\Enums\TetrioRank;
use App\Helper\RegistrationHelper;
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

        // FIXME

        if (array_key_exists('lower_reg_rank_cap',
                $validated) && $validated['lower_reg_rank_cap'] == TetrioRank::Unranked) {
            $validated['lower_reg_rank_cap'] = null;
        }

        if (array_key_exists('upper_reg_rank_cap',
                $validated) && $validated['upper_reg_rank_cap'] == TetrioRank::Unranked) {
            $validated['upper_reg_rank_cap'] = null;
        }

        if (array_key_exists('grace_rank_cap', $validated) && $validated['grace_rank_cap'] == TetrioRank::Unranked) {
            $validated['grace_rank_cap'] = null;
        }

        if (array_key_exists('min_games_played', $validated) && $validated['min_games_played'] == 0) {
            $validated['min_games_played'] = null;
        }

        if (array_key_exists('max_rd', $validated) && $validated['max_rd'] == 100) {
            $validated['max_rd'] = null;
        }

        $tournament->update($validated);

        return redirect()->route('tournaments.show', $tournament);
    }

    public function destroy(Tournament $tournament)
    {
    }

    public function viewRegister(Tournament $tournament)
    {
        $this->authorize('viewRegister', $tournament);

        $user = auth()->user();

        return view('tournaments.register', [
            'tournament' => $tournament,
            'tetrioUser' => $user->tetrio,
            'snapshot' => $user->tetrio?->snapshotFor($tournament),
            'errors' => RegistrationHelper::getRegistrationErrors($tournament, $user)
        ]);
    }

    public function register(Request $request, Tournament $tournament)
    {
        $this->authorize('register', $tournament);

        $user = auth()->user();
        if (RegistrationHelper::getRegistrationErrors($tournament, $user)) {
            abort(403);
        }
    }
}
