@php use App\Models\PlayerBlacklistEntry; @endphp
<x-layout>
    <div class="container">
        <div class="content">
            <h1>Player Blacklist</h1>
            <table>
                <thead>
                <tr>
                    <th>User</th>
                    <th>Active</th>
                    <th>Blacklisted at</th>
                    <th>Expires</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($blacklistEntries as $entry)
                    <tr>
                        <td>{{$entry->user->username}}</td>
                        <td>
                            @if($entry->isActive())
                                <span class="tag is-success">Active</span>
                            @else
                                <span class="tag is-danger">Inactive</span>
                            @endif
                        </td>
                        <td>{{$entry->created_at}}, {{$entry->created_at->diffForHumans()}}</td>
                        <td>
                            @if($entry->until)
                                {{$entry->until}}, {{$entry->until?->diffForHumans()}}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @can('delete', $entry)
                                <form action="{{route('admin.blacklist.destroy', $entry)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="button is-danger is-small" type="submit">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>No entries in blacklist yet</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            @can('create', PlayerBlacklistEntry::class)
                <a class="button is-success" href="{{route('admin.blacklist.create')}}">Add</a>
            @endcan
        </div>
    </div>
</x-layout>
