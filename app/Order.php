<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'datetime', 'ship_price', 'total'
    ];

    function orderContact() 
    { 
        return $this->hasOne('App\OrderContact'); 
    }

    function orderDetails() { 
        return $this->hasMany('App\OrderDetail'); 
    }
}
