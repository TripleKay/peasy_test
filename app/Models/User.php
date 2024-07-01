<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Support\Str;
use App\Events\User\UserCreated;
use App\Events\User\UserDeleted;
use App\Events\User\UserUpdated;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    protected $primaryKey   = 'id';
    // public    $incrementing = false;
    // protected $keyType      = 'string';

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */

    protected $fillable = [
        'uuid',
        'name',
        'gender',
        'location',
        'age',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name'     => 'array', // Cast JSONB to an array
        'location' => 'array', // Cast JSONB to an array
    ];


    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            event(new UserCreated($user));
        });

        static::deleted(function ($user) {
            event(new UserDeleted($user));
        });

        static::updated(function ($user) {
            event(new UserUpdated($user));
        });
    }


}
