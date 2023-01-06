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
                        <th><abbr title="Versus Score (over the last 10 games), seeding value">VS</abbr></th>
                        <th class="is-hidden-mobile"><abbr title="Tetra League Rating">TR</abbr></th>
                        <th class="is-hidden-touch"><abbr title="Pieces Per Second (over the last 10 games)">PPS</abbr>
                        </th>
                        <th class="is-hidden-touch"><abbr title="Attack Per Minute (over the last 10 games)">APM</abbr>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tournament->participants as $tetrio)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="{{$tetrio->url()}}">{{$tetrio->username}}</a></td>
                            <td>{{$tetrio->rank->format()}} ({{$tetrio->best_rank->format()}})</td>
                            <td>{{$tetrio->vs}}</td>
                            <td class="is-hidden-mobile">{{$tetrio->rating}}</td>
                            <td class="is-hidden-touch">{{$tetrio->pps}}</td>
                            <td class="is-hidden-touch">{{$tetrio->apm}}</td>
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
