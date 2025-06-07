<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    //

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function getFullAddressAttribute()
    {
        return $this->address . ', ' . $this->ward . ', ' . $this->district . ', ' . $this->city;
    }
}
