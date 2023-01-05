@php use App\Models\Tournament; @endphp
<x-layout>
    <section class="section">
        <div class="container">
            <div class="content">
                <x-tournament.item :$tournament/>

                <x-markdown>
                    {{$tournament->full_description}}
                </x-markdown>
            </div>
        </div>
    </section>
</x-layout>
