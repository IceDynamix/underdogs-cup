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

        <a href="{{route('tournaments.register', $tournament)}}" class="button is-warning"
           @cannot('viewRegister', $tournament)
               disabled
            @endcannot
        >
            Register
        </a>

        @if($tournament->status == TournamentStatus::CheckInOpen)
            <a href="" class="button is-warning">
                Check-in
            </a>
        @endif

        @can('update', $tournament)
            <a href="{{route('tournaments.edit', $tournament)}}" class="button is-info">Edit</a>
        @endcan
    </div>
</div>
