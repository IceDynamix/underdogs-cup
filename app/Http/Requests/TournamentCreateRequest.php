<?php

namespace App\Http\Requests;

use App\Http\Enums\TetrioRank;
use App\Http\Enums\TournamentStatus;
use App\Models\Tournament;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TournamentCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|string|unique:tournaments,id',
            'name' => 'required|string',
            'bracket_url' => 'string|nullable',
            'status' => ['required', new Enum(TournamentStatus::class)],
            'hidden' => 'boolean',
            'description' => 'string|nullable',
            'reg_open_ts' => 'date|nullable',
            'reg_closed_ts' => 'date|nullable',
            'check_in_open_ts' => 'date|nullable',
            'check_in_closed_ts' => 'date|nullable',
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
        return $this->user()->can('create', Tournament::class);
    }
}
