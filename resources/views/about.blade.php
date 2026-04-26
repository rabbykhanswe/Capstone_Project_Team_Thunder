@extends('layouts.app')

@section('title', 'About Us - '.($site['site_name'] ?? 'Oronno Plants'))

@push('styles')
<link rel="stylesheet" href="{{ asset('css/about.css') }}">
@endpush

@section('content')

{{-- Hero --}}
<section class="bg-gradient-to-br from-green-700 to-emerald-500 text-white py-20">
    <div class="container mx-auto px-6 text-center">
        <span class="inline-block bg-white bg-opacity-20 text-white text-sm font-semibold px-4 py-1 rounded-full mb-4"><i class="fas fa-leaf mr-1"></i> Our Story</span>
        <h1 class="text-5xl font-extrabold mb-4">About {{ $site['site_name'] ?? 'Oronno Plants' }}</h1>
        <p class="text-xl text-green-100 max-w-2xl mx-auto">We're on a mission to bring nature closer to every home in Bangladesh — one plant at a time.</p>
    </div>
</section>

{{-- Breadcrumb --}}
<div class="bg-white border-b border-gray-100 py-3">
    <div class="container mx-auto px-6">
        <nav class="flex text-sm text-gray-500 gap-2 items-center">
            <a href="{{ route('home') }}" class="hover:text-green-600 transition-colors"><i class="fas fa-home mr-1"></i>Home</a>
            <span>/</span>
            <span class="text-gray-800 font-medium">About</span>
        </nav>
    </div>
</div>

