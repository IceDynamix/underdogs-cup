<x-layout>
    <x-slot:title>Register for {{$tournament->name}}</x-slot:title>
    <section class="section">
        <div class="container">
            <x-tournament.card :$tournament/>
            <div class="content">
                <h2>Requirements</h2>
                <ul>
                    <li><a href="{{route('connect')}}">TETR.IO account linked</a></li>
                    <li>
                        Not have placed in the top 3 of a previous Underdogs Cup before (or been blacklisted for other
                        reasons)
                    </li>
                    @if($tournament->min_games_played)
                        <li>Min. {{$tournament->min_games_played}} played ranked games at tournament announcement</li>
                    @endif
                    @if($tournament->max_rd)
                        <li>Max. {{$tournament->max_rd}} rating deviation at tournament announcement</li>
                    @endif
                    @if($tournament->lower_reg_rank_cap)
                        <li>At least {{$tournament->lower_reg_rank_cap->format()}} rank at tournament announcement</li>
                    @endif
                    @if($tournament->upper_reg_rank_cap)
                        <li>At most {{$tournament->upper_reg_rank_cap->format()}} rank at tournament announcement</li>
                    @endif
                    @if($tournament->grace_rank_cap)
                        <li>Reach at most {{$tournament->grace_rank_cap->format()}} rank until tournament start</li>
                    @endif
                </ul>
                <p>Status: <span class="tag is-danger">Not registered</span></p>
                <form action="{{route('tournaments.register.post', $tournament)}}" method="post">
                    <button type="submit"
                            class="button is-success"
                            @cannot('register', $tournament) disabled @endcannot
                    >
                        Register
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-layout>
