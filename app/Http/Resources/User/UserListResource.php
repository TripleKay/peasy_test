<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $gender
 * @property string $location
 * @property int $age
 */
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
            'name'     => json_decode($this->name,true),
            'gender'   => (string) $this->gender,
            'location' => $this->getLocation(json_decode($this->location,true)),
            'age'      => (integer) $this->age,
        ];
    }

    protected function getLocation(array $location) : array
    {
        return [
            'city'    => $location['city'] ?? '',
            'state'   => $location['start'] ?? '',
            'country' => $location['country'] ?? '',
        ];
    }
}
