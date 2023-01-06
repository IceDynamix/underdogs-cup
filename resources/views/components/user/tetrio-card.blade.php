<div class="box">
    <div class="content">
        <h2>{{$username}}</h2>
        <p>{{$rank->format()}} Rank (peak: {{$bestRank->format()}})</p>
        <p>{{round($rating)}}+-{{round($rd)}}</p>
        <p>{{$pps}} PPS, {{$apm}} APM, {{$vs}} VS, {{$gamesPlayed}} games played</p>
        <p class="help">
            @if($snapshotUsed)
                Snapshot from {{$datetime->diffForHumans()}}
            @else
                Current stats
            @endif
        </p>
    </div>
</div>
