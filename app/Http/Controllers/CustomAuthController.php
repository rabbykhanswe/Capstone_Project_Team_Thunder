<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Services\OtpService;

class CustomAuthController extends Controller
{
    /**
     * Handle Mobile Registration with OTP
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Validate inputs for mobile registration only
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:phone',
            'phone' => 'required|digits:10|unique:users,phone',
            'password' => 'required|string|min:8|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ], [
            'phone.digits' => 'Phone number must be exactly 10 digits (e.g., 1712345678)',
            'phone.unique' => 'This phone number is already registered',
            'password.min' => 'Password must be at least 8 characters',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        
        // Normalize phone number to +880 format
        $phone = $validated['phone'];
        // Remove any existing prefix and add +880
        $phone = preg_replace('/^(\+880|880)?/', '', $phone);
        $phone = '+880' . $phone;
        $validated['phone'] = $phone;
        
        // Check if normalized phone number already exists
        $existingUser = User::where('phone', $phone)->first();
        if ($existingUser) {
            return response()->json([
                'status' => 'error',
                'message' => 'This phone number is already registered. Please login instead.'
            ], 422);
        }

        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Create unique cache key for this registration attempt
        $cacheKey = 'otp_registration_' . $validated['phone'];
        
        // Check if user is blocked from sending OTP
        $blockKey = 'otp_block_' . $validated['phone'];
        if (Cache::has($blockKey)) {
            $blockData = Cache::get($blockKey);
            $remainingTime = ceil(($blockData['blocked_until'] - now()->timestamp) / 60);
            return response()->json([
                'status' => 'error',
                'message' => "Too many attempts. Please try again after {$remainingTime} minutes.",
                'blocked_until' => $blockData['blocked_until']
            ], 429);
        }
        
        // Get existing resend attempts count
        $resendKey = 'otp_resend_count_' . $validated['phone'];
        $resendCount = Cache::get($resendKey, 0);
        
        // Store OTP and registration data in cache for 5 minutes (allows time for resend)
        Cache::put($cacheKey, [
            'otp' => $otp,
            'type' => 'phone',
            'phone' => $validated['phone'],
            'password' => $validated['password'], // Store temporarily for user creation
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'created_at' => now()->timestamp,
            'expires_at' => now()->addMinutes(2)->timestamp,
            'attempts' => 0,
            'resend_count' => $resendCount
        ], now()->addMinutes(5));

        // Send OTP via SMS using OtpService
        try {
            \Log::info('Attempting to send SMS OTP', [
                'phone' => $validated['phone'],
                'otp' => $otp
            ]);
            
            $otpService = new \App\Services\OtpService();
            $success = $otpService->sendSms($validated['phone'], $otp);
            
            \Log::info('SMS OTP send result', [
                'success' => $success,
                'phone' => $validated['phone']
            ]);
            
            if (!$success) {
                \Log::error('Failed to send SMS OTP', [
                    'phone' => $validated['phone']
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to send OTP to your phone number. Please try again.'
                ], 500);
            }

            return response()->json([
                'status' => 'otp_sent',
                'type' => 'phone',
                'message' => 'OTP sent to your phone number',
                'expires_in' => 120, // 2 minutes in seconds
                'resend_count' => $resendCount,
                'max_resends' => 3
            ], 200);

        } catch (\Exception $e) {
            \Log::error('OTP sending failed in register: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'System Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify OTP and Create User
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyOtp(Request $request)
    {
        // Validate OTP input for mobile only
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:phone',
            'phone' => 'required',
            'otp' => 'required|string|size:6|regex:/^\d{6}$/',
        ], [
            'otp.size' => 'OTP must be exactly 6 digits',
            'otp.regex' => 'OTP must contain only numbers',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        
        // Normalize phone number
        $phone = $validated['phone'];
        $phone = preg_replace('/^(\+880|880)?/', '', $phone);
        $phone = '+880' . $phone;
        $identifier = $phone;

        // Check if user is blocked
        $blockKey = 'otp_block_' . $identifier;
        if (Cache::has($blockKey)) {
            $blockData = Cache::get($blockKey);
            $remainingTime = ceil(($blockData['blocked_until'] - now()->timestamp) / 60);
            return response()->json([
                'status' => 'error',
                'message' => "Too many failed attempts. Please try again after {$remainingTime} minutes."
            ], 429);
        }
        
        // Get cached OTP data
        $cacheKey = 'otp_registration_' . $identifier;
        $cachedData = Cache::get($cacheKey);

        if (!$cachedData) {
            return response()->json([
                'status' => 'error',
                'message' => 'OTP has expired. Please request a new one.'
            ], 400);
        }

        // Check if OTP has expired (2 minutes)
        $currentTime = now()->timestamp;
        $expiresAt = $cachedData['expires_at'];
        
        if ($currentTime > $expiresAt) {
            return response()->json([
                'status' => 'error',
                'message' => 'OTP has expired. Please request a new one.',
                'expired' => true
            ], 422);
        }
        
        // Verify OTP matches
        if ($cachedData['otp'] !== $validated['otp']) {
            // Increment failed attempts
            $cachedData['attempts']++;
            Cache::put($cacheKey, $cachedData, now()->addMinutes(5));
            
            // Block user after 5 failed verification attempts
            if ($cachedData['attempts'] >= 5) {
                $blockKey = 'otp_block_' . $identifier;
                Cache::put($blockKey, [
                    'blocked_until' => now()->addMinutes(15)->timestamp,
                    'reason' => 'Too many failed OTP verification attempts'
                ], now()->addMinutes(15));
                
                // Clear the OTP cache
                Cache::forget($cacheKey);
                
                return response()->json([
                    'status' => 'error',
                    'message' => 'Too many failed attempts. You are blocked for 15 minutes.',
                    'blocked' => true
                ], 429);
            }
            
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid OTP. ' . (5 - $cachedData['attempts']) . ' attempts remaining.'
            ], 422);
        }
        
        // OTP is valid - Create user
        try {
            $userData = [
                'fname' => $cachedData['first_name'],
                'lname' => $cachedData['last_name'],
                'phone' => $cachedData['phone'],
                'password' => Hash::make($cachedData['password']),
                'role' => 'customer',
                'is_verified' => true
            ];
            
            $user = User::create($userData);

            // Clear OTP from cache
            Cache::forget($cacheKey);

            // Log user in
            Auth::login($user, true);

            // Determine redirect URL after successful login
            $redirectUrl = route('home'); // Changed to home since account.dashboard might not exist
            
            // Check for explicit redirect parameter from login request
            if ($request->has('redirect')) {
                $potentialRedirect = $request->input('redirect');
                // Validate redirect URL is safe
                if (str_starts_with($potentialRedirect, url('/'))) {
                    $redirectUrl = $potentialRedirect;
                }
            } else {
                // Use intended URL if available
                $redirectUrl = session()->pull('url.intended', $redirectUrl);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Account created successfully',
                'redirect' => $redirectUrl,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'phone' => $user->phone,
                ]
            ], 200);

        } catch (\Exception $e) {
            \Log::error('User creation failed: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create account. Please try again.'
            ], 500);
        }
    }

    /**
     * Resend OTP with attempt tracking
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:phone',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        $validated = $validator->validated();
        
        // Normalize phone number
        $phone = $validated['phone'];
        $phone = preg_replace('/^(\+880|880)?/', '', $phone);
        $phone = '+880' . $phone;
        $identifier = $phone;

        // Check if user is blocked
        $blockKey = 'otp_block_' . $identifier;
        if (Cache::has($blockKey)) {
            $blockData = Cache::get($blockKey);
            $remainingTime = ceil(($blockData['blocked_until'] - now()->timestamp) / 60);
            return response()->json([
                'status' => 'error',
                'message' => "Too many attempts. Please try again after {$remainingTime} minutes.",
                'blocked_until' => $blockData['blocked_until']
            ], 429);
        }
        
        // Get cached registration data
        $cacheKey = 'otp_registration_' . $identifier;
        $cachedData = Cache::get($cacheKey);
        
        if (!$cachedData) {
            return response()->json([
                'status' => 'error',
                'message' => 'OTP session expired. Please close this window and start registration again.',
                'expired' => true,
                'session_expired' => true
            ], 400);
        }
        
        // Check resend attempts
        $resendKey = 'otp_resend_count_' . $identifier;
        $resendCount = Cache::get($resendKey, 0);
        
        if ($resendCount >= 3) {
            // Block user for 15 minutes after 3 resend attempts
            Cache::put($blockKey, [
                'blocked_until' => now()->addMinutes(15)->timestamp,
                'reason' => 'Too many OTP resend attempts'
            ], now()->addMinutes(15));
            
            // Clear OTP and resend count
            Cache::forget($cacheKey);
            Cache::forget($resendKey);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Too many resend attempts. You are blocked for 15 minutes.',
                'blocked' => true
            ], 429);
        }
        
        // Generate new OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Update cached data with new OTP and timestamp
        $cachedData['otp'] = $otp;
        $cachedData['created_at'] = now()->timestamp;
        $cachedData['expires_at'] = now()->addMinutes(2)->timestamp;
        $cachedData['attempts'] = 0; // Reset verification attempts
        $cachedData['resend_count'] = $resendCount + 1;
        
        Cache::put($cacheKey, $cachedData, now()->addMinutes(5));
        
        // Increment resend count (expires in 15 minutes)
        Cache::put($resendKey, $resendCount + 1, now()->addMinutes(15));
        
        // Send OTP via SMS using OtpService
        try {
            \Log::info('Attempting to resend SMS OTP', [
                'phone' => $identifier,
                'otp' => $otp
            ]);
            
            $otpService = new \App\Services\OtpService();
            $success = $otpService->sendSms($identifier, $otp);
            
            \Log::info('SMS OTP resend result', [
                'success' => $success,
                'phone' => $identifier
            ]);
            
            if (!$success) {
                \Log::error('Failed to resend SMS OTP', [
                    'phone' => $identifier
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to resend OTP to your phone number. Please try again.'
                ], 500);
            }
            
            $message = 'New OTP sent to your phone number';
            
            return response()->json([
                'status' => 'otp_sent',
                'type' => 'phone',
                'message' => $message,
                'expires_in' => 120,
                'resend_count' => $resendCount + 1,
                'max_resends' => 3,
                'remaining_resends' => max(0, 3 - ($resendCount + 1))
            ], 200);
            
        } catch (\Exception $e) {
            \Log::error('OTP resending failed: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send OTP. Please try again.'
            ], 500);
        }
    }
}
