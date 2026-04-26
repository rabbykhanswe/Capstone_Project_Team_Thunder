@extends('layouts.app')

@section('title', 'Products')

@push('styles')
<link href="{{ asset('css/products.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/products.js') }}"></script>
@endpush

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-green-400 to-green-600 text-white py-16 mb-8">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Our Plant Collection</h1>
            <p class="text-xl mb-8">Discover our premium selection of indoor and outdoor plants, succulents, and gardening supplies</p>
            
            <!-- Quick Search -->
            <div class="max-w-2xl mx-auto">
                <form action="{{ route('search') }}" method="GET" class="relative">
                    <input type="text" 
                           name="q" 
                           placeholder="Search for plants, succulents, or gardening tools..." 
                           class="w-full px-6 py-4 pr-12 rounded-full text-gray-800 text-lg focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-50">
                    <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-green-500 text-white px-6 py-3 rounded-full hover:bg-green-600 transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Category Pills -->
<div class="container mx-auto px-4 mb-8">
    <div class="flex flex-wrap justify-center gap-2">
        <a href="{{ route('products') }}" class="category-pill px-6 py-2 rounded-full {{ !request('category') ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition-colors">
            All Plants
        </a>
        @foreach($categories as $category)
            <a href="{{ route('products', ['category' => $category->name]) }}" 
               class="category-pill px-6 py-2 rounded-full {{ request('category') == $category->name ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition-colors">
                {{ ucfirst($category->name) }}
            </a>
        @endforeach
    </div>
</div>

    <!-- Filters Sidebar -->
