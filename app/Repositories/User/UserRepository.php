<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\User\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function model(): string
    {
        return User::class;
    }

    public function getAll(array $filter,int $limit): LengthAwarePaginator
    {
        return $this->model->query()->filter($filter)->paginate($limit);
    }

    public function store(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(array $data, Model $user): Model
    {
        return tap(($user), fn () => $event->fill($data)->update());
    }

    public function first(string $column,$value) : Model | null
    {
        return $this->model->where($column,$value)->first();
    }

    public function sync(array $data,Model | null $user) : Model | null
    {
        if($user){
            return $this->update($data,$user);
        }else{
            return $this->store($data);
        }
    }

    public function getAverageAges(): array
    {
        return [
            'male_avg_age'   => $this->model->where('gender', 'male')->avg('age'),
            'female_avg_age' => $this->model->where('gender', 'female')->avg('age'),
        ];

    }

    public function destroy(Model $user): Bool
    {
        return $user->delete();
    }

}
