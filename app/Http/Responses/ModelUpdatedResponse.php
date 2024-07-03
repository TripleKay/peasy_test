<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class ModelUpdatedResponse implements Responsable
{

    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function status() : int
    {
        return 200;
    }

    public function toResponse($request) : JsonResponse
    {
        return response()->json([
            'success' => true,
            'id'      => $this->model->getKey(),
            'message' => Str::snake(class_basename($this->model)).' Updated Successfully!',
        ]);
    }
}
