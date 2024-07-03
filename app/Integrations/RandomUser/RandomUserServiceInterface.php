<?php

namespace App\Integrations\RandomUser;

use Illuminate\Support\Collection;

interface RandomUserServiceInterface
{
    /**
     * Fetch users from the API.
     *
     * @return array<int, array<string, mixed>> Array of users with their details.
    */
    public function fetchUsers(): array;

    /**
     * Format users into a collection.
     *
     * @param array<int, array<string, mixed>> $users Array of users with their details.
     * @return Collection<int, array{uuid: string, gender: string, name: string, location: string, age: int}> Collection of formatted users.
    */
    public function formatUsers(array $users): Collection;
}
