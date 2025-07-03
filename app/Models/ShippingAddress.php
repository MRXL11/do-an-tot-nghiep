<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    //
    protected $fillable = [
        'user_id',
        'full_name',
        'phone_number',
        'address',
        'ward',
        'district',
        'city',
        'full_address',
        'is_default'
    ];

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
