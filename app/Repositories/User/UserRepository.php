<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\User\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function model(): string
    {
        return User::class;
    }

    public function getAll(): Collection
    {
        return $this->model->get();
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

    public function destroy(Model $user): Bool
    {
        return $user->delete();
    }

}
