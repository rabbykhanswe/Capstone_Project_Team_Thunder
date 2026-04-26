<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    protected OtpService $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function sendOrderConfirmation(User $user, Order $order): void
    {
        $message = "Oronno Plants: Your order #{$order->order_number} has been placed! Total: ৳{$order->total_amount}. We'll notify you when it ships.";
        $this->sendSms($user->phone, $message);
    }

    public function sendShippingUpdate(User $user, Order $order): void
    {
        $tracking = $order->tracking_number ? " Tracking: {$order->tracking_number}" : '';
        $message  = "Oronno Plants: Your order #{$order->order_number} has been shipped!{$tracking} Expected delivery: 2-3 days.";
        $this->sendSms($user->phone, $message);
    }

    public function sendDeliveryConfirmation(User $user, Order $order): void
    {
        $message = "Oronno Plants: Your order #{$order->order_number} has been delivered! Thank you for shopping with us.";
        $this->sendSms($user->phone, $message);
    }

    public function sendOrderCancellation(User $user, Order $order): void
    {
        $message = "Oronno Plants: Your order #{$order->order_number} has been cancelled. Contact us if you have questions.";
        $this->sendSms($user->phone, $message);
    }

    private function sendSms(string $phone, string $message): void
    {
        try {
            $token  = config('services.bdbulksms.token', env('SMS_API_TOKEN'));
            $apiUrl = config('services.bdbulksms.url', env('SMS_API_URL'));

            if (!$token || !$apiUrl) {
                Log::info('SMS Notification (simulated)', ['phone' => $phone, 'message' => $message]);
                return;
            }

            $digits = preg_replace('/[^0-9]/', '', $phone);
            if (preg_match('/^01\d{9}$/', $digits))      $formatted = '+880' . $digits;
            elseif (preg_match('/^8801\d{9}$/', $digits)) $formatted = '+' . $digits;
            else                                           $formatted = '+880' . $digits;

            $encoded = rawurlencode($message);
            $url     = $apiUrl . '?token=' . $token . '&to=' . $formatted . '&message=' . $encoded;

            \Illuminate\Support\Facades\Http::timeout(8)->get($url);
            Log::info('Order SMS sent', ['phone' => $formatted]);
        } catch (\Exception $e) {
            Log::error('SMS notification failed: ' . $e->getMessage());
        }
    }
}
