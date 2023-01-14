<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlayerBlacklistEntry;
use Illuminate\Http\Request;

class PlayerBlacklistEntriesController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(PlayerBlacklistEntry::class, 'entry');
    }

    public function index()
    {
        $blacklistEntries = PlayerBlacklistEntry::orderByDesc('created_at')->get();
        return view('admin.blacklist.index', compact('blacklistEntries'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(PlayerBlacklistEntry $playerBlacklistEntry)
    {
    }

    public function edit(PlayerBlacklistEntry $playerBlacklistEntry)
    {
    }

    public function update(Request $request, PlayerBlacklistEntry $playerBlacklistEntry)
    {
    }

    public function destroy(PlayerBlacklistEntry $playerBlacklistEntry)
    {
    }
}
