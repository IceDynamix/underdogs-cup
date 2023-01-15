<x-layout>
    <x-slot:title>Check-in | {{$tournament->name}}</x-slot:title>
    <div class="container">
        <div class="content">
            <x-tournament.card :$tournament/>
            <h1>Check-in</h1>
            <p>
                This is the check-in page. Check-in opens one hour before the tournament starts and exists to make sure
                that only people who are available at the moment can participate.
            </p>
            <p>
                Checking in is required in order to play in the tournament! If you do not check in until tournament
                start, you will not be able to participate in the tournament. All you need to do is to press the
                big green "Check in" button on the page.
            </p>
            <p>
                If you cannot participate after all, please stay checked out and do not check in.
                If you have checked in and cannot participate after all, press the big "Check out" button.
            </p>
            @if(auth()->user()->isRegisteredAt($tournament))
                <p>
                    Status:
                    @if(auth()->user()->isCheckedInFor($tournament))
                        <span class="tag is-success">Checked-in</span>
                    @else
                        <span class="tag is-danger">Not checked-in</span>
                    @endif
                </p>
                <form action="{{route('tournaments.check-in.post', $tournament)}}" method="POST"
                      @if(auth()->user()->isCheckedInFor($tournament))
                          onsubmit="return confirm('Are you sure you want to check out?')"
                    @endif
                >
                    @csrf
                    @if(auth()->user()->isCheckedInFor($tournament))
                        <button class="button is-danger">Check out (You will NOT participate in the tournament
                            anymore)
                        </button>
                    @else
                        <button class="button is-success">Check in</button>
                    @endif
                </form>
            @else
                <p class="has-text-danger">You are not registered for this tournament and thus cannot check in.</p>
            @endif
            <h1>List of checked-in players</h1>
            <x-tournament.player-list :players="$checkInList"/>
        </div>
    </div>
</x-layout>
