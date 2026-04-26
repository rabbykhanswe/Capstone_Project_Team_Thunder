<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    /**
     * Show OTP verification page
     */
    public function showVerification()
    {
        return view('auth.verify-otp');
    }

    /**
     * Send OTP to phone number
     */
    public function sendOTP(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|max:20|exists:users,phone',
        ]);

        $phoneNumber = $validated['phone'];
        
        // Generate OTP
        $otp = OtpVerification::generateOTP();
        
        // Create OTP record
        OtpVerification::createOTP($phoneNumber, $otp);
        
        // Send SMS using cURL (beginner friendly)
        $apiKey = env('SMS_API_TOKEN');
        $apiUrl = env('SMS_API_URL');
        
        // For demo/testing: if SMS API is not configured, show OTP in session
        if (!$apiKey || !$apiUrl) {
            return redirect()->route('otp.verify.form')
                ->with('phone', $phoneNumber)
                ->with('success', "OTP sent successfully! (Demo Mode - OTP: $otp)");
        }
        
        $message = "Your Oronno Plants verification code is: " . $otp;
        
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'api_key' => $apiKey,
            'sender' => 'OronnoPlants',
            'recipient' => $phoneNumber,
            'message' => $message
        ]));
        
        $response = curl_exec($ch);
        
        if ($response === false) {
            return redirect()->back()->with('error', 'Failed to send SMS. Please try again.');
        }
        
        $result = json_decode($response, true);
        
        if (isset($result->status) && $result->status == 'success') {
            // Redirect to OTP verification page
            return redirect()->route('otp.verify.form')
                ->with('phone', $phoneNumber)
                ->with('success', 'OTP sent successfully! Please check your phone.');
        } else {
            return redirect()->back()->with('error', 'Failed to send SMS: ' . ($result->message ?? 'Unknown error'));
        }
    }

    /**
     * Verify OTP code
     */
    public function verifyOTP(Request $request)
    {
        Log::info('=== VERIFY OTP METHOD CALLED ===');
        Log::info('Request data: ' . json_encode($request->all()));
        Log::info('Session data: ' . json_encode(session()->all()));
        
        $validated = $request->validate([
            'otp_1' => 'required|string|max:1',
            'otp_2' => 'required|string|max:1',
            'otp_3' => 'required|string|max:1',
            'otp_4' => 'required|string|max:1',
            'otp_5' => 'required|string|max:1',
            'otp_6' => 'required|string|max:1',
            'phone' => 'required|string|max:20',
        ]);
        
        Log::info('Validation passed: ' . json_encode($validated));

        // Combine OTP inputs
        $otp = $validated['otp_1'] . $validated['otp_2'] . $validated['otp_3'] . $validated['otp_4'] . $validated['otp_5'] . $validated['otp_6'];
        
        Log::info('Combined OTP: ' . $otp);
        Log::info('Phone for verification: ' . $validated['phone']);
        
        // Verify OTP
        $verificationResult = OtpVerification::verifyOTP($validated['phone'], $otp);
        Log::info('OTP verification result: ' . ($verificationResult ? 'SUCCESS' : 'FAILED'));
        
        if ($verificationResult) {
            Log::info('=== OTP VERIFICATION SUCCESS ===');
            // Check if there's a pending user registration
            if (session()->has('pending_user')) {
                Log::info('Pending user found in session');
                // Create the user from session data
                $userData = session('pending_user');
                Log::info('User data from session: ' . json_encode($userData));
                
                $user = User::create($userData);
                Log::info('User created with ID: ' . $user->id);
                
                // Mark user as verified
                $user->update(['is_verified' => true]);
                Log::info('User marked as verified');
                
                // Clear session
                session()->forget('pending_user');
                Log::info('Pending user session cleared');
                
                return redirect()->route('login_form')
                    ->with('success', 'Registration successful! Your phone number has been verified. You can now login.');
            } else {
                Log::info('No pending user found, marking existing user as verified');
                // Mark existing user as verified
                $user = User::where('phone', $validated['phone'])->first();
                if ($user) {
                    $user->update(['is_verified' => true]);
                    Log::info('Existing user marked as verified');
                }
                
                return redirect()->route('login_form')
                    ->with('success', 'Phone number verified successfully! You can now login.');
            }
        } else {
            Log::info('=== OTP VERIFICATION FAILED ===');
            return redirect()->back()
                ->with('error', 'Invalid OTP. Please try again.')
                ->withInput();
        }
    }

    /**
     * Show forgot password form
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send OTP for password reset
     */
    public function sendPasswordOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20'
        ]);

        // Add +880 prefix to phone number
        $phone = $request->phone;
        // Remove any existing prefix and add +880
        $phone = preg_replace('/^(\+880|880)?/', '', $phone);
        $phone = '+880' . $phone;

        $user = User::where('phone', $phone)->first();
        if (!$user) {
            return back()->withErrors(['phone' => 'No account found with this phone number.']);
        }

        // Create OTP
        $otpCode = OtpVerification::generateOTP();
        $otp = OtpVerification::createOTP($phone, $otpCode);
        
        // Send OTP via SMS using OtpService
        try {
            $otpService = new \App\Services\OtpService();
            $success = $otpService->sendSms($phone, $otpCode, 'password_reset');
            
            if (!$success) {
                return back()->withErrors(['phone' => 'Failed to send OTP to your phone number. Please try again.']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['phone' => 'System error: Unable to send OTP. Please try again later.']);
        }
        
        // Store phone in session for password reset
        session(['reset_phone' => $phone]);
        
        return redirect()->route('password.reset.form')->with('success', 'OTP sent successfully to your phone number!');
    }

    /**
     * Show password reset form
     */
    public function showResetPassword()
    {
        return view('auth.reset-password');
    }

    /**
     * Reset password with OTP
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'otp_code' => 'required|string|size:6',
            'password' => 'required|string|min:6|confirmed'
        ]);

        // Verify OTP first
        if (!OtpVerification::verifyOTP($request->phone, $request->otp_code)) {
            return back()->withErrors(['otp_code' => 'Invalid or expired OTP code.']);
        }

        // Update password
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->save();
            
            // Clear session
            session()->forget(['reset_phone']);
            
            return redirect()->route('login_form')->with('success', 'Password reset successfully! Please login.');
        }

        return back()->withErrors(['phone' => 'Something went wrong. Please try again.']);
    }
}
