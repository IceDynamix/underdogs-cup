@php
    use App\Models\Tournament;
    $tournament = Tournament::latest()->first();
@endphp
<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="{{ route('home') }}">
            <img src="/images/uc_logo_transparent.png" alt="Underdogs Cup Logo">
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="{{ route('home') }}">Home</a>
            @if($tournament)
                <a class="navbar-item" href="{{route('tournaments.show', $tournament)}}">{{$tournament->name}}</a>
            @endif
            <a class="navbar-item" href="{{ route('procedure') }}">Match Procedure</a>
            @if(config('links.discord'))
                <a class="navbar-item" href="{{ config('links.discord') }}">Discord Server</a>
            @endif
            @if(config('links.stream'))
                <a class="navbar-item" href="{{ config('links.stream') }}">Stream</a>
            @endif
        </div>

        <div class="navbar-end">
            @auth
                <div class="navbar-item icon-text">
                    <span class="icon">
                        <img src="{{auth()->user()->avatarUrl()}}" alt="Avatar" class="is-rounded">
                    </span>

                    @if(auth()->user()->tetrio)
                        <span class="icon">
                            <img src="{{auth()->user()->tetrio->rank->img()}}" alt="Tetrio Rank">
                        </span>
                    @endif

                    <a href="{{auth()->user()->url()}}">
                        {{auth()->user()->name}}
                    </a>
                </div>

                @if(auth()->user()->tetrio_user_id == null)
                    <div class="navbar-item">
                        <a href="{{route('connect')}}" class="button is-info is-small">
                            Link with TETR.IO
                        </a>
                    </div>
                @endif
            @endauth

            <div class="navbar-item">
                @auth()
                    <form action="{{route('logout')}}" method="POST">
                        @csrf
                        <button type="submit" class="button is-primary is-small">
                            <span class="has-text-weight-bold">Logout</span>
                        </button>
                    </form>
                @else
                    <a class="button is-primary" href="{{route('login')}}">
                        Log in with Discord
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

@push('scripts')
    <script>
        $(document).ready(function () {
            $(".navbar-burger").click(function () {
                $(".navbar-burger").toggleClass("is-active");
                $(".navbar-menu").toggleClass("is-active");
            });
        });
    </script>
@endpush
