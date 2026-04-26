@extends('layouts.app')

@section('title', ($site['site_name'] ?? 'Oronno Plants').' - Your Premium Plant Store')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')

{{-- ====== HERO SECTION ====== --}}
<section class="relative bg-gradient-to-br from-green-700 via-green-600 to-emerald-500 text-white overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"><pattern id="p" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="2" fill="white"/></pattern><rect width="100%" height="100%" fill="url(#p)"/></svg>
    </div>
    <div class="container mx-auto px-6 py-24 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            <div class="flex-1 text-center lg:text-left">
                <span class="inline-block bg-white bg-opacity-20 text-white text-sm font-semibold px-4 py-1 rounded-full mb-6 backdrop-blur-sm"><i class="fas fa-leaf mr-1"></i> Bangladesh's #1 Plant Store</span>
                <h1 class="text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                    Bring Nature <br><span class="text-yellow-300">Into Your Home</span>
                </h1>
                <p class="text-xl text-green-100 mb-8 max-w-xl mx-auto lg:mx-0">
                    Discover our curated collection of indoor & outdoor plants. From rare succulents to lush tropical plants — delivered fresh to your doorstep.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('products') }}" class="bg-white text-green-700 hover:bg-yellow-300 hover:text-green-900 font-bold px-8 py-4 rounded-full transition-all duration-300 shadow-lg text-lg">
                        <i class="fas fa-leaf mr-2"></i>Shop Plants
                    </a>
                    <a href="{{ route('about') }}" class="border-2 border-white text-white hover:bg-white hover:text-green-700 font-bold px-8 py-4 rounded-full transition-all duration-300 text-lg">
                        Learn More
                    </a>
                </div>
                <div class="flex gap-8 mt-10 justify-center lg:justify-start text-center">
                    <div><div class="text-3xl font-extrabold text-yellow-300">500+</div><div class="text-green-200 text-sm">Plant Varieties</div></div>
                    <div><div class="text-3xl font-extrabold text-yellow-300">10k+</div><div class="text-green-200 text-sm">Happy Customers</div></div>
                    <div><div class="text-3xl font-extrabold text-yellow-300">{{ number_format($avgRating, 1) }}★</div><div class="text-green-200 text-sm">Average Rating ({{ $totalReviews }} reviews)</div></div>
                </div>
            </div>
            <div class="flex-1 flex justify-center">
                <div class="relative">
                    <img src="{{ asset('images/herobanner.jpg') }}" 
                         alt="Beautiful indoor plants collection" 
                         class="w-80 h-80 lg:w-96 lg:h-96 rounded-3xl object-cover shadow-2xl border-4 border-white border-opacity-20">
                    <div class="absolute -top-4 -right-4 bg-yellow-400 text-green-900 font-bold px-4 py-2 rounded-full shadow-lg text-sm animate-bounce"><i class="fas fa-truck mr-1"></i> Free Delivery over ৳1000</div>
                    <div class="absolute -bottom-4 -left-4 bg-white text-green-700 font-bold px-4 py-2 rounded-full shadow-lg text-sm"><i class="fas fa-seedling mr-1"></i> 100% Healthy Plants</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ====== CATEGORY PILLS ====== --}}
<section class="bg-white border-b border-gray-100 sticky top-[68px] z-40 shadow-sm">
    <div class="container mx-auto px-6 py-4 flex gap-3 overflow-x-auto scrollbar-hide">
        <a href="{{ route('products') }}" class="whitespace-nowrap bg-green-600 text-white px-5 py-2 rounded-full text-sm font-semibold hover:bg-green-700 transition-colors flex-shrink-0"><i class="fas fa-leaf mr-1"></i> All Plants</a>
        <a href="{{ route('products') }}?category=indoor" class="whitespace-nowrap bg-gray-100 text-gray-700 px-5 py-2 rounded-full text-sm font-semibold hover:bg-green-100 hover:text-green-700 transition-colors flex-shrink-0"><i class="fas fa-home mr-1"></i> Indoor</a>
        <a href="{{ route('products') }}?category=outdoor" class="whitespace-nowrap bg-gray-100 text-gray-700 px-5 py-2 rounded-full text-sm font-semibold hover:bg-green-100 hover:text-green-700 transition-colors flex-shrink-0"><i class="fas fa-tree mr-1"></i> Outdoor</a>
        <a href="{{ route('products') }}?plant_type=succulent" class="whitespace-nowrap bg-gray-100 text-gray-700 px-5 py-2 rounded-full text-sm font-semibold hover:bg-green-100 hover:text-green-700 transition-colors flex-shrink-0"><i class="fas fa-spa mr-1"></i> Succulents</a>
        <a href="{{ route('products') }}?plant_type=flowering" class="whitespace-nowrap bg-gray-100 text-gray-700 px-5 py-2 rounded-full text-sm font-semibold hover:bg-green-100 hover:text-green-700 transition-colors flex-shrink-0"><i class="fas fa-fan mr-1"></i> Flowering</a>
        <a href="{{ route('products') }}?plant_type=tree" class="whitespace-nowrap bg-gray-100 text-gray-700 px-5 py-2 rounded-full text-sm font-semibold hover:bg-green-100 hover:text-green-700 transition-colors flex-shrink-0"><i class="fas fa-seedling mr-1"></i> Trees</a>
        <a href="{{ route('products') }}?is_seasonal=1" class="whitespace-nowrap bg-gray-100 text-gray-700 px-5 py-2 rounded-full text-sm font-semibold hover:bg-green-100 hover:text-green-700 transition-colors flex-shrink-0"><i class="fas fa-star mr-1"></i> Seasonal</a>
    </div>
