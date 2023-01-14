<x-layout>
    <section class="section">
        <div class="container">
            <div class="content">
                <h1>Player Blacklist</h1>
                @forelse($blacklistEntries as $entry)
                    <p>
                        {{$entry->user->username}}
                    </p>
                @empty
                    <p>No entries in blacklist yet</p>
                @endforelse
            </div>
        </div>
    </section>
</x-layout>
