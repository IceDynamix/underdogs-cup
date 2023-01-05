@php use App\Http\Enums\TetrioRank;use App\Http\Enums\TournamentStatus; @endphp
<x-layout>
    <x-slot:title>
        Create new tournament
    </x-slot:title>

    <section class="section">
        <div class="container">
            <div class="content">
                <h1>Create new tournament</h1>

                <form action="{{route('tournaments.store')}}" method="POST">
                    @csrf

                    <div class="columns">
                        <div class="column">
                            <x-form.input prop="id" title="Tournament ID (must be unique)" type="text"/>
                        </div>
                        <div class="column">
                            <x-form.input prop="name" title="Tournament name" type="text"/>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <x-form.select prop="status" title="Tournament status"
                                           :items="TournamentStatus::cases()"/>

                            <x-form.input prop="bracket_url" title="Bracket URL" type="text"/>

                            <x-form.checkbox prop="hidden" title="Make tournament hidden" :value="false"/>
                        </div>
                        <div class="column">
                            <x-form.textarea prop="description" title="Tournament Description"
                                             placeholder="Tournament for lower ranked players"/>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <x-form.input prop="reg_open_ts" title="Registration open" type="datetime-local"/>
                        </div>
                        <div class="column">
                            <x-form.input prop="reg_close_ts" title="Registration close" type="datetime-local"/>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <x-form.input prop="check_in_open_ts" title="Check-in open" type="datetime-local"/>
                        </div>
                        <div class="column">
                            <x-form.input prop="check_in_close_ts" title="Check-in close" type="datetime-local"/>
                        </div>
                    </div>

                    <div class="field is-grouped">
                        <div class="control">
                            <x-form.select
                                prop="lower_reg_rank_cap"
                                title="Lower rank cap"
                                :items="TetrioRank::cases()"
                                :selected="TetrioRank::D"/>
                        </div>
                        <div class="control">
                            <x-form.select
                                prop="upper_reg_rank_cap"
                                title="Upper rank cap"
                                :items="TetrioRank::cases()"
                                :selected="TetrioRank::SS"/>
                        </div>
                        <div class="control">
                            <x-form.select
                                prop="grace_reg_rank_cap"
                                title="Grace rank cap (allowed to rank up to this during registration phase)"
                                :items="TetrioRank::cases()"
                                :selected="TetrioRank::U"/>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <x-form.input prop="min_games_played" title="Min. ranked games played" type="number"
                                          value="0"/>
                        </div>
                        <div class="column">
                            <x-form.input prop="max_rd" title="Max. RD" type="number" value="100"/>

                        </div>
                    </div>

                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="help is-danger">
                                {{ $error }}
                            </p>
                        @endforeach
                    @endif

                    <div class="field">
                        <div class="control">
                            <button type="submit" class="button is-primary">
                                Create
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layout>
