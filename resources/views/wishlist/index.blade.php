@extends('layouts.app')

@section('title', 'My Wishlist')

@push('styles')
<link href="{{ asset('css/products.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/products.js') }}"></script>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">My Wishlist</h1>
        <p class="text-gray-600">Plants you've saved for later</p>
    </div>

    @if($wishlistItems->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($wishlistItems as $wishlistItem)
                @if(!$wishlistItem->plant) @continue @endif
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow wishlist-card">
                    <div class="relative">
                        @if($wishlistItem->plant->image)
                            <img src="{{ asset('images/plants/' . $wishlistItem->plant->image) }}" 
                                 alt="{{ $wishlistItem->plant->name }}" 
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-leaf text-gray-400 text-4xl"></i>
                            </div>
                        @endif
                        
                        <!-- Stock Status -->
                        @if($wishlistItem->plant->stock_count > 0)
                            <span class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded text-xs">
                                In Stock
                            </span>
                        @else
                            <span class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded text-xs">
                                Out of Stock
                            </span>
                        @endif

                        <!-- Remove from Wishlist Button -->
                        <button class="absolute top-2 left-2 bg-white rounded-full p-2 shadow-md hover:bg-red-50 remove-from-wishlist"
                                data-plant-id="{{ $wishlistItem->plant->id }}">
                            <i class="fas fa-heart text-red-500"></i>
                        </button>
                    </div>

                    <div class="p-4">
                        <div class="mb-2">
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                {{ ucfirst($wishlistItem->plant->environment ?? 'plant') }}
                            </span>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded ml-1">
                                {{ ucfirst($wishlistItem->plant->plant_type ?? '') }}
                            </span>
                        </div>
                        
                        <h3 class="font-semibold text-lg mb-2">{{ $wishlistItem->plant->name }}</h3>
                        <p class="text-gray-600 text-sm mb-3">{{ Str::limit($wishlistItem->plant->description ?? '', 80) }}</p>
                        
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-green-600 font-bold text-lg">{{ $wishlistItem->plant->formatted_price }}</span>
                            <span class="text-xs text-gray-500">{{ $wishlistItem->plant->stock_count }} available</span>
                        </div>
                        
                        <div class="flex space-x-2">
                            <a href="{{ route('products.show', $wishlistItem->plant->id) }}" 
                               class="flex-1 bg-blue-500 text-white px-3 py-2 rounded text-center hover:bg-blue-600 text-sm">
                                View Details
                            </a>
                            <button class="flex-1 add-to-cart bg-green-500 text-white px-3 py-2 rounded hover:bg-green-600 text-sm"
                                    data-plant-id="{{ $wishlistItem->plant->id }}"
                                    {{ $wishlistItem->plant->stock_count < 1 ? 'disabled' : '' }}>
                                {{ $wishlistItem->plant->stock_count < 1 ? 'Out of Stock' : 'Add to Cart' }}
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $wishlistItems->links() }}
        </div>
        
        <!-- Clear All Button -->
        <div class="mt-6 text-center">
            <button id="clear-wishlist-btn" class="bg-red-50 border border-red-200 text-red-600 px-6 py-3 rounded-lg hover:bg-red-100 transition-colors font-semibold">
                <i class="fas fa-trash-alt mr-2"></i>Clear All Wishlist
            </button>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <i class="fas fa-heart text-gray-300 text-6xl mb-4"></i>
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Your wishlist is empty</h2>
            <p class="text-gray-600 mb-6">Start adding plants you love to your wishlist!</p>
            <a href="{{ route('products') }}" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 inline-block">
                Browse Plants
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Clear all wishlist functionality
    const clearWishlistBtn = document.getElementById('clear-wishlist-btn');
    if (clearWishlistBtn) {
        clearWishlistBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to clear your entire wishlist? This action cannot be undone.')) {
                fetch('/wishlist/clear', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Wishlist cleared successfully!', 'success');
                        updateWishlistCount(0);
                        location.reload();
                    } else {
                        showNotification('Error clearing wishlist', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error clearing wishlist', 'error');
                });
            }
        });
    }

    // Remove from wishlist functionality
    document.addEventListener('click', function(e) {
        const removeBtn = e.target.closest('.remove-from-wishlist');
        if (removeBtn) {
            e.preventDefault();
            
            const plantId = removeBtn.dataset.plantId;
            const card = removeBtn.closest('.wishlist-card');
            
            if (confirm('Remove this plant from your wishlist?')) {
                fetch(`/wishlist/remove/${plantId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove card with animation
                        card.style.transition = 'opacity 0.3s, transform 0.3s';
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.9)';
                        
                        setTimeout(() => {
                            card.remove();
                            updateWishlistCount(data.wishlist_count);
                            
                            // Check if wishlist is empty
                            if (document.querySelectorAll('.bg-white.rounded-lg.shadow-md').length === 0) {
                                location.reload();
                            }
                        }, 300);
                        
                        showNotification('Removed from wishlist!', 'success');
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    });
    
    // Add to cart functionality
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('add-to-cart')) {
            e.preventDefault();
            
            const plantId = e.target.dataset.plantId;
            const button = e.target;
            
            if (button.disabled) return;
            
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
                    updateCartCount(data.cart_count);
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
    
    function updateCartCount(count) {
        const el = document.querySelector('.cart-count-badge');
        if (el) { el.textContent = count; el.style.display = count > 0 ? '' : 'none'; }
    }
    
    function updateWishlistCount(count) {
        const el = document.getElementById('wishlist-count-badge');
        if (el) { el.textContent = count; el.style.display = count > 0 ? '' : 'none'; }
    }
    
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        }`;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
});
</script>
@endpush
