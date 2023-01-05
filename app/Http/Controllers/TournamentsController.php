<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentsController extends Controller
{
    public function index()
    {
        return view('tournaments.index', ['tournaments' => Tournament::all()]);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
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
