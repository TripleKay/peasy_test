<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ModelDeletedResponse implements Responsable
{

    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function status()
    {
        return 200;
    }

    public function toResponse($request)
    {
        return response()->json([
            'success' => true,
            'id'      => $this->model->getKey(),
            'message' => Str::snake(class_basename($this->model)).' Deleted Successfully!',
        ]);
    }
}
