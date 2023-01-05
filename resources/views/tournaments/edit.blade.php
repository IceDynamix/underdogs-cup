<x-layout>
    <x-slot:title>
        Edit tournament
    </x-slot:title>

    <section class="section">
        <div class="container">
            <div class="content">
                <h1>Edit tournament</h1>
                <x-tournament.form :$tournament :$action :$method/>
            </div>
        </div>
    </section>
</x-layout>
