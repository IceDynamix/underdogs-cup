@php use App\Models\Tournament; @endphp
<x-layout>
    <div class="container">
        <div class="content">
            <x-tournament.card :$tournament/>
            <h1>Player List</h1>
            @forelse($tournament->participants as $tetrio)
                <p>
                    {{$tetrio->username}}
                </p>
            @empty
                <p>No registrations so far...</p>
            @endforelse
        </div>
    </div>
</x-layout>
