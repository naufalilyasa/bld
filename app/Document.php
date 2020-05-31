<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $guarded = [
        'id',
        'user_id'
    ];

    protected $attributes = [
        'items_available' => 1
    ];
}
