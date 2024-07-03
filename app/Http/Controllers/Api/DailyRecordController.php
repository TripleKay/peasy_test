<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\DailyRecord\DailyRecordServiceInterface;
use App\Http\Resources\DailyRecord\DailyRecordListResource;

class DailyRecordController extends Controller
{
    protected DailyRecordServiceInterface $service;

    public function __construct(DailyRecordServiceInterface $service)
    {
        $this->service    = $service;
    }

    public function index(): JsonResource
    {
        $data = $this->service->getAll();

        return DailyRecordListResource::collection($data);

    }
}
