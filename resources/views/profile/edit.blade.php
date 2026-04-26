@extends('layouts.app')

@section('title', 'Edit Profile - '.($site['site_name'] ?? 'Oronno Plants'))

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}">
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="bg-white border-b border-gray-100 py-3">
    <div class="container mx-auto px-6">
        <nav class="flex text-sm text-gray-500 gap-2 items-center">
            <a href="{{ route('home') }}" class="hover:text-green-600"><i class="fas fa-home mr-1"></i>Home</a>
            <span>/</span>
            <a href="{{ route('profile') }}" class="hover:text-green-600">My Profile</a>
            <span>/</span>
            <span class="text-gray-800 font-medium">Edit</span>
        </nav>
    </div>
</div>

<div class="min-h-screen bg-gray-50 py-10">
    <div class="container mx-auto px-6 max-w-3xl">
        <div class="mb-6">
            <h1 class="text-3xl font-extrabold text-gray-900">Edit Profile</h1>
            <p class="text-gray-500 mt-1">Update your personal information and delivery address.</p>
        </div>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-4 mb-6">
            <div class="flex items-start gap-3">
                <i class="fas fa-exclamation-circle mt-0.5 flex-shrink-0"></i>
                <ul class="text-sm space-y-1">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        </div>
        @endif

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-5 py-4 mb-6 flex items-center gap-3">
            <i class="fas fa-check-circle flex-shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Profile Picture --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5"><i class="fas fa-camera mr-2 text-green-500"></i>Profile Picture</h3>
                <div class="flex items-center gap-6">
                    <div id="preview-wrapper">
                        @if($user->profile_picture)
                            <img id="img-preview" src="{{ asset('images/profile_pictures/' . $user->profile_picture) }}" alt="Profile"
                                 class="w-24 h-24 rounded-full object-cover border-4 border-green-100 shadow">
                        @else
                            <div id="img-preview" class="w-24 h-24 rounded-full bg-green-100 border-4 border-green-50 flex items-center justify-center shadow">
                                <i class="fas fa-user text-green-400 text-4xl"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <label for="profile_picture"
                               class="cursor-pointer bg-green-50 hover:bg-green-100 text-green-700 font-semibold px-4 py-2 rounded-xl text-sm transition-colors border border-green-200 inline-flex items-center gap-2">
                            <i class="fas fa-upload"></i> Choose Photo
                        </label>
                        <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="hidden">
                        <p class="text-gray-400 text-xs mt-2">Max 2MB. JPEG, PNG, JPG, GIF</p>
                    </div>
                </div>
            </div>

            {{-- Personal Info --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5"><i class="fas fa-user mr-2 text-blue-500"></i>Personal Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">First Name *</label>
                        <input type="text" name="fname" value="{{ old('fname', $user->fname) }}" required placeholder="First name"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all @error('fname') border-red-400 @enderror">
                        @error('fname')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Last Name *</label>
                        <input type="text" name="lname" value="{{ old('lname', $user->lname) }}" required placeholder="Last name"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all @error('lname') border-red-400 @enderror">
                        @error('lname')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" required placeholder="01712345678"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all @error('phone') border-red-400 @enderror">
                        @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="your@email.com"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all @error('email') border-red-400 @enderror">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Delivery Address --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5"><i class="fas fa-map-marker-alt mr-2 text-red-500"></i>Delivery Address</h3>
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Street Address</label>
                        <input type="text" name="address" value="{{ old('address', $user->address) }}" placeholder="House no, road, area"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">City</label>
                            <input type="text" name="city" value="{{ old('city', $user->city) }}" placeholder="e.g. Dhaka"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Postal Code</label>
                            <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" placeholder="e.g. 1212"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Password Change --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5"><i class="fas fa-lock mr-2 text-orange-500"></i>Change Password</h3>
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Current Password</label>
                        <input type="password" name="current_password" placeholder="Enter your current password"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all">
                        @error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                            <input type="password" name="new_password" placeholder="Enter new password"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all">
                            @error('new_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" placeholder="Confirm new password"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all">
                            @error('new_password_confirmation')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <p class="text-gray-400 text-xs">Leave blank if you don't want to change your password</p>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-4">
                <button type="submit"
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-xl transition-colors shadow-md flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="{{ route('profile') }}"
                   class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3.5 rounded-xl transition-colors text-center flex items-center justify-center gap-2">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/profile-edit.js') }}"></script>
<script>
document.getElementById('profile_picture').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function (ev) {
        const wrapper = document.getElementById('preview-wrapper');
        wrapper.innerHTML = `<img id="img-preview" src="${ev.target.result}" class="w-24 h-24 rounded-full object-cover border-4 border-green-100 shadow">`;
    };
    reader.readAsDataURL(file);
});
</script>
@endpush
