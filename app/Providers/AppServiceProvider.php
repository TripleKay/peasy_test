<?php

namespace App\Providers;

use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;
use App\Repositories\User\UserRepository;
use App\Services\User\UserServiceInterface;
use App\Services\DailyRecord\DailyRecordService;
use App\Integrations\RandomUser\RandomUserService;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\DailyRecord\DailyRecordRepository;
use App\Services\DailyRecord\DailyRecordServiceInterface;
use App\Integrations\RandomUser\RandomUserServiceInterface;
use App\Repositories\DailyRecord\DailyRecordRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(UserServiceInterface::class, UserService::class);
        $this->app->singleton(RandomUserServiceInterface::class, RandomUserService::class);
        $this->app->singleton(DailyRecordRepositoryInterface::class, DailyRecordRepository::class);
        $this->app->singleton(DailyRecordServiceInterface::class, DailyRecordService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
