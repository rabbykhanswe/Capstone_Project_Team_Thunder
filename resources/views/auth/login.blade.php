@extends('layouts.app')

@section('title', 'Login - '.($site['site_name'] ?? 'Oronno Plants'))

@push('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">

        {{-- Logo / Brand --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                <img src="{{ asset('images/footer/logo.png') }}" 
                     alt="{{ $site['site_name'] ?? 'Oronno Plants' }}" 
                     class="w-14 h-14 object-contain">
                <span class="text-2xl font-extrabold text-gray-800">{{ $site['site_name'] ?? 'Oronno Plants' }}</span>
            </a>
            <h1 class="text-3xl font-extrabold text-gray-900 mt-6 mb-2">Welcome back!</h1>
            <p class="text-gray-500">Sign in to your account to continue</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            {{-- Alerts --}}
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-circle mt-0.5 flex-shrink-0"></i>
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 flex items-center gap-3">
                <i class="fas fa-check-circle flex-shrink-0"></i>
                <span class="text-sm">{{ session('success') }}</span>
            </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-phone mr-1 text-green-500"></i> Phone Number
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
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-lock mr-1 text-green-500"></i> Password
                        </label>
                        <a href="{{ route('password.forgot') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">
                            Forgot password?
                        </a>
                    </div>
                    <div class="relative">
                        <input type="password" id="password" name="password" placeholder="Enter your password" required
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 pr-12 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all text-gray-800 @error('password') border-red-400 @enderror">
                        <button type="button" id="toggle-password"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-xl transition-colors shadow-md flex items-center justify-center gap-2 text-base">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-4 my-6">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-xs text-gray-400 font-medium">OR</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            {{-- Register link --}}
            <p class="text-center text-gray-600 text-sm">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-green-600 hover:text-green-700 font-bold ml-1">
                    Create one free <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </p>
        </div>

        {{-- Trust badges --}}
        <div class="flex justify-center gap-6 mt-6 text-xs text-gray-400">
            <span><i class="fas fa-shield-alt mr-1 text-green-400"></i>Secure Login</span>
            <span><i class="fas fa-lock mr-1 text-green-400"></i>SSL Encrypted</span>
            <span><i class="fas fa-leaf mr-1 text-green-400"></i>Trusted Store</span>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('toggle-password').addEventListener('click', function () {
    const pw = document.getElementById('password');
    const icon = this.querySelector('i');
    if (pw.type === 'password') {
        pw.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        pw.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
});
</script>
@endpush
