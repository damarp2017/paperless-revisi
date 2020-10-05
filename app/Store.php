<?php

namespace App;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;
    public $incrementing = false;
    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function employee()
    {
        return $this->hasMany(Employee::class, 'store_id', 'id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'store_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'store_id', 'id');
    }

    public function purchasements()
    {
        return $this->hasMany(Purchasment::class, 'store_id', 'id');
    }
}
