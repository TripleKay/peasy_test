<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class UserObserver
{
    /**
     * Handle the User "created" User.
     */
    public function created(User $user): void
    {
        $key = $user->gender === 'male' ? 'male_count' : 'female_count';
        Redis::incr($key);
    }

    /**
     * Handle the User "updated" User.
     */
    public function updated(User $user): void
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

    /**
     * Handle the User "deleted" User.
     */
    public function deleted(User $user): void
    {
        $key = $user->gender === 'male' ? 'male_count' : 'female_count';
        Redis::decr($key);
    }

    /**
     * Handle the User "restored" User.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" User.
     */
    public function forceDeleted(User $user): void
    {
        $key = $user->gender === 'male' ? 'male_count' : 'female_count';
        Redis::decr($key);
    }
}
