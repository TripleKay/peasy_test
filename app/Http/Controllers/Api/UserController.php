<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pipelines\Filters\User\Gender;
use App\Pipelines\Filters\User\Search;
use App\Services\User\UserServiceInterface;
use App\Http\Responses\ModelDeletedResponse;
use App\Http\Resources\User\UserListResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserServiceInterface $service)
    {
        $this->service    = $service;
    }

    public function index(Request $request): JsonResource
    {

        $data = $this->service->getAll([
            new Search($request->search),
            new Gender($request->gender)
        ],$request->limit);

        return UserListResource::collection($data);

    }

    public function destroy(User $user): ModelDeletedResponse
    {

        $this->service->destroy($user);

        return new ModelDeletedResponse($user);
    }
}

