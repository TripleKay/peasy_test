<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use App\Services\Redis\RedisGenderService;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateRedisGenderCount
{
    /**
     * Create the event listener.
     */
    public function __construct(protected RedisGenderService $redisGenderService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $this->redisGenderService->update($event->user);
    }
}
