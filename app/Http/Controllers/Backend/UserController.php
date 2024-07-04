<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Pipelines\Filters\User\Gender;
use App\Pipelines\Filters\User\Search;
use App\Services\User\UserServiceInterface;
use App\Http\Responses\ModelDeletedResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\Backend\User\UserListRequest;
use App\Http\Resources\Backend\User\UserListResource;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserServiceInterface $service)
    {
        $this->service    = $service;
    }

    public function index(UserListRequest $request): View
    {
        $data = $this->service->getAll([
            new Search($request->search),
            new Gender($request->gender)
        ],10);

        return view('Users.listing')->with(['data'=> UserListResource::collection($data)]);
    }

    public function destroy(User $user): ModelDeletedResponse
    {
        $this->service->destroy($user);

        return new ModelDeletedResponse($user);
    }
}