<div class="container mx-auto px-4">
    <div class="flex flex-col lg:flex-row gap-8">
        <div class="lg:w-1/4">
            <div class="bg-white p-6 rounded-lg shadow-lg sticky top-4">
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <i class="fas fa-filter mr-2 text-green-500"></i>
                    Filters
                </h3>
                
                <form id="filter-form" class="space-y-4">
                    <!-- Environment Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-home mr-1 text-gray-400"></i>
                            Environment
                        </label>
                        <select name="environment" class="w-full px-3 py-2 border border-gray-300 rounded-md filter-select focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="">All Environments</option>
                            @foreach($environments as $environment)
                                <option value="{{ $environment }}" {{ request('environment') == $environment ? 'selected' : '' }}>
                                    {{ ucfirst($environment) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Plant Type Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-leaf mr-1 text-gray-400"></i>
                            Plant Type
                        </label>
                        <select name="plant_type" class="w-full px-3 py-2 border border-gray-300 rounded-md filter-select focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="">All Types</option>
                            @foreach($plantTypes as $type)
                                <option value="{{ $type }}" {{ request('plant_type') == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tag mr-1 text-gray-400"></i>
                            Category
                        </label>
                        <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md filter-select focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->name }}" {{ request('category') == $category->name ? 'selected' : '' }}>
                                    {{ ucfirst($category->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-dollar-sign mr-1 text-gray-400"></i>
                            Price Range
                        </label>
                        <div class="flex space-x-2">
                            <input type="number" 
                                   name="min_price" 
                                   value="{{ request('min_price', 0) }}" 
                                   min="0" 
                                   step="0.01"
                                   placeholder="Min"
                                   class="w-1/2 px-3 py-2 border border-gray-300 rounded-md filter-input focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <input type="number" 
                                   name="max_price" 
                                   value="{{ request('max_price', 999999) }}" 
                                   min="0" 
                                   step="0.01"
                                   placeholder="Max"
                                   class="w-1/2 px-3 py-2 border border-gray-300 rounded-md filter-input focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="pt-4 space-y-2 border-t">
                        <button type="button" id="apply-filters" class="w-full bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors">
                            <i class="fas fa-check mr-2"></i>Apply Filters
                        </button>
                        <button type="button" id="clear-filters" class="w-full bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition-colors">
                            <i class="fas fa-times mr-2"></i>Clear Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="lg:w-3/4">
            <!-- Results Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 bg-white p-4 rounded-lg shadow">
                <div class="mb-4 sm:mb-0">
                    <h2 class="text-xl font-semibold text-gray-800">
                        {{ $plants->count() }} Plants Found
                        @if(request('category'))
                            <span class="text-sm text-gray-500">in {{ ucfirst(request('category')) }}</span>
                        @endif
                    </h2>
                    <p class="text-gray-600 text-sm">Browse our premium collection</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Sort by:</span>
                        <select class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option>Featured</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Name: A to Z</option>
                            <option>Newest First</option>
                        </select>
                    </div>
                    <div class="flex space-x-2">
                        <button class="p-2 border border-gray-300 rounded hover:bg-gray-100">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button class="p-2 border border-gray-300 rounded hover:bg-gray-100">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div id="products-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($plants as $plant)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 product-card">
                        <!-- Product Image Section -->
                        <div class="relative group">
                            @if($plant->image)
                                <img src="{{ asset('images/plants/' . $plant->image) }}" 
                                     alt="{{ $plant->name }}" 
                                     class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-64 bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                                    <div class="text-center">
                                        <i class="fas fa-leaf text-green-400 text-4xl mb-2"></i>
                                        <span class="text-gray-500">No Image</span>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Stock Badge -->
                            @if($plant->stock_count > 0)
                                <span class="absolute top-3 right-3 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    <i class="fas fa-check-circle mr-1"></i>In Stock
                                </span>
                            @else
                                <span class="absolute top-3 right-3 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    <i class="fas fa-times-circle mr-1"></i>Out of Stock
                                </span>
                            @endif

                            <!-- Quick Actions Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <div class="flex space-x-2">
                                    @if(auth()->check())
                                        <button class="wishlist-btn bg-white text-red-500 p-3 rounded-full hover:bg-red-50 transform scale-0 group-hover:scale-100 transition-transform duration-300"
                                                data-plant-id="{{ $plant->id }}">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    @endif
                                    <button class="quick-view bg-white text-blue-500 p-3 rounded-full hover:bg-blue-50 transform scale-0 group-hover:scale-100 transition-transform duration-300"
                                            data-plant-id="{{ $plant->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="p-5">
                            <!-- Category Tags -->
                            <div class="flex flex-wrap gap-1 mb-3">
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">
                                    <i class="fas fa-home mr-1 text-xs"></i>{{ ucfirst($plant->environment) }}
                                </span>
                                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full font-medium">
                                    <i class="fas fa-leaf mr-1 text-xs"></i>{{ ucfirst($plant->plant_type) }}
                                </span>
                                <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded-full font-medium">
                                    {{ ucfirst($plant->category) }}
                                </span>
                            </div>
                            
                            <!-- Product Name and Description -->
                            <h3 class="font-bold text-lg mb-2 text-gray-800 line-clamp-1">{{ $plant->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $plant->description ?: 'Beautiful plant perfect for your home or garden' }}</p>
                            
                            <!-- Care Requirements Preview -->
                            @if($plant->sunlight_requirements || $plant->water_requirements)
                                <div class="mb-4 text-xs text-gray-500 space-y-1">
                                    @if($plant->sunlight_requirements)
                                        <div class="flex items-center">
                                            <i class="fas fa-sun text-yellow-400 mr-2"></i>
                                            <span>{{ Str::limit($plant->sunlight_requirements, 30) }}</span>
                                        </div>
                                    @endif
                                    @if($plant->water_requirements)
                                        <div class="flex items-center">
                                            <i class="fas fa-tint text-blue-400 mr-2"></i>
                                            <span>{{ Str::limit($plant->water_requirements, 30) }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            
                            <!-- Price and Stock Info -->
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <span class="text-2xl font-bold text-green-600">{{ $plant->formatted_price }}</span>
                                    @if($plant->stock_count > 0 && $plant->stock_count <= 5)
                                        <span class="text-xs text-orange-500 block">Only {{ $plant->stock_count }} left!</span>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <span class="text-xs text-gray-500">{{ $plant->stock_count }} available</span>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <a href="{{ route('products.show', $plant->id) }}" 
                                   class="flex-1 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors text-sm font-medium text-center">
                                    <i class="fas fa-info-circle mr-1"></i>Details
                                </a>
                                <button class="flex-1 add-to-cart bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors text-sm font-medium"
                                        data-plant-id="{{ $plant->id }}"
                                        {{ $plant->stock_count < 1 ? 'disabled' : '' }}>
                                    <i class="fas fa-shopping-cart mr-1"></i>
                                    {{ $plant->stock_count < 1 ? 'Out of Stock' : 'Add to Cart' }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $plants->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
