@php use App\Models\Tournament; @endphp
<x-layout>
    <x-slot:title>Player List | {{$tournament->name}}</x-slot:title>
    <div class="container">
        <div class="content">
            <x-tournament.card :$tournament/>
            <h1>Player List</h1>
            <x-tournament.player-list :players="$tournament->participants"/>
        </div>
    </div>
</x-layout>
