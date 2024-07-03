<?php

namespace App\Traits;

use Illuminate\Support\Facades\Pipeline;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter(Builder $query, array $filters)
    {
        return Pipeline::send($query)
            ->through($filters)
            ->thenReturn();
    }
}
