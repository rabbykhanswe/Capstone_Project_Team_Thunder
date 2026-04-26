@extends('layouts.app')

@section('title', 'Search Plants')

@push('styles')
<link href="{{ asset('css/products.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/products.js') }}"></script>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Search Plants</h1>
        
        <!-- Search Form -->
        <form action="{{ route('search') }}" method="GET" class="mb-6">
            <div class="relative">
                <input type="text" 
                       name="q" 
                       value="{{ $query }}" 
                       placeholder="Search for plants by name, category, or description..." 
                       class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                       id="search-input">
                <button type="submit" class="absolute right-2 top-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <!-- Filters -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h3 class="text-lg font-semibold mb-4">Filters</h3>
            <form action="{{ route('search') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="hidden" name="q" value="{{ $query }}">
                
                <!-- Environment Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Environment</label>
                    <select name="environment" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Plant Type</label>
                    <select name="plant_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Price Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Min Price</label>
                    <input type="number" 
                           name="min_price" 
                           value="{{ request('min_price', 0) }}" 
                           min="0" 
                           step="0.01"
                           placeholder="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Max Price</label>
                    <input type="number" 
                           name="max_price" 
                           value="{{ request('max_price', 999999) }}" 
                           min="0" 
                           step="0.01"
                           placeholder="999999"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Search Results -->
    @if($query || request()->hasAny(['environment', 'plant_type', 'category', 'min_price', 'max_price']))
        <div class="mb-4">
            <p class="text-gray-600">
                Found {{ $plants->total() }} plants
                @if($query) for "{{ $query }}"@endif
            </p>
        </div>

        @if($plants->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($plants as $plant)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="relative">
                            @if($plant->image)
                                <img src="{{ asset('images/plants/' . $plant->image) }}" 
                                     alt="{{ $plant->name }}" 
                                     class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">No Image</span>
                                </div>
                            @endif
                            
                            @if($plant->stock_count > 0)
                                <span class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded text-xs">
                                    In Stock
                                </span>
                            @else
                                <span class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded text-xs">
                                    Out of Stock
                                </span>
                            @endif
                        </div>

                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-2">{{ $plant->name }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ $plant->category }}</p>
                            <p class="text-green-600 font-bold mb-3">{{ $plant->formatted_price }}</p>
                            
                            <div class="flex justify-between items-center">
                                <a href="{{ route('products.show', $plant->id) }}" 
                                   class="text-blue-500 hover:text-blue-700 text-sm">
                                    View Details
                                </a>
                                <button class="add-to-cart bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600"
                                        data-plant-id="{{ $plant->id }}">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $plants->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500 text-lg">No plants found matching your criteria.</p>
                <a href="{{ route('products') }}" class="text-blue-500 hover:text-blue-700 mt-4 inline-block">
                    Browse all plants
                </a>
            </div>
        @endif
    @else
        <div class="text-center py-8">
            <p class="text-gray-500 text-lg">Enter a search term or apply filters to find plants.</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
// Autocomplete functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    
    searchInput.addEventListener('input', function() {
        const query = this.value;
        
        if (query.length < 2) {
            return;
        }
        
        fetch(`/api/autocomplete?term=${query}`)
            .then(response => response.json())
            .then(suggestions => {
                // Display suggestions (you can implement a dropdown here)
                console.log('Suggestions:', suggestions);
            })
            .catch(error => console.error('Error:', error));
    });
});

// Add to cart functionality
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('add-to-cart')) {
        e.preventDefault();
        
        const plantId = e.target.dataset.plantId;
        const button = e.target;
        
        fetch(`/cart/add/${plantId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update cart count
                updateCartCount(data.cart_count);
                // Show success message
                alert(data.message);
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
});

function updateCartCount(count) {
    const cartCountElement = document.querySelector('.cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = count;
    }
}
</script>
@endpush
