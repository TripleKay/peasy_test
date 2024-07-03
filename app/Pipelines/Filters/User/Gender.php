<?php

namespace App\Pipelines\Filters\User;

use Closure;
use App\Pipelines\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class Gender extends Filter
{
    public function handle(Builder $query, Closure $next) : Builder
    {

        $query = $query->when($this->value,function($q) {
            $q->where('gender', $this->value);
        });

        return $next($query);
    }
}
