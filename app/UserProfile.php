<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profiles';

    protected $guarded = [
        'id',
        'user_id'
    ];

    protected $hidden = [
        'id',
        'user_id'
    ];

    protected $nullable = [
        'optional'
    ];

    protected $casts = [
        'optional'  => 'array'
    ];
}
