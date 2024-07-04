<?php

namespace App\Observers;

use App\Models\User;
use App\Events\User\UserCreated;
use App\Events\User\UserDeleted;
use App\Events\User\UserUpdated;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        event(new UserCreated($user));
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        event(new UserUpdated($user));
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        event(new UserDeleted($user));
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
