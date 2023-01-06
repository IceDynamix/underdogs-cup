<x-layout>
    <x-slot:title>
        Create tournament
    </x-slot:title>
    
    <div class="container">
        <div class="content">
            <h1>Create new tournament</h1>
            <x-tournament.form :$action :$method :$tournament/>
        </div>
    </div>
</x-layout>
