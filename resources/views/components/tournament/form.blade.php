@php use App\Http\Enums\EnumHelper;use App\Http\Enums\TetrioRank;use App\Http\Enums\TournamentStatus; @endphp

<form action="{{$route}}" method="POST">
    @csrf
    @method($method)

    <div class="columns">
        <div class="column">
            {{LaraForm::text('id','Tournament ID (must be unique)', old('id', $tournament?->id))}}
        </div>
        <div class="column">
            {{LaraForm::text('name','Tournament name', old('name', $tournament?->name))}}
        </div>
    </div>

    <div class="columns">
        <div class="column">
            {{LaraForm::select('status','Tournament status', EnumHelper::enumToArray(TournamentStatus::cases()), old('status', $tournament?->status))}}
            {{LaraForm::text('bracket_url','Bracket URL', old('bracket_url', $tournament?->bracket_url))}}
            {{LaraForm::checkbox('hidden','Make tournament hidden', old('hidden', $tournament?->hidden))}}
        </div>
        <div class="column">
            {{LaraForm::textarea('description','Short tournament description', old('description', $tournament?->description),
            ['placeholder' => 'Tournament for lower ranked players'])}}
        </div>
    </div>

    <div class="columns">
        <div class="column">
            {{LaraForm::datetimeLocal('reg_open_ts','Registration open', old('reg_open_ts', $tournament?->reg_open_ts))}}
        </div>
        <div class="column">
            {{LaraForm::datetimeLocal('reg_close_ts','Registration close', old('reg_close_ts', $tournament?->reg_close_ts))}}
        </div>
    </div>

    <div class="columns">
        <div class="column">
            {{LaraForm::datetimeLocal('check_in_open_ts','Check-in open', old('check_in_open_ts', $tournament?->check_in_open_ts))}}
        </div>
        <div class="column">
            {{LaraForm::datetimeLocal('check_in_close_ts','Check-in close', old('check_in_close_ts', $tournament?->check_in_close_ts))}}
        </div>
    </div>

    <div class="field is-grouped">
        <div class="control">
            {{LaraForm::select('lower_reg_rank_cap','Lower rank cap',
            EnumHelper::enumToArray(TetrioRank::cases()),
            old('lower_reg_rank_cap', $tournament?->lower_reg_rank_cap), ['placeholder' => TetrioRank::D->name])}}

        </div>
        <div class="control">
            {{LaraForm::select('upper_reg_rank_cap','Upper rank cap',
            EnumHelper::enumToArray(TetrioRank::cases()),
            old('upper_reg_rank_cap', $tournament?->upper_reg_rank_cap), ['placeholder' => TetrioRank::SS->name])}}
        </div>
        <div class="control">
            {{LaraForm::select('grace_rank_cap','Grace rank cap (players allowed to rank up to this rank during registration phase)',
            EnumHelper::enumToArray(TetrioRank::cases()),
            old('grace_rank_cap', $tournament?->grace_rank_cap), ['placeholder' => TetrioRank::U->name])}}
        </div>
    </div>

    <div class="columns">
        <div class="column">
            {{LaraForm::number('min_games_played','Min. req. ranked games played',
            old('min_games_played', $tournament?->min_games_played ?? 0))}}
        </div>
        <div class="column">
            {{LaraForm::number('max_rd','Min. req. ranked games played',
            old('max_rd', $tournament?->max_rd ?? 100))}}
        </div>
    </div>

    {{LaraForm::textarea('full_description','Full tournament description', old('full_description', $tournament?->full_description),
            ['placeholder' => 'Markdown formatted thing'])}}

    <div class="field">
        <div class="control">
            <button type="submit" class="button is-primary">
                Save
            </button>
        </div>
    </div>
</form>
