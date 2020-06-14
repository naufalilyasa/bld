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

    public function getItemsAvailable() {
        return (int)$this->items_available - (int)$this->hasMany('App\Borrower', 'document_id')->where('is_borrowed', true)->count();
    }
}
