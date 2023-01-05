<?php

namespace App\Models;

use App\Http\Enums\TetrioRank;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

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
