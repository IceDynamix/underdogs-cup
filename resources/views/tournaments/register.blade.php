<x-layout>
    {{--    <x-slot:title>Register for {{$tournament->name}}</x-slot:title>--}}
    <section class="section">
        <div class="container">
            <x-tournament.card :$tournament/>
            <div class="content">
                <div class="columns">
                    @if(auth()->user()->tetrio)
                        <div class="column">
                            <h2>User Stats</h2>
                            <x-user.tetrio-card :user="$tetrioUser"/>
                            @if($snapshot)

                                <x-user.tetrio-card :user="$tetrioUser" :use-snapshot="true" :$snapshot/>

                            @endif
                        </div>
                    @endif
                    <div class="column">
                        <h2>Requirements</h2>
                        <ul>
                            <li><a href="{{route('connect')}}">TETR.IO account linked</a></li>
                            <li>
                                Not have placed in the top 3 of a previous Underdogs Cup before (or been blacklisted for
                                other
                                reasons)
                            </li>
                            <li>Ranked at tournament announcement</li>
                            @if($tournament->min_games_played)
                                <li>Min. {{$tournament->min_games_played}} played ranked games at tournament
                                    announcement
                                </li>
                            @endif
                            @if($tournament->max_rd)
                                <li>Max. {{$tournament->max_rd}} rating deviation at tournament announcement</li>
                            @endif
                            @if($tournament->lower_reg_rank_cap)
                                <li>At least {{$tournament->lower_reg_rank_cap->format()}} rank at tournament
                                    announcement
                                </li>
                            @endif
                            @if($tournament->upper_reg_rank_cap)
                                <li>At most {{$tournament->upper_reg_rank_cap->format()}} rank at tournament
                                    announcement
                                </li>
                            @endif
                            @if($tournament->grace_rank_cap)
                                <li>Must have never been {{$tournament->grace_rank_cap->format()}} before</li>
                                <li>Reach at most {{$tournament->grace_rank_cap->format()}} rank until tournament
                                    start
                                </li>
                            @endif
                        </ul>

                        @auth
                            <p>
                                Status:
                                @if(auth()->user()->isRegisteredAt($tournament))
                                    <span class="tag is-success">Registered</span>
                                @else
                                    <span class="tag is-danger">Not registered</span>
                                @endif
                            </p>

                            @if(!auth()->user()->isRegisteredAt($tournament))
                                <form action="{{route('tournaments.register.post', $tournament)}}" method="post">
                                    @csrf
                                    <button type="submit"
                                            class="button is-success"
                                            @if(sizeof($errors) > 0) disabled @endif
                                    >
                                        Register
                                    </button>
                                </form>
                                @if(sizeof($errors) > 0)
                                    <h2>Registration Errors</h2>
                                    <ul>
                                        @foreach($errors as $error)
                                            <li class="has-text-danger">{{$error}}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            @else
                                <form action="{{route('tournaments.unregister', $tournament)}}" method="post">
                                    @csrf
                                    <button type="submit" class="button is-danger">
                                        Unregister
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
