<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TetrioUserSnapshot extends Model
{
    public function currentUser(): HasOne {
        return $this->hasOne(TetrioUser::class, 'id', 'id');
    }
}
