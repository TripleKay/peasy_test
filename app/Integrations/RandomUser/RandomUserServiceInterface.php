<?php

namespace App\Integrations\RandomUser;

use Illuminate\Support\Collection;

interface RandomUserServiceInterface
{
    public function fetchUsers(): array;

    public function formatUsers(array $users): Collection;
}
