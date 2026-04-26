@extends('layouts.app')

@section('title', 'Forgot Password - '.($site['site_name'] ?? 'Oronno Plants'))

@push('styles')
<link rel="stylesheet" href="{{ asset('css/forgot-password.css') }}">
@endpush

@section('content')
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
            <div class="mt-6 w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-key text-yellow-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Forgot Password?</h1>
            <p class="text-gray-500">Enter your registered phone number and we'll send you a verification code.</p>
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
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <form action="{{ route('password.otp.send') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-phone mr-1 text-green-500"></i> Registered Phone Number
                    </label>
                    <div class="flex gap-2">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 px-4 bg-gray-100 border border-gray-300 rounded-xl text-gray-700 font-semibold">
                                +880
                            </div>
                        </div>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                               placeholder="1712345678" maxlength="10" required
                               class="flex-1 border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all text-gray-800 @error('phone') border-red-400 @enderror">
                    </div>
                    <small class="text-gray-500 text-xs mt-1 block">Enter 10 digits (e.g., 1712345678)</small>
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-xl transition-colors shadow-md flex items-center justify-center gap-2">
                    <i class="fas fa-paper-plane"></i> Send Verification Code
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login_form') }}" class="text-gray-500 hover:text-green-600 text-sm font-medium transition-colors">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/forgot-password.js') }}"></script>
@endpush
