<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderContact extends Model
{
    protected $fillable = [
        'order_id', 'full_name', 'phone_number', 'full_address', 'zip_code'
    ];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
