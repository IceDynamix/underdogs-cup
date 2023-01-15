<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TournamentRegistration extends Model
{
    protected $fillable = [
        'tetrio_user_id',
        'tournament_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(TetrioUser::class, 'tetrio_user_id', 'id');
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class, 'tournament_id', 'id');
    }
}
