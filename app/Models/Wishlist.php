<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plant_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }

    public static function isInWishlist($userId, $plantId)
    {
        return self::where('user_id', $userId)
                   ->where('plant_id', $plantId)
                   ->exists();
    }
}
