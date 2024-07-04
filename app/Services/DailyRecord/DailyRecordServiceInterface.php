<?php

declare(strict_types=1);

namespace App\Services\DailyRecord;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface DailyRecordServiceInterface
{

    public function getAll(): Collection;

    public function store(array $data): Model;

    public function update(array | null $data, Model $dailyRecord): Model;

    public function first(string $column,$value) : Model | null;

}
