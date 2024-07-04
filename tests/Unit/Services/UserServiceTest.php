<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Mockery;
use App\Services\User\UserService;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class UserServiceTest extends TestCase
{
    protected $userService;
    protected $userRepositoryMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $this->userService = new UserService($this->userRepositoryMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testGetAll()
    {
        $filters = [];
        $limit = 10;
        $paginatorMock = Mockery::mock(LengthAwarePaginator::class);

        $this->userRepositoryMock->shouldReceive('getAll')
            ->once()
            ->with($filters, $limit)
            ->andReturn($paginatorMock);

        $result = $this->userService->getAll($filters, $limit);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    public function testStore()
    {
        $data = ['name' => 'John Doe'];
        $userMock = Mockery::mock(Model::class);

        $this->userRepositoryMock->shouldReceive('store')
            ->once()
            ->with($data)
            ->andReturn($userMock);

        $result = $this->userService->store($data);

        $this->assertInstanceOf(Model::class, $result);
    }

    public function testUpdate()
    {
        $data = ['name' => 'John Doe'];
        $userMock = Mockery::mock(Model::class);

        $this->userRepositoryMock->shouldReceive('update')
            ->once()
            ->with($data, $userMock)
            ->andReturn($userMock);

        $result = $this->userService->update($data, $userMock);

        $this->assertInstanceOf(Model::class, $result);
    }

    public function testSync()
    {
        $data = ['uuid' => 'some-uuid'];
        $userMock = Mockery::mock(Model::class);

        $this->userRepositoryMock->shouldReceive('first')
            ->once()
            ->with('uuid', $data['uuid'])
            ->andReturn($userMock);

        $this->userRepositoryMock->shouldReceive('sync')
            ->once()
            ->with($data, $userMock)
            ->andReturn($userMock);

        $result = $this->userService->sync($data);

        $this->assertInstanceOf(Model::class, $result);
    }

    public function testGetAverageAges()
    {
        $averageAges = ['male' => 30, 'female' => 28];

        $this->userRepositoryMock->shouldReceive('getAverageAges')
            ->once()
            ->andReturn($averageAges);

        $result = $this->userService->getAverageAges();

        $this->assertIsArray($result);
        $this->assertEquals($averageAges, $result);
    }

    public function testDestroy()
    {
        $userMock = Mockery::mock(Model::class);

        $this->userRepositoryMock->shouldReceive('destroy')
            ->once()
            ->with($userMock)
            ->andReturn(true);

        $result = $this->userService->destroy($userMock);

        $this->assertTrue($result);
    }
}
