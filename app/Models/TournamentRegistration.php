<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentRegistration extends Model
{
    protected $fillable = [
        'tetrio_user_id',
        'tournament_id',
    ];
}
