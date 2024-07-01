<?php

namespace App\Console;

use App\Jobs\FetchRandomUsersJob;
use App\Services\User\UserServiceInterface;
use Illuminate\Console\Scheduling\Schedule;
use App\Integrations\RandomUser\RandomUserService;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        $schedule->job(new FetchRandomUsersJob(
            app(RandomUserService::class),
            app(UserServiceInterface::class)))->everySecond();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
