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
                        <td>{{$entry->created_at}}, {{$entry->created_at->diffForHumans()}}</td>
                        <td>
                            @if($entry->until)
                                {{$entry->until}}, {{$entry->until?->diffForHumans()}}
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
                <a class="button is-success" href="{{route('admin.blacklist.create')}}">Add</a>
            @endcan
        </div>
    </div>
</x-layout>
