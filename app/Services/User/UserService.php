<?php

declare(strict_types=1);

namespace App\Services\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\User\UserRepositoryInterface;

class UserService implements UserServiceInterface
{

    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    public function store(array $data): Model
    {
        return $this->repository->store($data);
    }

    public function update(array $data, Model $user): Model
    {
        return $this->repository->update($data,$user);
    }

    public function sync(array $data): Model
    {
        $user = $this->repository->first('uuid',$data['uuid']);

        return $this->repository->sync($data,$user);
    }

    public function getAverageAges(): array
    {
        return $this->repository->getAverageAges();
    }

    public function destroy(Model $user): Bool
    {
        return $this->repository->destroy($user);
    }

}
