<?php

namespace App\Pipelines\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    public function __construct(protected readonly string | null $value)
    {

    }

    abstract function handle(Builder $query, Closure $next): Builder;
}
