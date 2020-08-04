<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use SoftDeletes;

    public static $ROLESTAFF = 1;
    public static $ROLECASHIER = 0;

    public $incrementing = false;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
}
