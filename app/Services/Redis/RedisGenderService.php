<?php

declare(strict_types=1);

namespace App\Services\Redis;

use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Model;


class RedisGenderService
{
    public function increase(User $user)
    {
        $key = $user->gender === 'male' ? 'male_count' : 'female_count';

        return Redis::incr($key);
    }

    public function decrease(User $user)
    {
        $key = $user->gender === 'male' ? 'male_count' : 'female_count';

        return Redis::decr($key);
    }

    public function update(User $user) : void
    {
        if ($user->isDirty('gender')) {
            $originalGender = $user->getOriginal('gender');
            $newGender      = $user->gender;

            $originalKey = $originalGender === 'male' ? 'male_count' : 'female_count';
            Redis::decr($originalKey);

            $newKey = $newGender === 'male' ? 'male_count' : 'female_count';
            Redis::incr($newKey);
        }
    }

    public function get(string $key)
    {
        return Redis::get($key) ?? 0;
    }

    public function reset() : void
    {
        Redis::set('male_count', 0);
        Redis::set('female_count', 0);
    }

}
