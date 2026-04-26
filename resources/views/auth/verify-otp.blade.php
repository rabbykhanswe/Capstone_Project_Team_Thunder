@extends('layouts.app')

@section('title', 'Verify OTP')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/verify-otp.css') }}">
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
                <span class="text-2xl font-extrabold text-gray-800">Oronno <span class="text-green-600">Plants</span></span>
            </a>
            <div class="mt-6 w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-mobile-alt text-green-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Verify Your Phone</h1>
            <p class="text-gray-500">Enter the 6-digit code sent to your phone number.</p>
        </div>

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

            <form action="{{ route('otp.verify') }}" method="POST">
                @csrf
                <input type="hidden" name="phone" value="{{ session('phone') }}">

                <div class="flex gap-2 justify-between mb-6" id="otp-boxes">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-xl focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all" name="otp_1" required>
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-xl focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all" name="otp_2" required>
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-xl focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all" name="otp_3" required>
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-xl focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all" name="otp_4" required>
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-xl focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all" name="otp_5" required>
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-xl focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all" name="otp_6" required>
                </div>

                <div class="text-center mb-5">
                    <span class="text-gray-500 text-sm">Time remaining: </span>
                    <span id="timer" class="text-green-600 font-bold text-sm">2:00</span>
                </div>

                <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-xl transition-colors shadow-md flex items-center justify-center gap-2">
                    <i class="fas fa-check-circle"></i> Verify OTP
                </button>
            </form>

            <div class="mt-5 text-center">
                <p class="text-gray-500 text-sm">Didn't receive the code?
                    <a href="{{ route('otp.send.form') }}" class="text-green-600 font-semibold hover:text-green-700 ml-1">Resend OTP</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
// Timer functionality
let timeLeft = 120; // 2 minutes in seconds
const timerElement = document.getElementById('timer');

function updateTimer() {
    if (timeLeft <= 0) {
        timerElement.textContent = 'Expired';
        return;
    }
    
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    timeLeft--;
}

// Start timer
const timerInterval = setInterval(updateTimer, 1000);

// Auto-submit when all 6 OTP fields are filled
document.addEventListener('DOMContentLoaded', function() {
    const otpInputs = document.querySelectorAll('.otp-input');
    
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', function() {
            if (this.value.length === 1) {
                if (index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            }
        });
        
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && this.value === '') {
                if (index > 0) {
                    otpInputs[index - 1].focus();
                }
            }
        });
    });
});
</script>
@endsection

