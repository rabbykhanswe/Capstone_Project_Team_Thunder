<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\SendOtpMail;

class OtpService
{
    /**
     * Send OTP via SMS using BDBulkSMS API
     *
     * @param string $phone Phone number (e.g., 01712345678 or +8801712345678)
     * @param string $otp The OTP code to send
     * @param string $purpose Purpose of OTP (registration or password_reset)
     * @return bool Success status
     */
    public function sendSms(string $phone, string $otp, string $purpose = 'registration'): bool
    {
        try {
            // Sanitize phone number - must be in format 8801xxxxxxxxx
            $formattedPhone = $this->formatPhoneNumber($phone);
            
            if (!$formattedPhone) {
                Log::error('Invalid phone number format', ['phone' => $phone]);
                return false;
            }
            
            // Get API credentials from config
            $token = config('services.bdbulksms.token');
            $apiUrl = config('services.bdbulksms.url');
            
            // Fallback to environment variables if config not set
            if (!$token) {
                $token = env('SMS_API_TOKEN'); // Changed to match your .env
            }
            if (!$apiUrl) {
                $apiUrl = env('SMS_API_URL'); // Changed to match your .env
            }
            
            // For testing without real SMS API, return true and log the OTP
            if (!$token || !$apiUrl) {
                Log::info('SMS API credentials not configured, simulating success', [
                    'phone' => $formattedPhone,
                    'otp' => $otp,
                    'message' => 'SMS would be sent here when API is configured'
                ]);
                return true; // Return true for testing
            }
            
            Log::info('BDBulkSMS API credentials found', [
                'token_exists' => !empty($token),
                'url_exists' => !empty($apiUrl),
                'token_length' => strlen($token)
            ]);
            
            // Prepare SMS message in Bangla based on purpose (under 67 characters)
            $siteName = config('app.name', 'Oronno Plants');
            if ($purpose === 'password_reset') {
                $message = "\n পাসওয়ার্ড রিসেট OTP: {$otp}।\n ২ মিনিট বৈধ।";
            } else {
                $message = "\n অ্যাকাউন্ট OTP: {$otp}।\n ২ মিনিট বৈধ। শেয়ার করবেন না।";
            }
            
            // URL encode the message for GET request (as per BDBulkSMS documentation)
            $encodedMessage = rawurlencode($message);
            
            // Build GET request URL with parameters
            $requestUrl = $apiUrl . '?token=' . $token . '&to=' . $formattedPhone . '&message=' . $encodedMessage;
            
            // Call BDBulkSMS API using GET method
            $response = Http::timeout(10)->get($requestUrl);
            
            // Check response - API returns JSON with success indicator
            if ($response->successful()) {
                $body = $response->json();
                
                // Check for success in response (adjust based on actual API response format)
                if ($response->status() == 200 || (isset($body['success']) && $body['success'])) {
                    Log::info("SMS OTP sent successfully to {$formattedPhone}");
                    return true;
                }
                
                Log::warning("SMS API returned non-success response", ['response' => $body]);
                return false;
            }
            
            Log::error("SMS API request failed", [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return false;
            
        } catch (\Exception $e) {
            Log::error("SMS sending failed: {$e->getMessage()}", [
                'phone' => $phone,
                'exception' => get_class($e),
                'trace' => $e->getTraceAsString()
            ]);
            
            return false;
        }
    }
    
    /**
     * Format phone number to BDBulkSMS expected format: +8801xxxxxxxxx
     *
     * Accepts common Bangladesh formats and normalizes them:
     *  - +8801xxxxxxxxx
     *  - 8801xxxxxxxxx
     *  - 01xxxxxxxxx
     *  - 1xxxxxxxxx (10 digits)
     *
     * @param string $phone
     * @return string|null Formatted phone or null if invalid
     */
    private function formatPhoneNumber(string $phone): ?string
    {
        $phone = trim($phone);

        // Already in +8801xxxxxxxxx format
        if (preg_match('/^\+8801\d{9}$/', $phone)) {
            return $phone;
        }

        // Remove all non-digits for normalization
        $digits = preg_replace('/[^0-9]/', '', $phone);

        // 8801xxxxxxxxx -> +8801xxxxxxxxx
        if (preg_match('/^8801\d{9}$/', $digits)) {
            return '+'.$digits;
        }

        // 01xxxxxxxxx -> +8801xxxxxxxxx
        if (preg_match('/^01\d{9}$/', $digits)) {
            return '+880'.$digits;
        }

        // 1xxxxxxxxx (10 digits, missing leading 0 and country code)
        if (preg_match('/^1\d{9}$/', $digits)) {
            return '+8801'.$digits;
        }

        // Invalid format
        \Log::warning('OtpService: Invalid phone number format after normalization', [
            'original' => $phone,
            'digits' => $digits,
        ]);

        return null;
    }
    
    
}
