<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'plant_id', 'plant_name', 'quantity', 'unit_price', 'item_total',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'item_total' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }
}
