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
            <a class="navbar-item">Underdogs Cup 17</a>
            <a class="navbar-item" href="{{ route('procedure') }}">Match Procedure</a>
            <a class="navbar-item">Discord Server</a>
            <a class="navbar-item">Stream</a>
        </div>

        <div class="navbar-end">
            @auth
                <div class="navbar-item">
                    <figure class="image is48x48 p-2">
                        <img src="{{auth()->user()->avatarUrl()}}" alt="Avatar" class="is-rounded">
                    </figure>
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
