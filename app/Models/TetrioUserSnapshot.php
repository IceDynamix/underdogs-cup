<?php

namespace App\Models;

use App\Http\Enums\TetrioRank;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TetrioUserSnapshot extends Model
{
    protected $fillable = [
        'id',
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
        'best_rank' => TetrioRank::class
    ];

    public function currentUser(): HasOne
    {
        return $this->hasOne(TetrioUser::class, 'id', 'id');
    }
}
