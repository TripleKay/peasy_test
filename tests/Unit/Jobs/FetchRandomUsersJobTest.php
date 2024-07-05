<?php

namespace Tests\Unit\Jobs;

use Tests\TestCase;
use Mockery;
use App\Jobs\FetchRandomUsersJob;
use App\Integrations\RandomUser\RandomUserService;
use App\Services\User\UserServiceInterface;
use Illuminate\Support\Facades\Queue;

class FetchRandomUsersJobTest extends TestCase
{
    public function testHandle()
    {
        // Mock the dependencies
        $randomUserServiceMock = Mockery::mock(RandomUserService::class);
        $userServiceMock = Mockery::mock(UserServiceInterface::class);

        // Mock the behavior of fetchUsers and formatUsers methods
        $randomUserServiceMock->shouldReceive('fetchUsers')
            ->once()
            ->andReturn($this->getFakeUsers());

        $randomUserServiceMock->shouldReceive('formatUsers')
            ->once()
            ->with($this->getFakeUsers())
            ->andReturn(collect($this->getFormattedUsers()));

        // Mock the sync method to expect it to be called with each formatted user
        foreach ($this->getFormattedUsers() as $user) {
            $userServiceMock->shouldReceive('sync')
                ->once()
                ->with($user);
        }

        // Initialize the job and call the handle method
        $job = new FetchRandomUsersJob();
        $job->handle($randomUserServiceMock, $userServiceMock);
    }

    private function getFakeUsers()
    {
        return [
            [
                'gender' => 'male',
                'name' => [
                    'title' => 'Mr',
                    'first' => 'John',
                    'last' => 'Doe',
                ],
                'location' => [
                    'city' => 'New York',
                    'state' => 'NY',
                    'country' => 'USA',
                ],
                'login' => [
                    'uuid' => '1234-5678-91011',
                ],
                'dob' => [
                    'age' => 30,
                ],
            ],
            [
                'gender' => 'female',
                'name' => [
                    'title' => 'Ms',
                    'first' => 'Jane',
                    'last' => 'Smith',
                ],
                'location' => [
                    'city' => 'Los Angeles',
                    'state' => 'CA',
                    'country' => 'USA',
                ],
                'login' => [
                    'uuid' => '1112-1314-1516',
                ],
                'dob' => [
                    'age' => 25,
                ],
            ],
        ];
    }

    private function getFormattedUsers()
    {
        return [
            [
                'uuid' => '1234-5678-91011',
                'gender' => 'male',
                'name' => json_encode([
                    'title' => 'Mr',
                    'first' => 'John',
                    'last' => 'Doe',
                ]),
                'location' => json_encode([
                    'city' => 'New York',
                    'state' => 'NY',
                    'country' => 'USA',
                ]),
                'age' => 30,
            ],
            [
                'uuid' => '1112-1314-1516',
                'gender' => 'female',
                'name' => json_encode([
                    'title' => 'Ms',
                    'first' => 'Jane',
                    'last' => 'Smith',
                ]),
                'location' => json_encode([
                    'city' => 'Los Angeles',
                    'state' => 'CA',
                    'country' => 'USA',
                ]),
                'age' => 25,
            ],
        ];
    }
}
