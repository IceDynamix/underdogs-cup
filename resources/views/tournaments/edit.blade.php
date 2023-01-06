<x-layout>
    <x-slot:title>Edit | {{$tournament->name}}</x-slot:title>
    
    <div class="container">
        <div class="content">
            <h1>Edit tournament</h1>
            <x-tournament.form :$tournament :$action :$method/>
        </div>
    </div>
</x-layout>
