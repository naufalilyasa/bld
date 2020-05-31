<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    protected $table = 'borrowers';

    protected $guarded = [
        'id'
    ];

    protected $attributes = [
        'is_borrowed' => false,
        'return_status' => 0
    ];
}
