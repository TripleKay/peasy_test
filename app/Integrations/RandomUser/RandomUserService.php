<?php

namespace App\Integrations\RandomUser;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Integrations\RandomUser\RandomUserServiceInterface;

class RandomUserService implements RandomUserServiceInterface
{
    protected string $api;
    protected string $limit;
    protected string $full_url;

    public function __construct()
    {
        $this->init();
    }

    /**
    * Fetch users from the API.
    *
    * @return array<int, array<string, mixed>> Array of users with their details.
    */
    public function fetchUsers(): array
    {
        Log::info('limit '.$this->limit);
        $response = Http::get($this->api, ['results' => $this->limit]);

        if ($response->successful()) {
            return $response->json()['results'];
        }

        return [];
    }

    /**
     * Format users into a collection.
     *
     * @param array<int, array<string, mixed>> $users Array of users with their details.
     * @return Collection<int, array{uuid: string, gender: string, name: string, location: string, age: int}> Collection of formatted users.
     */
    public function formatUsers(array $users) : Collection
    {
        return collect($users)->map(function($item){
            return [
                'uuid'     => (string)$item['login']['uuid'],
                'gender'   => (string)$item['gender'],
                'name'     => (string)json_encode($item['name']),
                'location' => (string)json_encode($item['location']),
                'age'      => (int)$item['dob']['age'],
            ];
        });
    }

    private function init() : void
    {
        $this->api      = config('random_user.random_user.api');
        $this->limit    = config('random_user.random_user.limit');
        $this->full_url = "{$this->api}/?results={$this->limit}";
    }
}
