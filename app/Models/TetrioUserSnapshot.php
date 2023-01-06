<?php

namespace App\Models;

use App\Http\Enums\TetrioRank;
use Illuminate\Database\Eloquent\Model;

class TetrioUserSnapshot extends Model
{
    protected $fillable = [
        'user_id',
        'tournament_id',
        'rank',
        'best_rank',
        'rating',
        'rd',
        'pps',
        'apm',
        'vs',
        'games_played',
    ];

    protected $casts = [
        'rank' => TetrioRank::class,
        'best_rank' => TetrioRank::class,
    ];
}
