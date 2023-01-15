<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlayerBlacklistEntryCreateRequest;
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
        return view('admin.blacklist.create');
    }

    public function store(PlayerBlacklistEntryCreateRequest $request)
    {
        $validated = $request->validated();

        PlayerBlacklistEntry::create([
            'tetrio_id' => $validated['tetrio_id'],
            'until' => $validated['until'],
            'admin_id' => auth()->user()->id,
            'reason' => $validated['reason']
        ]);

        return redirect()->route('admin.blacklist.index');
    }

    public
    function show(
        PlayerBlacklistEntry $playerBlacklistEntry
    ) {
    }

    public
    function edit(
        PlayerBlacklistEntry $playerBlacklistEntry
    ) {
    }

    public
    function update(
        Request $request,
        PlayerBlacklistEntry $playerBlacklistEntry
    ) {
    }

    public
    function destroy(
        PlayerBlacklistEntry $playerBlacklistEntry
    ) {
    }
}
