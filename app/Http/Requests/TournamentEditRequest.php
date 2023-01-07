<?php

namespace App\Http\Requests;

use App\Enums\TetrioRank;
use App\Enums\TournamentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TournamentEditRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'string|nullable',
            'bracket_url' => 'string|nullable',
            'status' => [new Enum(TournamentStatus::class)],
            'is_hidden' => 'boolean',
            'description' => 'string|nullable',
            'reg_open_ts' => 'date|nullable',
            'reg_close_ts' => 'date|nullable',
            'check_in_open_ts' => 'date|nullable',
            'check_in_close_ts' => 'date|nullable',
            'tournament_start_ts' => 'date|nullable',
            'lower_reg_rank_cap' => ['nullable', new Enum(TetrioRank::class)],
            'upper_reg_rank_cap' => ['nullable', new Enum(TetrioRank::class)],
            'grace_rank_cap' => ['nullable', new Enum(TetrioRank::class)],
            'min_games_played' => 'nullable|integer|min:0',
            'max_rd' => 'nullable|integer|min:50|max:300',
            'full_description' => 'string|nullable',
        ];
    }

    public function authorize()
    {
        $tournament = $this->route('tournament');

        return $this->user()->can('update', $tournament);
    }
}
