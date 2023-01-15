<?php

namespace App\Http\Controllers;

use App\Enums\TetrioRank;
use App\Enums\TournamentStatus;
use App\Events\UserRegisteredEvent;
use App\Helper\RegistrationHelper;
use App\Http\Requests\TournamentCreateRequest;
use App\Http\Requests\TournamentEditRequest;
use App\Models\Tournament;
use App\Models\TournamentRegistration;
use Carbon\Carbon;
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

        $tournament->name = $validated['name'];
        $tournament->bracket_url = $validated['bracket_url'] ?? '';
        $tournament->status = $validated['status'] ?? TournamentStatus::Upcoming;
        $tournament->is_hidden = $validated['is_hidden'] ?? false;
        $tournament->description = $validated['description'] ?? '';
        $tournament->reg_open_ts = Carbon::parse($validated['reg_open_ts'] ?? null);
        $tournament->reg_close_ts = Carbon::parse($validated['reg_close_ts'] ?? null);
        $tournament->check_in_open_ts = Carbon::parse($validated['check_in_open_ts'] ?? null);
        $tournament->check_in_close_ts = Carbon::parse($validated['check_in_close_ts'] ?? null);
        $tournament->tournament_start_ts = Carbon::parse($validated['tournament_start_ts'] ?? null);
        $tournament->lower_reg_rank_cap = $this->ifThenNull($validated['lower_reg_rank_cap'] ?? null, TetrioRank::D);
        $tournament->upper_reg_rank_cap = $this->ifThenNull($validated['upper_reg_rank_cap'] ?? null, TetrioRank::X);
        $tournament->grace_rank_cap = $this->ifThenNull($validated['grace_rank_cap'] ?? null, TetrioRank::X);
        $tournament->min_games_played = $this->ifThenNull($validated['min_games_played'] ?? null, 0);
        $tournament->max_rd = $this->ifThenNull($validated['max_rd'] ?? null, 100);
        $tournament->full_description = $validated['full_description'] ?? '';

        $tournament->save();

        return redirect()->route('tournaments.show', $tournament);
    }

    public function destroy(Tournament $tournament)
    {
    }

    public function viewRegister(Tournament $tournament)
    {
        $this->authorize('viewRegister', $tournament);

        $user = auth()->user();
        $user->updateIsInDiscord();

        return view('tournaments.register', [
            'tournament' => $tournament,
            'tetrioUser' => $user->tetrio,
            'snapshot' => $user->tetrio?->snapshotFor($tournament),
            'errors' => RegistrationHelper::getRegistrationErrors($tournament, $user),
        ]);
    }

    public function register(Request $request, Tournament $tournament)
    {
        $this->authorize('register', $tournament);

        $user = auth()->user();
        if (RegistrationHelper::getRegistrationErrors($tournament, $user)) {
            abort(403);
        }

        TournamentRegistration::create([
            'tetrio_user_id' => $user->tetrio->id,
            'tournament_id' => $tournament->id,
        ]);

        UserRegisteredEvent::dispatch($user, $tournament);

        return redirect()->route('tournaments.register', $tournament);
    }

    public function unregister(Request $request, Tournament $tournament)
    {
        $this->authorize('unregister', $tournament);

        $reg = auth()->user()
            ->tetrio
            ->registrations
            ->where('tournament_id', $tournament->id)
            ->first();

        RegistrationHelper::unregister($reg);

        return redirect()->route('tournaments.register', $tournament);
    }

    public function participants(Tournament $tournament)
    {
        return view('tournaments.player-list', [
            'tournament' => $tournament->load([
                'participants' => function ($query) {
                    $query->orderBy('vs', 'desc');
                },
            ]),
        ]);
    }

    private function ifThenNull($val, $if)
    {
        return $val == $if ? null : $val;
    }
}
