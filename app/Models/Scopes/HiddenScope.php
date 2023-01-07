<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class HiddenScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (!auth()->user()?->is_admin) {
            $builder->where('is_hidden', false);
        }
    }
}
