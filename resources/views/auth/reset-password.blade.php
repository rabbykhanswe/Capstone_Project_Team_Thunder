@extends('layouts.app')

@section('title', 'Reset Password - '.($site['site_name'] ?? 'Oronno Plants'))

@push('styles')
<link rel="stylesheet" href="{{ asset('css/reset-password.css') }}">
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">

        {{-- Brand --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 justify-center">
                <div class="w-14 h-14 bg-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-leaf text-white text-2xl"></i>
                </div>
                <span class="text-2xl font-extrabold text-gray-800">{{ $site['site_name'] ?? 'Oronno Plants' }}</span>
            </a>
            <div class="mt-6 w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-shield-alt text-blue-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Reset Password</h1>
            <p class="text-gray-500">Enter your OTP code and choose a new password</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 flex items-center gap-3">
                <i class="fas fa-check-circle flex-shrink-0"></i>
                <span class="text-sm">{{ session('success') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-circle mt-0.5 flex-shrink-0"></i>
                    <ul class="text-sm space-y-1">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            </div>
            @endif

            <form action="{{ route('password.reset') }}" method="POST" class="space-y-5" id="reset-form">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-phone mr-1 text-green-500"></i> Phone Number
                    </label>
                    <input type="text" name="phone"
                           value="{{ session('reset_phone') ?? old('phone') }}"
                           placeholder="01712345678" required
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all text-gray-800">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-key mr-1 text-green-500"></i> 6-Digit OTP Code
                    </label>
                    <div class="flex gap-2 justify-between" id="otp-boxes">
                        @for($i = 0; $i < 6; $i++)
                        <input type="text" maxlength="1" pattern="[0-9]" required
                               class="otp-digit w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-xl focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all text-gray-800">
                        @endfor
                    </div>
                    <input type="hidden" name="otp_code" id="otp_code_hidden">
                    <p class="text-gray-400 text-xs mt-2">Enter the 6-digit code sent to your phone</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock mr-1 text-green-500"></i> New Password
                    </label>
                    <input type="password" name="password" placeholder="Minimum 8 characters" required
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all text-gray-800">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock mr-1 text-green-500"></i> Confirm New Password
                    </label>
                    <input type="password" name="password_confirmation" placeholder="Re-enter new password" required
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all text-gray-800">
                </div>

                <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-xl transition-colors shadow-md flex items-center justify-center gap-2">
                    <i class="fas fa-check-circle"></i> Reset Password
                </button>
            </form>

            <div class="flex justify-between mt-6 text-sm">
                <a href="{{ route('password.forgot') }}" class="text-green-600 hover:text-green-700 font-medium">
                    <i class="fas fa-redo mr-1"></i>Resend OTP
                </a>
                <a href="{{ route('login_form') }}" class="text-gray-500 hover:text-green-600 font-medium">
                    <i class="fas fa-arrow-left mr-1"></i>Back to Login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const digits = document.querySelectorAll('.otp-digit');
    digits.forEach((input, i) => {
        input.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value && i < digits.length - 1) digits[i + 1].focus();
            document.getElementById('otp_code_hidden').value = Array.from(digits).map(d => d.value).join('');
        });
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace' && !this.value && i > 0) digits[i - 1].focus();
        });
    });
    document.getElementById('reset-form').addEventListener('submit', function () {
        document.getElementById('otp_code_hidden').value = Array.from(digits).map(d => d.value).join('');
    });
});
</script>
@endpush
