@include('partials.header')

<div class="products-container">
    <h1 style="text-align: center; margin-bottom: 30px; color: #1e7e34;">Our Plants</h1>
    <p style="text-align: center; margin-bottom: 40px; color: #666;">Browse our beautiful collection of plants for your home and garden</p>
    
    @if(isset($plants) && $plants->count() > 0)
        @php
            $plantsArray = $plants->toArray();
            $chunkSize = 6;
            $chunks = array_chunk($plantsArray, $chunkSize);
        @endphp
        
        @foreach($chunks as $chunk)
            <div class="product-row">
                @foreach($chunk as $plant)
                    <div class="product-card">
                        @if($plant['image'])
                            <img src="{{ asset('images/plants/' . $plant['image']) }}" alt="{{ $plant['name'] }}">
                        @else
                            <img src="https://via.placeholder.com/250x180/1e7e34/ffffff?text=No+Image" alt="No Image">
                        @endif
                        <div class="product-info">
                            <div class="product-name">{{ $plant['name'] }}</div>
                            <div class="product-price">
                                @if($plant['price'] > 50)
                                    <span class="original-price">৳{{ number_format($plant['price'] * 1.2, 2) }}</span>
                                    <span class="sale-price">৳{{ number_format($plant['price'], 2) }}</span>
                                @else
                                    <span class="sale-price">৳{{ number_format($plant['price'], 2) }}</span>
                                @endif
                            </div>
                            <div class="product-stock">
                                @if($plant['stock_count'] > 10)
                                    In Stock
                                @elseif($plant['stock_count'] > 0)
                                    Low Stock ({{ $plant['stock_count'] }} left)
                                @else
                                    Out of Stock
                                @endif
                            </div>
                            <button class="add-cart-btn" onclick="addToCart({{ $plant['id'] }})">Add to Cart</button>
                            <button class="order-now-btn" onclick="orderNow({{ $plant['id'] }})">Order Now</button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @else
        <div class="no-products">
            <h3>No products available at the moment.</h3>
            <p>Please check back later or contact us for more information.</p>
        </div>
    @endif
</div>

<script>
    function addToCart(plantId) {
        // Add to cart functionality
        console.log('Adding plant ' + plantId + ' to cart');
        // You can implement AJAX call here to add to cart
        alert('Product added to cart!');
    }

    function orderNow(plantId) {
        // Order now functionality
        console.log('Ordering plant ' + plantId + ' now');
        // You can redirect to order page or implement quick order
        alert('Redirecting to checkout...');
    }
</script>

<link rel="stylesheet" href="{{ asset('css/product-cards.css') }}">

@include('partials.footer')
