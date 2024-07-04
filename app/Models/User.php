<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Casts\JsonCast;
use App\Traits\Filterable;
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
    use Filterable;

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
        'name'     => JsonCast::class,
        'location' => JsonCast::class,
    ];


}