{{-- Mission & Story --}}
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">Who We Are</span>
                <h2 class="text-4xl font-extrabold text-gray-900 mt-2 mb-6">Passionate About Plants, Committed to You</h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    {{ $site['about_text'] ?? "Oronno Plants is Bangladesh's trusted digital nursery, bringing fresh plants and gardening joy to every home since 2024." }}
                </p>
                <p class="text-gray-600 text-lg leading-relaxed mb-8">
                    We work directly with the best nurseries across Bangladesh to source healthy, premium-quality plants. Each plant is inspected, cared for, and packaged by our expert team to ensure it arrives at your doorstep in perfect condition.
                </p>
                <div class="flex flex-wrap gap-4">
                    <div class="flex items-center gap-2 text-green-700 font-semibold"><i class="fas fa-check-circle text-green-500"></i> Expert-Curated Selection</div>
                    <div class="flex items-center gap-2 text-green-700 font-semibold"><i class="fas fa-check-circle text-green-500"></i> Eco-Friendly Packaging</div>
                    <div class="flex items-center gap-2 text-green-700 font-semibold"><i class="fas fa-check-circle text-green-500"></i> Direct from Nurseries</div>
                    <div class="flex items-center gap-2 text-green-700 font-semibold"><i class="fas fa-check-circle text-green-500"></i> 7-Day Health Guarantee</div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-green-50 rounded-2xl p-8 text-center">
                    <div class="text-5xl font-extrabold text-green-600 mb-2">500+</div>
                    <div class="text-gray-600 font-medium">Plant Varieties</div>
                </div>
                <div class="bg-blue-50 rounded-2xl p-8 text-center">
                    <div class="text-5xl font-extrabold text-blue-600 mb-2">10K+</div>
                    <div class="text-gray-600 font-medium">Happy Customers</div>
                </div>
                <div class="bg-yellow-50 rounded-2xl p-8 text-center">
                    <div class="text-5xl font-extrabold text-yellow-600 mb-2">4.9 <i class="fas fa-star text-4xl"></i></div>
                    <div class="text-gray-600 font-medium">Average Rating</div>
                </div>
                <div class="bg-purple-50 rounded-2xl p-8 text-center">
                    <div class="text-5xl font-extrabold text-purple-600 mb-2">5+</div>
                    <div class="text-gray-600 font-medium">Years of Service</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Values --}}
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">What We Stand For</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-2 mb-4">Our Core Values</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['fas fa-leaf','green','Sustainability','We source plants responsibly and use eco-friendly packaging to minimize our environmental impact on the planet.'],
                ['fas fa-heart','red','Customer First','Your satisfaction is our priority. We provide detailed care guides, expert advice, and a health guarantee on every plant.'],
                ['fas fa-star','yellow','Quality Always','Every single plant is hand-inspected before being shipped. We never compromise on quality, no matter the order size.']
            ] as $value)
            <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow border border-gray-100 text-center">
                <div class="w-16 h-16 bg-{{ $value[1] }}-100 rounded-full flex items-center justify-center mx-auto mb-5">
                    <i class="{{ $value[0] }} text-{{ $value[1] }}-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">{{ $value[2] }}</h3>
                <p class="text-gray-500 leading-relaxed">{{ $value[3] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Team --}}
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">The People Behind</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-2 mb-4">Meet Our Team</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Our passionate team of plant lovers, botanists, and customer care specialists work every day to bring you the best plant experience.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 max-w-3xl mx-auto">

            {{-- Md. Rabby Khan --}}
            <div class="text-center group">
                <div class="w-36 h-36 mx-auto mb-4 rounded-full overflow-hidden border-4 border-green-300 shadow-md group-hover:border-green-500 transition-colors">
                    <img src="{{ asset('images/rabby.png') }}" alt="Md. Rabby Khan"
                         class="w-full h-full object-cover object-top"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div class="w-full h-full bg-green-100 items-center justify-center hidden">
                        <i class="fas fa-user-tie text-green-600 text-5xl"></i>
                    </div>
                </div>
                <h3 class="font-bold text-gray-800 text-lg">Md. Rabby Khan</h3>
                <div class="text-green-600 font-semibold text-sm mb-2">
                    <i class="fas fa-crown mr-1 text-yellow-500"></i> CEO &amp; Founder
                </div>
                <p class="text-gray-500 text-sm">Visionary behind {{ $site['site_name'] ?? 'Oronno Plants' }}, leading the mission to bring nature into every Bangladeshi home.</p>
            </div>

            {{-- Junayed Mithu --}}
            <div class="text-center group">
                <div class="w-36 h-36 mx-auto mb-4 rounded-full overflow-hidden border-4 border-blue-300 shadow-md group-hover:border-blue-500 transition-colors">
                    <img src="{{ asset('images/junayed.jpeg') }}" alt="Junayed Mithu"
                         class="w-full h-full object-cover object-top"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div class="w-full h-full bg-blue-100 items-center justify-center hidden">
                        <i class="fas fa-user-tie text-blue-600 text-5xl"></i>
                    </div>
                </div>
                <h3 class="font-bold text-gray-800 text-lg">Junayed Mithu</h3>
                <div class="text-green-600 font-semibold text-sm mb-2">
                    <i class="fas fa-briefcase mr-1 text-blue-500"></i> Chief Executive Officer
                </div>
                <p class="text-gray-500 text-sm">Drives business growth and operations, ensuring {{ $site['site_name'] ?? 'Oronno Plants' }} delivers excellence every day.</p>
            </div>

            {{-- Md Bishal --}}
            <div class="text-center group">
                <div class="w-36 h-36 mx-auto mb-4 rounded-full overflow-hidden border-4 border-purple-300 shadow-md group-hover:border-purple-500 transition-colors">
                    <img src="{{ asset('images/bishal.jpeg') }}" alt="Md Bishal"
                         class="w-full h-full object-cover object-top"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div class="w-full h-full bg-purple-100 items-center justify-center hidden">
                        <i class="fas fa-user-tie text-purple-600 text-5xl"></i>
                    </div>
                </div>
                <h3 class="font-bold text-gray-800 text-lg">Md Bishal</h3>
                <div class="text-green-600 font-semibold text-sm mb-2">
                    <i class="fas fa-seedling mr-1 text-purple-500"></i> Co-Founder
                </div>
                <p class="text-gray-500 text-sm">Co-founder and core team member, contributing to the growth and vision of {{ $site['site_name'] ?? 'Oronno Plants' }}.</p>
            </div>

        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 bg-gradient-to-r from-green-700 to-emerald-500 text-white text-center">
    <div class="container mx-auto px-6 max-w-2xl">
        <h2 class="text-4xl font-extrabold mb-4">Start Your Plant Journey Today</h2>
        <p class="text-green-100 text-lg mb-8">Explore our collection of 500+ plants and find the perfect green companion for your home or office.</p>
        <a href="{{ route('products') }}" class="inline-block bg-white text-green-700 hover:bg-yellow-300 hover:text-green-900 font-extrabold px-10 py-4 rounded-full transition-all duration-300 shadow-lg text-lg">
            <i class="fas fa-leaf mr-2"></i>Shop All Plants
        </a>
    </div>
</section>

@endsection
