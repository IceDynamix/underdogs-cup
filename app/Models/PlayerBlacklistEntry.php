<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerBlacklistEntry extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(TetrioUser::class, 'tetrio_id', 'id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }

    public function isActive(): bool
    {
        return $this->until->isFuture();
    }
}
