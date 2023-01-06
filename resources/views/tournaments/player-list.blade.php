@php use App\Models\Tournament; @endphp
<x-layout>
    <div class="container">
        <div class="content">
            <x-tournament.card :$tournament/>
            <h1>Player List</h1>
            @if($tournament->participants->count() > 0)
                <table class="table">
                    <thead>
                    <tr>
                        <th>Seed</th>
                        <th>Player</th>
                        <th>Rank (Peak)</th>
                        <th><abbr title="Tetra League Rating">TR</abbr></th>
                        <th><abbr title="Versus Score (over the last 10 games)">VS</abbr></th>
                        <th><abbr title="Pieces Per Second (over the last 10 games)">PPS</abbr></th>
                        <th><abbr title="Attack Per Minute (over the last 10 games)">APM</abbr></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tournament->participants as $tetrio)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="{{$tetrio->url()}}">{{$tetrio->username}}</a></td>
                            <td>{{$tetrio->rank->format()}} ({{$tetrio->best_rank->format()}})</td>
                            <td>{{$tetrio->rating}}</td>
                            <td>{{$tetrio->vs}}</td>
                            <td>{{$tetrio->pps}}</td>
                            <td>{{$tetrio->apm}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>No registrations so far...</p>
            @endif
        </div>
    </div>
</x-layout>
