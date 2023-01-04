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
                <span class="navbar-item">Logged in as {{auth()->user()->name}}</span>
            @endauth
            <div class="navbar-item">
                <div class="buttons">
                    @auth()
                        <form action="{{route('logout')}}" method="POST">
                            @csrf
                            <button type="submit" class="button is-primary">
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
