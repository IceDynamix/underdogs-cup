@php use App\Models\Tournament; @endphp
<x-layout>
    <section class="hero is-info">
        <div class="hero-body">
            <div class="container">
                <p class="title">
                    Underdogs Cup
                </p>
                <p class="subtitle">
                    Long-running TETR.IO tournament series for lower ranked players
                </p>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="content">
                <h1>Tournaments</h1>

                @can('create', Tournament::class)
                    <p>
                        <a href="{{route('tournaments.create')}}" class="button is-success">
                            Create new tournament
                        </a>
                    </p>
                @endcan

                @forelse($tournaments as $tournament)
                    <x-tournament.card :$tournament/>
                @empty
                    <p>No tournaments yet...</p>
                @endforelse
            </div>
        </div>
    </section>
</x-layout>
