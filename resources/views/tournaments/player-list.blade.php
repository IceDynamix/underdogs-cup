@php use App\Models\Tournament; @endphp
<x-layout>
    <x-slot:title>Player List | {{$tournament->name}}</x-slot:title>
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
                        <th>Peak Rank</th>
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
                            <td>
                                <span class="icon-text">
                                    <span class="icon">
                                        <img src="{{$tetrio->rank->img()}}" alt="Tetrio Rank">
                                    </span>
                                    <a href="{{$tetrio->url()}}">{{$tetrio->username}}</a>
                                </span>
                            </td>
                            <td>
                                <span class="icon-text">
                                    <span class="icon">
                                        <img src="{{$tetrio->best_rank->img()}}" alt="Tetrio Rank">
                                    </span>
                                </span>
                            </td>
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
