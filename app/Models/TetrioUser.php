<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TetrioUser extends Model
{
    public function snapshotUser(): HasOne {
        return $this->hasOne(TetrioUserSnapshot::class, 'id', 'id');
    }
}
