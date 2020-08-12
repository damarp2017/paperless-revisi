<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchasment extends Model
{
    public $incrementing = false;
    protected $guarded = [];
    public $timestamps = false;

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
}
