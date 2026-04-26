<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'user_id', 'status', 'subtotal', 'shipping_fee',
        'total_amount', 'shipping_name', 'shipping_phone', 'shipping_address',
        'shipping_city', 'shipping_postal_code', 'payment_method',
        'payment_status', 'tracking_number', 'notes', 'shipped_at', 'delivered_at',
    ];

    protected $casts = [
        'subtotal'      => 'decimal:2',
        'shipping_fee'  => 'decimal:2',
        'total_amount'  => 'decimal:2',
        'unit_price'    => 'decimal:2',
        'shipped_at'    => 'datetime',
        'delivered_at'  => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'shipped'    => 'bg-purple-100 text-purple-800',
            'delivered'  => 'bg-green-100 text-green-800',
            'cancelled'  => 'bg-red-100 text-red-800',
            default      => 'bg-gray-100 text-gray-800',
        };
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'cash_on_delivery' => 'Cash on Delivery',
            'bkash'            => 'bKash',
            'nagad'            => 'Nagad',
            'rocket'           => 'Rocket',
            default            => ucfirst($this->payment_method),
        };
    }

    public static function generateOrderNumber(): string
    {
        return 'OP-' . strtoupper(uniqid());
    }
}
