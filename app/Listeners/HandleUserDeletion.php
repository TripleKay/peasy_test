<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use App\Services\Redis\RedisGenderService;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\DailyRecord\DailyRecordServiceInterface;

class HandleUserDeletion
{
    protected RedisGenderService $redisGenderService;
    protected DailyRecordServiceInterface $dailyRecordService;

    /**
     * Create the event listener.
     */
    public function __construct(RedisGenderService $redisGenderService, DailyRecordServiceInterface $dailyRecordService)
    {
        $this->redisGenderService = $redisGenderService;
        $this->dailyRecordService = $dailyRecordService;
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        ## To Update Redis Gender Count
        $this->redisGenderService->decrease($event->user);

        ## To Update Daily Record
        $dailyRecord = $this->dailyRecordService->first('date', $event->user->created_at);
        $this->dailyRecordService->update(null,$dailyRecord);
    }
}
