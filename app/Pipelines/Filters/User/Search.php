<?php

namespace App\Pipelines\Filters\User;

use Closure;
use App\Pipelines\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class Search extends Filter
{
    public function handle(Builder $query, Closure $next) : Builder
    {

        $query = $query->when($this->value,function($q) {
            $q->where(function($q){
                $q->where('uuid', 'like', "%{$this->value}%")
                ->orWhere('name', 'like', "%{$this->value}%")
                ->orWhere('age', 'like', "%{$this->value}%");
            });
        });

        return $next($query);
    }
}
