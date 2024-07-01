<?php

declare(strict_types=1);

namespace App\Repositories\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function model(): String;

    public function getAll(): Collection;

    public function store(array $data): Model;

    public function update(array $data, Model $user): Model;

    public function sync(array $data,Model | null $user) : Model | null;

    public function first(string $column,$value) : Model  | null;

    public function destroy(Model $user): Bool;

}
