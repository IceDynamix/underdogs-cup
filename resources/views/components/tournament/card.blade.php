@php use App\Enums\TournamentStatus; @endphp
<div class="box">
    <h2>{{$tournament->name}}</h2>
    <div class="tags">
        <span class="tag {{$tournament->status->cssClass()}}">{{$tournament->status->proper()}}</span>
        <span class="tag is-info">{{$tournament->rankRange()}}</span>
        @if($tournament->is_hidden)
            <span class="tag is-warning">Hidden</span>
        @endif
        @if($tournament->participants->count() > 0)
            <span class="tag is-gray">
                {{$tournament->participants->count()}}
                {{Str::plural('participant', $tournament->participants->count())}}
            </span>
        @endif
    </div>

    <p>{{$tournament->description}}</p>

    <div class="buttons">
        <a href="{{route('tournaments.show', $tournament)}}" class="button is-primary">Details</a>

        @if($tournament->status == TournamentStatus::CheckInOpen)
            <a href="" class="button is-warning">
                Check-in
            </a>
        @else
            <a href="{{route('tournaments.register', $tournament)}}" class="button is-warning">
                Register
            </a>
        @endif

        @if($tournament->participants->count() > 0)
            <a href="{{route('tournaments.participants', $tournament)}}" class="button is-info">
                Player List
            </a>
        @endif

        @can('update', $tournament)
            <a href="{{route('tournaments.edit', $tournament)}}" class="button is-info">Edit</a>
        @endcan
    </div>
</div>
