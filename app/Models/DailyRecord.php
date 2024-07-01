<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyRecord extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey   = 'id';
    // public    $incrementing = false;
    // protected $keyType      = 'string';

    protected $fillable = [
        'date',
        'male_count',
        'female_count',
        'male_avg_age',
        'female_avg_age',
    ];

    protected $casts = [
        'date'           => 'date',
        'male_count'     => 'integer',
        'female_count'   => 'integer',
        'male_avg_age'   => 'decimal',
        'female_avg_age' => 'decimal',
    ];

}
