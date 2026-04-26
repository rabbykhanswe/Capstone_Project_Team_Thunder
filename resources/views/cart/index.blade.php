@extends('layouts.app')

@section('title', 'Shopping Cart')

@push('styles')
<link href="{{ asset('css/products.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/products.js') }}"></script>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Shopping Cart</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            @if(count($cartItems) > 0)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-4">Cart Items ({{ count($cartItems) }})</h2>
                        
                        <div class="space-y-4">
                            @foreach($cartItems as $item)
                                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg cart-item" data-plant-id="{{ $item['plant']->id }}">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0">
                                        @if($item['plant']->image)
                                            <img src="{{ asset('images/plants/' . $item['plant']->image) }}" 
                                                 alt="{{ $item['plant']->name }}" 
                                                 class="w-20 h-20 object-cover rounded">
                                        @else
                                            <div class="w-20 h-20 bg-gray-200 flex items-center justify-center rounded">
                                                <span class="text-gray-400 text-xs">No Image</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Details -->
                                    <div class="flex-grow">
                                        <h3 class="font-semibold text-lg">{{ $item['plant']->name }}</h3>
                                        <p class="text-gray-600 text-sm">{{ $item['plant']->category }}</p>
                                        <p class="text-green-600 font-semibold">{{ $item['plant']->formatted_price }}</p>
                                        
                                        @if($item['plant']->stock_count < 5)
                                            <p class="text-orange-600 text-xs mt-1">
                                                Only {{ $item['plant']->stock_count }} left in stock!
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Quantity Controls -->
                                    <div class="flex items-center space-x-2">
                                        <button class="quantity-minus bg-gray-200 text-gray-700 w-8 h-8 rounded hover:bg-gray-300"
                                                data-plant-id="{{ $item['plant']->id }}">
                                            -
                                        </button>
                                        <input type="number" 
                                               value="{{ $item['quantity'] }}" 
                                               min="1" 
                                               max="{{ $item['plant']->stock_count }}"
                                               class="quantity-input w-16 px-2 py-1 border border-gray-300 rounded text-center"
                                               data-plant-id="{{ $item['plant']->id }}">
                                        <button class="quantity-plus bg-gray-200 text-gray-700 w-8 h-8 rounded hover:bg-gray-300"
                                                data-plant-id="{{ $item['plant']->id }}">
                                            +
                                        </button>
                                    </div>

                                    <!-- Item Total and Remove -->
                                    <div class="text-right">
                                        <p class="font-semibold item-total">{{ number_format($item['item_total'], 2) }}</p>
                                        <button class="remove-item text-red-500 hover:text-red-700 text-sm mt-2"
                                                data-plant-id="{{ $item['plant']->id }}">
                                            <i class="fas fa-trash"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <i class="fas fa-shopping-cart text-gray-300 text-6xl mb-4"></i>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Your cart is empty</h2>
                    <p class="text-gray-600 mb-6">Looks like you haven't added any plants to your cart yet.</p>
                    <a href="{{ route('products') }}" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 inline-block">
                        Continue Shopping
                    </a>
                </div>
            @endif
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            @if(count($cartItems) > 0)
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold subtotal">{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Delivery</span>
                            <span class="font-semibold">Free</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tax</span>
                            <span class="font-semibold">Calculated at checkout</span>
                        </div>
                        <div class="border-t pt-3">
                            <div class="flex justify-between">
                                <span class="text-lg font-semibold">Total</span>
                                <span class="text-lg font-bold text-green-600 total">{{ number_format($subtotal, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @auth
                        <a href="{{ route('checkout.step1') }}" class="w-full bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 text-center block font-semibold">
                            <i class="fas fa-lock mr-2"></i>Proceed to Checkout
                        </a>
                        @else
                        <a href="{{ route('login_form') }}" class="w-full bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 text-center block font-semibold">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login to Checkout
                        </a>
                        @endauth
                        <a href="{{ route('products') }}" class="w-full bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 text-center block">
                            Continue Shopping
                        </a>
                        <button id="clear-cart" class="w-full bg-red-50 border border-red-200 text-red-600 px-6 py-3 rounded-lg hover:bg-red-100 transition-colors font-semibold">
                            <i class="fas fa-trash-alt mr-2"></i>Clear Cart
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity controls
    document.addEventListener('click', function(e) {
        // Quantity minus
        if (e.target.classList.contains('quantity-minus')) {
            const plantId = e.target.dataset.plantId;
            const input = document.querySelector(`.quantity-input[data-plant-id="${plantId}"]`);
            const currentValue = parseInt(input.value);
            
            if (currentValue > 1) {
                updateQuantity(plantId, currentValue - 1);
            }
        }
        
        // Quantity plus
        if (e.target.classList.contains('quantity-plus')) {
            const plantId = e.target.dataset.plantId;
            const input = document.querySelector(`.quantity-input[data-plant-id="${plantId}"]`);
            const currentValue = parseInt(input.value);
            const maxValue = parseInt(input.max);
            
            if (currentValue < maxValue) {
                updateQuantity(plantId, currentValue + 1);
            } else {
                showNotification('Maximum stock limit reached!', 'error');
            }
        }
        
        // Remove item
        if (e.target.classList.contains('remove-item') || e.target.parentElement.classList.contains('remove-item')) {
            const button = e.target.classList.contains('remove-item') ? e.target : e.target.parentElement;
            const plantId = button.dataset.plantId;
            
            if (confirm('Are you sure you want to remove this item from your cart?')) {
                removeItem(plantId);
            }
        }
        
        // Clear cart
        if (e.target.id === 'clear-cart') {
            if (confirm('Are you sure you want to clear your entire cart?')) {
                clearCart();
            }
        }
    });
    
    // Quantity input change
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('quantity-input')) {
            const plantId = e.target.dataset.plantId;
            const newQuantity = parseInt(e.target.value);
            const maxValue = parseInt(e.target.max);
            
            if (newQuantity < 1) {
                e.target.value = 1;
                return;
            }
            
            if (newQuantity > maxValue) {
                e.target.value = maxValue;
                showNotification('Maximum stock limit reached!', 'error');
                return;
            }
            
            updateQuantity(plantId, newQuantity);
        }
    });
    
    function updateQuantity(plantId, quantity) {
        fetch(`/cart/update/${plantId}`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update input value
                const input = document.querySelector(`.quantity-input[data-plant-id="${plantId}"]`);
                input.value = quantity;
                
                // Update item total
                const cartItem = document.querySelector(`.cart-item[data-plant-id="${plantId}"]`);
                const itemTotalElement = cartItem.querySelector('.item-total');
                itemTotalElement.textContent = data.item_total;
                
                // Update subtotal
                updateSubtotal(data.subtotal);
                
                showNotification('Cart updated successfully!', 'success');
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => console.error('Error:', error));
    }
    
    function removeItem(plantId) {
        fetch(`/cart/remove/${plantId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove cart item from DOM
                const cartItem = document.querySelector(`.cart-item[data-plant-id="${plantId}"]`);
                if (cartItem) {
                    cartItem.style.transition = 'opacity 0.3s';
                    cartItem.style.opacity = '0';
                    setTimeout(() => {
                        cartItem.remove();
                        updateSubtotal(data.subtotal);
                        updateCartCount();
                        if (document.querySelectorAll('.cart-item').length === 0) {
                            location.reload();
                        }
                    }, 300);
                }
                showNotification('Item removed from cart!', 'success');
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => console.error('Error:', error));
    }
    
    function clearCart() {
        fetch('/cart/clear', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => console.error('Error:', error));
    }
    
    function updateSubtotal(subtotal) {
        const subtotalElements = document.querySelectorAll('.subtotal');
        const totalElements = document.querySelectorAll('.total');
        
        subtotalElements.forEach(element => {
            element.textContent = number_format(subtotal, 2);
        });
        
        totalElements.forEach(element => {
            element.textContent = number_format(subtotal, 2);
        });
    }
    
    function updateCartBadge(count) {
        const el = document.querySelector('.cart-count-badge');
        if (el) { el.textContent = count; el.style.display = count > 0 ? '' : 'none'; }
    }
    function updateCartCount() {
        fetch('/api/cart/count')
            .then(response => response.json())
            .then(data => updateCartBadge(data.count));
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
    
    // Helper function for number formatting
    function number_format(number, decimals) {
        return parseFloat(number).toFixed(decimals);
    }
});
</script>
@endpush
