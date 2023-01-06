<x-layout>
    <x-slot:title>
        Connecting your Discord and TETR.IO accounts
    </x-slot:title>

    <section class="section">
        <div class="container">
            <div class="content">
                <h1>Connecting your Discord and TETR.IO accounts</h1>
                <p>This is required in order to participate in Underdogs Cup tournaments!</p>

                <ol>
                    <li>Login with Discord on this website</li>
                    <li>Open up TETR.IO</li>
                    <li>Config > Account > Connections (all the way at the bottom)</li>
                    <li>Add your Discord account by clicking on "Link"</li>
                    <li><b>Make sure "Display publicly" is enabled!</b></li>
                    <li>Click the "Check for connected account" at the bottom of the page</li>
                </ol>

                @auth
                    @if(auth()->user()->tetrio_user_id == null)
                        <p>Status: <span class="tag is-danger">Not connected</span></p>
                        <form action="{{route('connect.post')}}" method="POST">
                            @csrf
                            <button type="submit" class="button is-primary">
                                Check for connected account
                            </button>
                        </form>
                    @else
                        <p>Status: <span class="tag is-success">Connected</span></p>
                        <p>Please contact IceDynamix on Discord in case you'd like to disconnect your accounts.</p>
                    @endif
                @else
                    <p>Please login with Discord in order to connect your accounts.</p>
                    <a href="{{route('login')}}" class="button is-primary">Login</a>
                @endauth

                @if($errors->any())
                    <p class="has-text-danger">{{$errors->first()}}</p>
                @endif

            </div>
            <div class="columns">
                <div class="column">
                    <figure class="image">
                        <img src="{{ Vite::asset('resources/images/connect_image_1.png') }}"
                             alt="Image showing where to link accounts">
                    </figure>
                </div>
                <div class="column">
                    <figure class="image">
                        <img src="{{ Vite::asset('resources/images/connect_image_2.png') }}"
                             alt="Image showing the 'display publicly' option">
                    </figure>
                </div>
            </div>
        </div>
    </section>
</x-layout>
