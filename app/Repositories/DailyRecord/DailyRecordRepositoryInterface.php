<?php

declare(strict_types=1);

namespace App\Repositories\DailyRecord;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface DailyRecordRepositoryInterface
{
    public function model(): String;

    public function getAll(): Collection;

    public function store(array $data): Model;

    public function update(array $data, Model $dailyRecord): Model;

    public function sync(array $data,Model | null $dailyRecord) : Model | null;

    public function first(string $column,$value) : Model  | null;

    public function destroy(Model $dailyRecord): Bool;

}
