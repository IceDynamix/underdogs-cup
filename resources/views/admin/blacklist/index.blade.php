<x-layout>
    <div class="container">
        <div class="content">
            <h1>Player Blacklist</h1>
            <table>
                <thead>
                <tr>
                    <th>User</th>
                    <th>Blacklisted</th>
                    <th>Expires</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($blacklistEntries as $entry)
                    <tr>
                        <td>{{$entry->user->username}}</td>
                        <td>{{$entry->created_at->diffForHumans()}}, {{$entry->created_at}}</td>
                        <td>
                            @if($entry->until)
                                {{$entry->until?->diffForHumans()}}, {{$entry->until}}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <button class="button is-danger">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>No entries in blacklist yet</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            @can('create', $entry)
                <button class="button is-success">Add</button>
            @endcan
        </div>
    </div>
</x-layout>
