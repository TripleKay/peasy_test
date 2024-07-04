<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\User\UserRepository;
use Illuminate\Contracts\Foundation\Application;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $app = app();
        $this->userRepository = new UserRepository($app);
    }

    public function testGetAll()
    {
        $filter = [];
        $limit = 10;

        User::factory()->count(15)->create();

        $result = $this->userRepository->getAll($filter, $limit);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertCount($limit, $result->items());
    }

    public function testStore()
    {
        $data = [
            'uuid' => (string) Str::uuid(),
            'name' => json_encode([
                'title' => 'Mr.',
                'first' => 'John',
                'last'  => 'Doe',
            ]),
            'gender'   => 'male',
            'location' => json_encode([
                'city'    => 'New York',
                'state'   => 'NY',
                'country' => 'USA',
            ]),
            'age'      => 30,
        ];

        $result = $this->userRepository->store($data);

        $this->assertInstanceOf(User::class, $result);
        $this->assertDatabaseHas('users', ['uuid' => $data['uuid']]);
    }

    public function testUpdate()
    {
        $user = User::factory()->create();
        $data = [
            'name' => json_encode([
                'title' => 'Ms.',
                'first' => 'Jane',
                'last'  => 'Doe',
            ]),
        ];

        $result = $this->userRepository->update($data, $user);

        $this->assertInstanceOf(User::class, $result);
        // $this->assertEquals('Jane', $result->name['first']);
        // $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => $data['name']]);
    }

    public function testFirst()
    {
        $user = User::factory()->create(['uuid' => (string) Str::uuid()]);

        $result = $this->userRepository->first('uuid', $user->uuid);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($user->uuid, $result->uuid);
    }


    public function testSync()
    {
        $data = [
            'uuid' => (string) Str::uuid(),
            'name' => json_encode([
                'title' => 'Ms.',
                'first' => 'Jane',
                'last'  => 'Doe',
            ]),
            'gender'   => 'female',
            'location' => json_encode([
                'city'    => 'San Francisco',
                'state'   => 'CA',
                'country' => 'USA',
            ]),
            'age'      => 28,
        ];

        $existingUser = User::factory()->create([
            'uuid' => (string) Str::uuid(),
            'name' => json_encode([
                'title' => 'Mr.',
                'first' => 'John',
                'last'  => 'Doe',
            ]),
            'gender'   => 'male',
            'location' => json_encode([
                'city'    => 'New York',
                'state'   => 'NY',
                'country' => 'USA',
            ]),
            'age'      => 30,
        ]);

        // Test update scenario
        $resultWithUser = $this->userRepository->sync($data, $existingUser);
        $this->assertInstanceOf(User::class, $resultWithUser);
        // $this->assertEquals('Jane', json_decode($resultWithUser->name)->first);

        // Test create scenario
        $resultWithoutUser = $this->userRepository->sync($data, null);
        $this->assertInstanceOf(User::class, $resultWithoutUser);
        // $this->assertEquals('Jane', json_decode($resultWithoutUser->name)->first);
    }


    public function testGetAverageAges()
    {
        User::factory()->create(['gender' => 'male', 'age' => 30]);
        User::factory()->create(['gender' => 'female', 'age' => 25]);

        $result = $this->userRepository->getAverageAges();

        $this->assertIsArray($result);
        $this->assertEquals(30, $result['male_avg_age']);
        $this->assertEquals(25, $result['female_avg_age']);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();

        $result = $this->userRepository->destroy($user);

        $this->assertTrue($result);
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }
}
