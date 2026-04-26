@include('partials.header')

<link rel="stylesheet" href="{{ asset('css/product-cards.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<div class="products-container">
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
        console.log('Adding plant ' + plantId + ' to cart');
        alert('Product added to cart!');
    }

    function orderNow(plantId) {
        console.log('Ordering plant ' + plantId + ' now');
        alert('Redirecting to checkout...');
    }
</script>

@include('partials.footer')