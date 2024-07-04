<?php

namespace App\Http\Resources\Backend\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'uuid'     => (string) $this->uuid,
            'name'     => is_string($this->name) ? json_decode($this->name,true) : [],
            'gender'   => (string) $this->gender,
            'location' => is_string($this->location) ? $this->getLocation(json_decode($this->location,true)) : [],
            'age'      => (integer) $this->age,
        ];
    }

    protected function getLocation(array $location)
    {
        return [
            'city'    => $location['city'] ?? '',
            'state'   => $location['start'] ?? '',
            'country' => $location['country'] ?? '',
        ];
    }
}
