@extends('layouts.app')

@section('title', 'Register - '.($site['site_name'] ?? 'Oronno Plants'))

@push('styles')
<link rel="stylesheet" href="{{ asset('css/mobile-register.css') }}">
@endpush

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
<div class="w-full max-w-md">

{{-- Brand --}}
<div class="text-center mb-8">
    <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
        <img src="{{ asset('images/footer/logo.png') }}" 
             alt="{{ $site['site_name'] ?? 'Oronno Plants' }}" 
             class="w-14 h-14 object-contain">
        <span class="text-2xl font-extrabold text-gray-800">{{ $site['site_name'] ?? 'Oronno Plants' }}</span>
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
<div class="firebase-auth-container" style="box-shadow:none;border:none;padding:0;background:transparent;">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-extrabold text-gray-900 mb-1">Create Your Account</h1>
        <p class="text-gray-500 text-sm">Register with your mobile number</p>
    </div>

    <div class="error-message" id="errorMessage"></div>
    <div class="success-message" id="successMessage"></div>

    <!-- Registration Form -->
    <form id="phoneRegistrationForm" style="display: block;">
        @csrf
        <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" class="form-input" placeholder="Enter your first name" required>
        </div>

        <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" class="form-input" placeholder="Enter your last name" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <div class="phone-input-group">
                <div class="phone-prefix">+880</div>
                <input type="tel" id="phone" class="form-input" placeholder="1XXXXXXXXX" maxlength="10" required>
            </div>
            <small style="color: var(--text-secondary); font-size: 12px; margin-top: 5px; display: block;">Enter 10 digits (e.g., 1712345678)</small>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" class="form-input" placeholder="Create a password (min 8 characters)" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn-primary" id="registerBtn">
                <span class="spinner" style="display: none;"></span> Send OTP
            </button>
        </div>
    </form>

    <!-- OTP Verification Section -->
    <div class="otp-section" id="otpSection">
        <p style="text-align: center; color: var(--text-secondary); margin-bottom: 15px;">
            Enter the 6-digit OTP sent to your phone
        </p>
        
        <div class="resend-timer">
            <span>OTP expires in: </span>
            <span id="otpTimer" class="timer">2:00</span>
        </div>
        
        <input type="text" id="otpCode" class="otp-input" placeholder="000000" maxlength="6">
        
        <div class="form-group">
            <button type="button" class="btn-success" id="verifyOtpBtn" onclick="verifyOTP()">
                <span class="spinner" style="display: none;"></span> Verify & Create Account
            </button>
        </div>

        <div class="form-group">
            <button type="button" class="btn-secondary" id="resendOtpBtn" onclick="resendOTP()" style="display: none;">
                <span class="spinner" style="display: none;"></span> Resend OTP
            </button>
        </div>
    </div>

    <div class="mt-6 text-center">
        <p class="text-gray-600 text-sm">Already have an account? <a href="{{ route('login_form') }}" class="text-green-600 font-bold hover:text-green-700">Sign In <i class="fas fa-arrow-right text-xs"></i></a></p>
    </div>
</div>
</div>
</div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/mobile-register.js') }}"></script>
@endpush
