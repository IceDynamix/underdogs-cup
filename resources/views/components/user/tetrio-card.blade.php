<div class="box">
    <div class="content">
        <div class="columns is-desktop">

            <div class="column">
                <h2>
                    <span class="icon-text">
                        <span class="icon">
                            <img src="{{$rank->img()}}" alt="Tetrio Rank">
                        </span>
                        <span>{{$username}}</span>
                    </span>
                </h2>
                <p><b>{{round($rating)}}</b> ± {{round($rd)}} TR</p>
                <p>
                    <span class="icon-text">
                        <span class="icon">
                            <img src="{{$bestRank->img()}}" alt="Tetrio Rank">
                        </span>
                        <span>peak rank</span>
                    </span>
                </p>

                <p class="help">
                    @if($snapshotUsed)
                        Snapshot from {{$datetime->diffForHumans()}}
                    @else
                        Current stats
                    @endif
                </p>
            </div>
            <div class="column">
                <p><b>{{$vs}}</b> VS</p>
                <p><b>{{$pps}}</b> PPS</p>
                <p><b>{{$apm}}</b> APM</p>
                <p><b>{{$gamesPlayed}}</b> games played</p>
            </div>
        </div>
    </div>
</div>
