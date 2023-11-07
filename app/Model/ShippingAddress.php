<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $guarded = [];
    protected $casts = [
        'customer_id' => 'integer',
        'is_billing' => 'integer',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
