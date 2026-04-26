<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OtpVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'otp_code',
        'expires_at',
        'is_used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean',
    ];



    
    public static function generateOTP()
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }




    public static function createOTP($phone, $otp)
    {
        return self::create([
            'phone' => $phone,
            'otp_code' => $otp,
            'expires_at' => now()->addMinutes(2), // 2 minutes
            'is_used' => false,
        ]);
    }


    

    public static function verifyOTP($phone, $otp)
    {
        $record = self::where('phone', $phone)
                    ->where('otp_code', $otp)
                    ->where('is_used', false)
                    ->where('expires_at', '>', now())
                    ->first();

        if (!$record) {
            return false;
        }


        if ($record->expires_at < now()) {
            return false;
        }


        $record->update(['is_used' => true]);

        return true;
    }
}
