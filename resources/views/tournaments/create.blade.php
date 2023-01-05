<x-layout>
    <x-slot:title>
        Create new tournament
    </x-slot:title>

    <section class="section">
        <div class="container">
            <div class="content">
                <h1>Create new tournament</h1>
                <x-tournament.form :route="route('tournaments.store')" method="POST" :tournament="null"/>
            </div>
        </div>
    </section>
</x-layout>
