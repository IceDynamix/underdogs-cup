<?php

namespace App\Models;

use App\Enums\TetrioRank;
use App\Enums\TournamentStatus;
use App\Models\Scopes\HiddenScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tournament extends Model
{
    use HasFactory;

    public $incrementing = false;

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
        'status' => TournamentStatus::class,
        'reg_open_ts' => 'datetime',
        'reg_closed_ts' => 'datetime',
        'check_in_open_ts' => 'datetime',
        'check_in_closed_ts' => 'datetime',
        'tournament_start_ts' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new HiddenScope);
    }

    public function rankRange(): string
    {
        $lower = $this->lower_reg_rank_cap;
        $upper = $this->upper_reg_rank_cap;

        $hasLowerCap = $lower != null;
        $hasUpperCap = $upper != null;

        if ($hasLowerCap && $hasUpperCap) {
            return $lower->format().' - '.$upper->format();
        }

        if ($hasLowerCap) {
            return '>'.$lower->format().' rank';
        }

        if ($hasUpperCap) {
            return '<'.$upper->format().' rank';
        }

        return 'No rank restriction';
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(TetrioUser::class, 'tournament_registrations', 'tournament_id', 'tetrio_user_id');
    }
}
