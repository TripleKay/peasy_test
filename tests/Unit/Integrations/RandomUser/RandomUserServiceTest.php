<?php

namespace Tests\Unit\Integrations\RandomUser;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use App\Integrations\RandomUser\RandomUserService;
use Illuminate\Support\Collection;

class RandomUserServiceTest extends TestCase
{
    protected $randomUserService;

    public function setUp(): void
    {
        parent::setUp();

        // Mock configuration
        Config::set('random_user.random_user.api', 'https://randomuser.me/api');
        Config::set('random_user.random_user.limit', '10');

        // Create an instance of the service
        $this->randomUserService = new RandomUserService();
    }

    public function testFetchUsers()
    {
        // Mock the HTTP response
        Http::fake([
            'https://randomuser.me/api*' => Http::response(['results' => $this->getFakeUsers()], 200)
        ]);

        // Mock the log
        Log::shouldReceive('info')->once()->with('limit 10');

        // Call the method
        $users = $this->randomUserService->fetchUsers();

        // Assertions
        $this->assertIsArray($users);
        $this->assertCount(2, $users);
        $this->assertEquals('male', $users[0]['gender']);
    }

    public function testFormatUsers()
    {
        $users = $this->getFakeUsers();

        $formattedUsers = $this->randomUserService->formatUsers($users);

        // Assertions
        $this->assertInstanceOf(Collection::class, $formattedUsers);
        $this->assertCount(2, $formattedUsers);
        $this->assertEquals('Mr', json_decode($formattedUsers[0]['name'])->title);
        $this->assertEquals(30, $formattedUsers[0]['age']);
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
}
