<?php

namespace App\Models;

use App\Http\Enums\TetrioRank;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'bracket_url',
        'status',
        'hidden',
        'description',
        'reg_open_ts',
        'reg_closed_ts',
        'check_in_open_ts',
        'check_in_closed_ts',
        'tournament_start_ts',
        'lower_reg_rank_cap',
        'upper_reg_rank_cap',
        'grace_rank_cap',
        'min_games_played',
        'max_rd',
        'full_description',
    ];

    protected $casts = [
        'lower_reg_rank_cap' => TetrioRank::class,
        'upper_reg_rank_cap' => TetrioRank::class,
        'grace_rank_cap' => TetrioRank::class,
    ];

    public function rankRange(): string
    {
        $lower = $this->lower_reg_rank_cap;
        $upper = $this->upper_reg_rank_cap;

        $hasLowerCap = $lower != null;
        $hasUpperCap = $upper != null;

        if ($hasLowerCap && $hasUpperCap) {
            return "$lower->format() - $upper->format()";
        }

        if ($hasLowerCap) {
            return ">$lower->format() rank";
        }

        if ($hasUpperCap) {
            return "<$upper->format() rank";
        }

        return 'No rank restriction';
    }
}
