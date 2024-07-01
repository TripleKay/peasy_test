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

    public function fetchUsers(): array
    {
        Log::info('limit '.$this->limit);
        $response = Http::get($this->api, ['results' => $this->limit]);

        if ($response->successful()) {
            return $response->json()['results'];
        }

        return [];
    }

    public function formatUsers(array $users) : Collection
    {
        return collect($users)->map(function($item){
            return [
                'uuid'     => $item['login']['uuid'],
                'gender'   => $item['gender'],
                'name'     => json_encode($item['name']),
                'location' => json_encode($item['location']),
                'age'      => $item['dob']['age'],
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
