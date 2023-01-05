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
}