</section>

{{-- ====== WHY CHOOSE US ====== --}}
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-truck text-green-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Free Delivery</h3>
                <p class="text-gray-500 text-sm">Free shipping on orders over ৳1000 across Bangladesh</p>
            </div>
            <div class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-blue-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">7-Day Guarantee</h3>
                <p class="text-gray-500 text-sm">All plants come with a 7-day health guarantee</p>
            </div>
            <div class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-leaf text-yellow-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Premium Quality</h3>
                <p class="text-gray-500 text-sm">Hand-picked, healthy plants from expert nurseries</p>
            </div>
            <div class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-headset text-purple-600 text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Expert Support</h3>
                <p class="text-gray-500 text-sm">Plant care guidance from our team of botanists</p>
            </div>
        </div>
    </div>
</section>

{{-- ====== FEATURED PLANTS ====== --}}
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">Our Collection</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-2 mb-4">Featured Plants</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Hand-selected plants that bring life, beauty, and clean air to your living spaces.</p>
        </div>

        @if(isset($plants) && $plants->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($plants->take(8) as $plant)
            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:-translate-y-1">
                <div class="relative overflow-hidden h-52">
                    @if($plant->image)
                        <img src="{{ asset('images/plants/' . $plant->image) }}" alt="{{ $plant->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                            <i class="fas fa-leaf text-green-400 text-5xl"></i>
                        </div>
                    @endif
                    @if($plant->stock_count > 0)
                        <span class="absolute top-3 left-3 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">In Stock</span>
                    @else
                        <span class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">Out of Stock</span>
                    @endif
                    @if($plant->is_seasonal)
                        <span class="absolute top-3 right-3 bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded-full">Seasonal</span>
                    @endif
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex gap-2">
                            @auth
                            <button class="wishlist-btn bg-white text-red-500 p-2 rounded-full shadow-md hover:bg-red-50" data-plant-id="{{ $plant->id }}">
                                <i class="far fa-heart"></i>
                            </button>
                            @endauth
                            <a href="{{ route('products.show', $plant->id) }}" class="bg-white text-green-700 p-2 rounded-full shadow-md hover:bg-green-50">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex gap-1 flex-wrap mb-2">
                        @if($plant->environment)
                        <span class="text-xs bg-green-50 text-green-700 px-2 py-0.5 rounded-full font-medium">{{ ucfirst($plant->environment) }}</span>
                        @endif
                        @if($plant->plant_type)
                        <span class="text-xs bg-blue-50 text-blue-700 px-2 py-0.5 rounded-full font-medium">{{ ucfirst($plant->plant_type) }}</span>
                        @endif
                    </div>
                    <h3 class="font-bold text-gray-800 mb-1 line-clamp-1">{{ $plant->name }}</h3>
                    <p class="text-gray-500 text-xs mb-3 line-clamp-2">{{ $plant->description ?: 'Beautiful plant for your space.' }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xl font-extrabold text-green-600">৳{{ number_format($plant->price, 2) }}</span>
                        <button class="add-to-cart-btn bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-sm font-semibold transition-colors"
                                data-plant-id="{{ $plant->id }}"
                                {{ $plant->stock_count < 1 ? 'disabled' : '' }}>
                            <i class="fas fa-cart-plus mr-1"></i>{{ $plant->stock_count < 1 ? 'Sold Out' : 'Add' }}
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-10">
            <a href="{{ route('products') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold px-10 py-4 rounded-full transition-colors shadow-lg text-lg">
                View All Plants <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        @else
        <div class="text-center py-16">
            <i class="fas fa-leaf text-green-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No plants available yet</h3>
            <p class="text-gray-400">Check back soon for our amazing collection!</p>
        </div>
        @endif
    </div>
</section>

{{-- ====== PROMOTIONAL BANNER ====== --}}
<section class="py-16 bg-gradient-to-r from-green-800 to-emerald-600 text-white">
    <div class="container mx-auto px-6">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-8 text-center lg:text-left">
            <div>
                <h2 class="text-3xl lg:text-4xl font-extrabold mb-3"><i class="fas fa-tag mr-2"></i>Seasonal Sale is Live!</h2>
                <p class="text-green-200 text-lg">Get up to 30% off on selected indoor plants. Limited time offer.</p>
            </div>
            <a href="{{ route('products') }}?is_seasonal=1" class="bg-yellow-400 hover:bg-yellow-300 text-green-900 font-extrabold px-10 py-4 rounded-full transition-colors shadow-lg text-lg whitespace-nowrap flex-shrink-0">
                Shop Now <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

{{-- ====== HOW IT WORKS ====== --}}
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">Simple Process</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-2 mb-4">How It Works</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Getting your dream plants delivered is easy with {{ $site['site_name'] ?? 'Oronno Plants' }}.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative">
            <div class="hidden md:block absolute top-10 left-1/4 right-1/4 h-0.5 bg-green-200 z-0"></div>
            @foreach([['fas fa-search','Browse','Explore our curated collection of 500+ plant varieties.'],['fas fa-shopping-cart','Select','Add your favourite plants to the cart.'],['fas fa-box','Order','Place your order with easy & secure checkout.'],['fas fa-leaf','Receive','Get fresh, healthy plants delivered to your door.']] as $i => $step)
            <div class="relative z-10 text-center">
                <div class="w-20 h-20 bg-white border-4 border-green-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-md"><i class="{{ $step[0] }} text-green-600 text-2xl"></i></div>
                <div class="absolute -top-1 -right-1 md:right-auto md:-top-1 md:left-16 w-6 h-6 bg-green-600 text-white text-xs font-bold rounded-full flex items-center justify-center">{{ $i+1 }}</div>
                <h3 class="font-bold text-lg text-gray-800 mb-2">{{ $step[1] }}</h3>
                <p class="text-gray-500 text-sm">{{ $step[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ====== TESTIMONIALS ====== --}}
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">Customer Love</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-2 mb-4">What Our Customers Say</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($reviews as $review)
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="text-yellow-400 text-lg mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-gray-300' }}"></i>
                        @endfor
                    </div>
                    <p class="text-gray-700 mb-4 italic">"{{ $review->comment }}"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($review->user->fname ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800 text-sm">{{ $review->user->fname ?? 'Anonymous' }} {{ $review->user->lname ?? '' }}</div>
                            <div class="text-gray-400 text-xs">Verified Buyer</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <i class="fas fa-star text-gray-300 text-4xl mb-4"></i>
                    <p class="text-gray-500">No reviews yet. Be the first to share your experience!</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ====== CTA SECTION ====== --}}
<section class="py-20 bg-gradient-to-br from-green-600 to-emerald-700 text-white text-center">
    <div class="container mx-auto px-6">
        <div class="max-w-2xl mx-auto">
            <i class="fas fa-seedling text-6xl text-green-300 mb-6 block"></i>
            <h2 class="text-4xl font-extrabold mb-4">Ready to Green Your Space?</h2>
            <p class="text-green-200 text-lg mb-8">Join 10,000+ plant lovers who trust {{ $site['site_name'] ?? 'Oronno Plants' }} for fresh, healthy, and beautiful plants.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('products') }}" class="bg-white text-green-700 hover:bg-yellow-300 hover:text-green-900 font-extrabold px-8 py-4 rounded-full transition-all duration-300 shadow-lg text-lg">
                    <i class="fas fa-leaf mr-2"></i>Browse All Plants
                </a>
                @guest
                <a href="{{ route('register') }}" class="border-2 border-white text-white hover:bg-white hover:text-green-700 font-extrabold px-8 py-4 rounded-full transition-all duration-300 text-lg">
                    Join Free Today
                </a>
                @endguest
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="{{ asset('js/home.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Add to Cart
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            if (this.disabled) return;
            const plantId = this.dataset.plantId;
            fetch(`/cart/add/${plantId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    document.querySelectorAll('.cart-count').forEach(el => el.textContent = data.cart_count);
                } else {
                    showToast(data.message, 'error');
                }
            }).catch(() => showToast('An error occurred.', 'error'));
        });
    });

    // Wishlist
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const plantId = this.dataset.plantId;
            fetch(`/wishlist/toggle/${plantId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const icon = this.querySelector('i');
                    icon.classList.toggle('far', !data.is_wishlisted);
                    icon.classList.toggle('fas', data.is_wishlisted);
                    showToast(data.is_wishlisted ? 'Added to wishlist!' : 'Removed from wishlist!', 'success');
                }
            }).catch(() => showToast('An error occurred.', 'error'));
        });
    });

    function showToast(message, type) {
        const existing = document.querySelector('.toast-notification');
        if (existing) existing.remove();
        const toast = document.createElement('div');
        toast.className = `toast-notification fixed top-24 right-6 px-6 py-3 rounded-xl text-white font-semibold shadow-2xl flex items-center gap-3 transition-all duration-300 ${type === 'success' ? 'bg-green-600' : 'bg-red-500'}`;
        toast.style.zIndex = '10000';
        toast.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>${message}`;
        document.body.appendChild(toast);
        setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 400); }, 3000);
    }
});
</script>
@endpush
