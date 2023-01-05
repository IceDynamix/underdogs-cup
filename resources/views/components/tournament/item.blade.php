@php use App\Http\Enums\TetrioRank;use App\Http\Enums\TournamentStatus; @endphp
<div class="box">
    <h2>{{$tournament->name}}</h2>
    <div class="tags">
        <span class="tag {{$tournament->status->cssClass()}}">{{$tournament->status->proper()}}</span>
        <span class="tag is-info">{{$tournament->rankRange()}}</span>
    </div>

    <p>{{$tournament->description}}</p>

    <div class="buttons">
        <a href="{{route('tournaments.show', $tournament)}}" class="button is-primary">Details</a>

        @if($tournament->status == TournamentStatus::RegOpen)
            <a href="" class="button is-primary">Register</a>
        @endif

        @if($tournament->status == TournamentStatus::CheckInOpen)
            <a href="" class="button is-primary">Check-in</a>
        @endif

        @can('update', $tournament)
            <a href="{{route('tournaments.edit', $tournament)}}" class="button is-info">Edit</a>
        @endcan
    </div>
</div>
