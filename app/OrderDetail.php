<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id', 'pizza_id', 'size_id', 'quantity', 'single_price', 'total_price'
    ];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
