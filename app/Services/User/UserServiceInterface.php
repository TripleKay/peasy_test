<?php

declare(strict_types=1);

namespace App\Services\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserServiceInterface
{

    public function getAll(array $filter,int $limit): LengthAwarePaginator;

    public function store(array $data): Model;

    public function update(array $data, Model $user): Model;

    public function sync(array $data): Model;

    public function destroy(Model $user): Bool;

}
