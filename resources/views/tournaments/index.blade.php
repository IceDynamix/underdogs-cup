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
                @foreach($tournaments as $tournament)
                    <x-tournament.item :$tournament/>
                @endforeach
            </div>
        </div>
    </section>
</x-layout>
