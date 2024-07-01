<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\User\UserServiceInterface;
use App\Repositories\User\UserRepositoryInterface;

class TestController extends Controller
{
    protected $service, $repository;

    public function __construct(UserServiceInterface $service, UserRepositoryInterface $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function test(){

        // return User::create([
        //     'uuid' => 'sdfsdfsdfsdfs',
        //     'name'=> [
        //         'hello','name'
        //     ],
        //     'gender'=> 'male',
        //     'location' => [
        //         'ld' => 'test'
        //     ],
        //     'age' => 10,]);


        return $this->service->store(
            [
        'uuid' => 'sdfsdfsdfsdddfdss',
        'name'=> [
            'hello','name'
        ],
        'gender'=> 'male',
        'location' => [
            'ld' => 'test'
        ],
        'age' => 10,]);
    }
}
