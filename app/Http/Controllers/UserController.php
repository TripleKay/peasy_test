<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pipelines\Filters\User\Gender;
use App\Pipelines\Filters\User\Search;
use App\Services\User\UserServiceInterface;
use App\Http\Responses\ModelDeletedResponse;
use App\Http\Resources\User\UserListResource;
use App\Http\Requests\Api\User\UserListRequest;
use Illuminate\Http\Resources\Json\JsonResource;

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
        return view('Users.listing',compact('data'));
    }

    public function destroy(User $user): ModelDeletedResponse
    {
        $this->service->destroy($user);
        return new ModelDeletedResponse($user);
    }
}

