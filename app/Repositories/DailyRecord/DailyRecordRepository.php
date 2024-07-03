<?php

declare(strict_types=1);

namespace App\Repositories\DailyRecord;

use App\Models\DailyRecord;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\DailyRecord\DailyRecordRepositoryInterface;

class DailyRecordRepository extends BaseRepository implements DailyRecordRepositoryInterface
{
    public function model(): string
    {
        return DailyRecord::class;
    }

    public function getAll(): Collection
    {
        return $this->model->get();
    }

    public function store(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(array $data, Model $dailyRecord): Model
    {
        return tap(($dailyRecord), fn () => $this->model->fill($data)->update());
    }

    public function first(string $column,$value) : Model | null
    {
        return $this->model->where($column,$value)->first();
    }

    public function sync(array $data,Model | null $dailyRecord) : Model | null
    {
        if($dailyRecord){
            return $this->update($data,$dailyRecord);
        }else{
            return $this->store($data);
        }
    }

    public function destroy(Model $dailyRecord): Bool
    {
        return $dailyRecord->delete();
    }

}
