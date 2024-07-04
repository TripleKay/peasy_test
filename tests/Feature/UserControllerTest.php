<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Services\User\UserServiceInterface;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    protected $userService;

    public function setUp(): void
    {
        parent::setUp();

        $this->userService = Mockery::mock(UserServiceInterface::class);
        $this->app->instance(UserServiceInterface::class, $this->userService);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_user_lists()
    {
        $users = User::factory()->count(10)->make();

        $paginator = new LengthAwarePaginator($users, 10, 10);

        $this->userService
            ->shouldReceive('getAll')
            ->once()
            ->andReturn($paginator);

        $response = $this->get(route('users.index'));

        $response->assertStatus(200);

        $response->assertViewHas('data');

    }

}
