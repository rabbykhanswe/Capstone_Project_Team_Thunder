@extends('layouts.app')

@section('title', 'My Profile - '.($site['site_name'] ?? 'Oronno Plants'))

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile-index.css') }}">
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="bg-white border-b border-gray-100 py-3">
    <div class="container mx-auto px-6">
        <nav class="flex text-sm text-gray-500 gap-2 items-center">
            <a href="{{ route('home') }}" class="hover:text-green-600 transition-colors"><i class="fas fa-home mr-1"></i>Home</a>
            <span>/</span>
            <span class="text-gray-800 font-medium">My Profile</span>
        </nav>
    </div>
</div>

<div class="min-h-screen bg-gray-50 py-10">
    <div class="container mx-auto px-6 max-w-5xl">

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-5 py-4 mb-6 flex items-center gap-3">
            <i class="fas fa-check-circle flex-shrink-0 text-green-500"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Sidebar Card --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    {{-- Cover --}}
                    <div class="h-24 bg-gradient-to-r from-green-500 to-emerald-600"></div>

                    {{-- Avatar --}}
                    <div class="px-6 pb-6 -mt-12 text-center">
                        <div class="inline-block relative">
                            @if(auth()->user()->profile_picture)
                                <img src="{{ asset('images/profile_pictures/' . auth()->user()->profile_picture) }}"
                                     alt="Profile Picture"
                                     class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-24 h-24 rounded-full bg-green-100 border-4 border-white shadow-lg flex items-center justify-center mx-auto" style="display:none;">
                                    <i class="fas fa-user text-green-500 text-4xl"></i>
                                </div>
                            @else
                                <div class="w-24 h-24 rounded-full bg-green-100 border-4 border-white shadow-lg flex items-center justify-center mx-auto">
                                    <i class="fas fa-user text-green-500 text-4xl"></i>
                                </div>
                            @endif
                        </div>

                        <h2 class="text-xl font-extrabold text-gray-900 mt-3">{{ auth()->user()->fname }} {{ auth()->user()->lname }}</h2>
                        <p class="text-gray-500 text-sm mb-1">{{ auth()->user()->email ?? 'No email set' }}</p>
                        <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">
                            <i class="fas fa-leaf mr-1"></i>Plant Lover
                        </span>

                        <div class="mt-5 space-y-2">
                            <a href="{{ route('profile.edit') }}"
                               class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded-xl transition-colors text-sm">
                                <i class="fas fa-edit mr-2"></i>Edit Profile
                            </a>
                            <a href="{{ route('wishlist') }}"
                               class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-xl transition-colors text-sm">
                                <i class="fas fa-heart mr-2 text-red-500"></i>My Wishlist
                            </a>
                            <a href="{{ route('cart') }}"
                               class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-xl transition-colors text-sm">
                                <i class="fas fa-shopping-cart mr-2 text-blue-500"></i>My Cart
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Profile Info --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Personal Info --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-bold text-gray-900"><i class="fas fa-user-circle mr-2 text-green-500"></i>Personal Information</h3>
                        <a href="{{ route('profile.edit') }}" class="text-sm text-green-600 hover:text-green-700 font-semibold">
                            <i class="fas fa-pencil-alt mr-1"></i>Edit
                        </a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">First Name</div>
                            <div class="text-gray-800 font-semibold">{{ auth()->user()->fname ?: '—' }}</div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Last Name</div>
                            <div class="text-gray-800 font-semibold">{{ auth()->user()->lname ?: '—' }}</div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Phone Number</div>
                            <div class="text-gray-800 font-semibold flex items-center gap-2">
                                <i class="fas fa-phone text-green-500 text-xs"></i>
                                {{ auth()->user()->phone ?: '—' }}
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Email Address</div>
                            <div class="text-gray-800 font-semibold flex items-center gap-2">
                                <i class="fas fa-envelope text-blue-500 text-xs"></i>
                                {{ auth()->user()->email ?: '—' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Address Info --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg font-bold text-gray-900"><i class="fas fa-map-marker-alt mr-2 text-red-500"></i>Delivery Address</h3>
                        <a href="{{ route('profile.edit') }}" class="text-sm text-green-600 hover:text-green-700 font-semibold">
                            <i class="fas fa-pencil-alt mr-1"></i>Edit
                        </a>
                    </div>
                    @if(auth()->user()->address || auth()->user()->city || auth()->user()->postal_code)
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <div class="bg-gray-50 rounded-xl p-4 sm:col-span-3">
                            <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Street Address</div>
                            <div class="text-gray-800 font-semibold">{{ auth()->user()->address ?: '—' }}</div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">City</div>
                            <div class="text-gray-800 font-semibold">{{ auth()->user()->city ?: '—' }}</div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Postal Code</div>
                            <div class="text-gray-800 font-semibold">{{ auth()->user()->postal_code ?: '—' }}</div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Country</div>
                            <div class="text-gray-800 font-semibold">Bangladesh</div>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-6 text-gray-400">
                        <i class="fas fa-map-marker-alt text-4xl mb-3 block text-gray-200"></i>
                        <p class="text-sm">No delivery address added yet.</p>
                        <a href="{{ route('profile.edit') }}" class="text-green-600 text-sm font-semibold mt-2 inline-block hover:underline">Add Address</a>
                    </div>
                    @endif
                </div>

                {{-- Account Actions --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4"><i class="fas fa-cog mr-2 text-gray-500"></i>Account Actions</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('profile.edit') }}"
                           class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-xl transition-colors text-sm">
                            <i class="fas fa-edit mr-2"></i>Edit Profile
                        </a>
                        <a href="{{ route('password.forgot') }}"
                           class="bg-yellow-100 hover:bg-yellow-200 text-yellow-800 font-semibold px-5 py-2.5 rounded-xl transition-colors text-sm">
                            <i class="fas fa-key mr-2"></i>Change Password
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                    class="bg-red-100 hover:bg-red-200 text-red-700 font-semibold px-5 py-2.5 rounded-xl transition-colors text-sm">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/profile-index.js') }}"></script>
@endpush