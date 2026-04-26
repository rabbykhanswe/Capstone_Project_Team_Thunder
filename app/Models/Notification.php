<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }


    public static function reviewApproved($review)
    {
        return self::create([
            'user_id' => $review->user_id,
            'type' => 'review_approved',
            'title' => 'Review Approved!',
            'message' => "Your review for {$review->plant->name} has been approved and is now visible to other customers.",
            'data' => [
                'review_id' => $review->id,
                'plant_id' => $review->plant_id,
                'plant_name' => $review->plant->name,
            ]
        ]);
    }

    // Create notification for order status change
    public static function orderStatusChanged($order)
    {
        $statusMessages = [
            'pending' => 'Your order is pending confirmation.',
            'confirmed' => 'Your order has been confirmed and is being processed.',
            'processing' => 'Your order is being prepared for shipment.',
            'shipped' => 'Your order has been shipped! Track your package.',
            'delivered' => 'Your order has been delivered successfully!',
            'cancelled' => 'Your order has been cancelled.',
        ];

        $message = $statusMessages[$order->status] ?? 'Your order status has been updated.';

        return self::create([
            'user_id' => $order->user_id,
            'type' => 'order_status',
            'title' => 'Order Status Updated',
            'message' => $message,
            'data' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
            ]
        ]);
    }
}
