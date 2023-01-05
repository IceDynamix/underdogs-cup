@php use App\Http\Enums\TetrioRank;use App\Http\Enums\TournamentStatus; @endphp
<div class="box">
    <h2>{{$tournament->name}}</h2>
    <div class="tags">
        <x-tournament.status-tag :status="$tournament->status"/>
        <span class="tag is-info">{{$tournament->rankRange()}}</span>
    </div>

    <p>{{$tournament->description}}</p>

    <div class="buttons">
        <a href="" class="button is-primary">Details</a>

        @if($tournament->status == TournamentStatus::RegOpen)
            <a href="" class="button">Register</a>
        @endif
    </div>
</div>
