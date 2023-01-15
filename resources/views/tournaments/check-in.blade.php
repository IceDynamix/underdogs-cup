<x-layout>
    <x-slot:title>Check-in | {{$tournament->name}}</x-slot:title>
    <div class="container">
        <div class="content">
            <x-tournament.card :$tournament/>
            <h1>Check-in</h1>
            @if(auth()->user()->isRegisteredAt($tournament))
                <p>
                    Status:
                    @if(auth()->user()->isCheckedInFor($tournament))
                        <span class="tag is-success">Checked-in</span>
                    @else
                        <span class="tag is-danger">Not checked-in</span>
                    @endif
                </p>
                <form action="{{route('tournaments.check-in.post', $tournament)}}" method="POST">
                    @csrf
                    @if(auth()->user()->isCheckedInFor($tournament))
                        <button class="button is-danger">Check out</button>
                    @else
                        <button class="button is-success">Check in</button>
                    @endif
                </form>
            @else
                <p>You are not registered for this tournament.</p>
            @endif
            <h1>Checked-in Player List</h1>
            <x-tournament.player-list :players="$checkInList"/>
        </div>
    </div>
</x-layout>
