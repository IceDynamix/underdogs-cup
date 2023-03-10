<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlayerBlacklistEntryCreateRequest;
use App\Models\PlayerBlacklistEntry;
use App\Models\TetrioUser;
use App\Repositories\RegistrationRepository;
use Illuminate\Http\Request;

class PlayerBlacklistEntriesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PlayerBlacklistEntry::class, 'blacklist');
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

        $tetrio = TetrioUser::updateOrCreateFromId($validated['tetrio_id']);

        PlayerBlacklistEntry::create([
            'tetrio_id' => $tetrio->id,
            'until' => $validated['until'],
            'admin_id' => auth()->user()->id,
            'reason' => $validated['reason'],
        ]);

        foreach ($tetrio->registrations as $reg) {
            RegistrationRepository::unregister($reg,
                ['You have been manually removed from the tournament. If you think this is an error, please contact staff.']);
        }

        return redirect()->route('admin.blacklist.index');
    }

    public function show(PlayerBlacklistEntry $blacklist)
    {
    }

    public function edit(PlayerBlacklistEntry $blacklist)
    {
    }

    public function update(Request $request, PlayerBlacklistEntry $blacklist)
    {
    }

    public function destroy(PlayerBlacklistEntry $blacklist)
    {
        $blacklist->delete();

        return redirect()->route('admin.blacklist.index');
    }
}
