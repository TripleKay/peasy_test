<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\User\UserRepository;
use App\Services\User\UserServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Integrations\RandomUser\RandomUserService;

class FetchRandomUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $randomUserService;
    private $userService;

    /**
     * Create a new job instance.
     *
     * @param  RandomUserService  $randomUserService
     * @param  UserServiceInterface  $userService
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     */
    public function handle(RandomUserService $randomUserService, UserServiceInterface $userService): void
    {
        $this->randomUserService = $randomUserService;
        $this->userService       = $userService;

        $users = $this->randomUserService->fetchUsers();

        $users = $this->randomUserService->formatUsers($users);

        collect($users)->map(function($item){

            $this->userService->sync($item);

        });

    }
}
