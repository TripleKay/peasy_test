<?php

declare(strict_types=1);

namespace App\Services\DailyRecord;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Services\Redis\RedisGenderService;
use App\Services\User\UserServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\DailyRecord\DailyRecordRepositoryInterface;

class DailyRecordService implements DailyRecordServiceInterface
{

    private $repository;
    private $userService;
    private $redisGenderService;

    public function __construct(DailyRecordRepositoryInterface $repository,UserServiceInterface $userService,RedisGenderService $redisGenderService)
    {
        $this->repository         = $repository;
        $this->userService        = $userService;
        $this->redisGenderService = $redisGenderService;
    }

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    public function store(array $data): Model
    {
        $data['male_count']     = $this->redisGenderService->get('male_count');
        $data['female_count']   = $this->redisGenderService->get('female_count');

        $data['date']           = now();

        $data['male_avg_age']   = $this->userService->getAverageAges()['male_avg_age'];
        $data['female_avg_age'] = $this->userService->getAverageAges()['female_avg_age'];

        $dailyRecord =  $this->repository->store($data);

        $this->redisGenderService->reset();

        return $dailyRecord;
    }

    public function first(string $column,$value) : Model | null
    {
        return $this->repository->first($column,$value);
    }

    public function update(array | null $data, Model $dailyRecord): Model
    {

        $data['male_count']     = $this->redisGenderService->get('male_count');
        $data['female_count']   = $this->redisGenderService->get('female_count');

        $data['male_avg_age']   = $this->userService->getAverageAges()['male_avg_age'];
        $data['female_avg_age'] = $this->userService->getAverageAges()['female_avg_age'];

        return $this->repository->update($data,$dailyRecord);
    }

    public function updateByUser(User $user) : Model
    {
        $dailyRecord = $this->repository->first('date', $user->created_at);

        $data['male_count']     = $this->redisGenderService->get('male_count');
        $data['female_count']   = $this->redisGenderService->get('female_count');

        $data['male_avg_age']   = $this->userService->getAverageAges()['male_avg_age'];
        $data['female_avg_age'] = $this->userService->getAverageAges()['female_avg_age'];

        return $this->repository->update($data,$dailyRecord);

    }


}
