<?php $__env->startSection('title', $plant->name); ?>

<?php $__env->startPush('styles'); ?>
<link href="<?php echo e(asset('css/products.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.star-rating { display:flex; flex-direction:row-reverse; gap:0.25rem; }
.star-label { font-size:2rem; color:#e5e7eb; cursor:pointer; transition:color 0.1s; }
.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label { color:#f59e0b; }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/products.js')); ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const starLabels = document.querySelectorAll('.star-label');

    function setStarColors(val) {
        starLabels.forEach(function(l) {
            const v = parseInt(l.getAttribute('for').replace('star', ''));
            l.style.color = v <= val ? '#f59e0b' : '#e5e7eb';
        });
    }

    starLabels.forEach(function(label) {
        label.addEventListener('mouseover', function () {
            setStarColors(parseInt(this.getAttribute('for').replace('star', '')));
        });
        label.addEventListener('click', function () {
            setStarColors(parseInt(this.getAttribute('for').replace('star', '')));
        });
    });

    const starRating = document.querySelector('.star-rating');
    if (starRating) {
        starRating.addEventListener('mouseleave', function () {
            const checked = this.querySelector('input:checked');
            setStarColors(checked ? parseInt(checked.value) : 0);
        });
        const preChecked = starRating.querySelector('input:checked');
        if (preChecked) {
            setStarColors(parseInt(preChecked.value));
        }
    }

    // Pass stock count to products.js
    const maxQuantity = <?php echo e($plant->stock_count); ?>;
    if (typeof window.ProductPages !== 'undefined') {
        window.ProductPages.maxQuantity = maxQuantity;
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Breadcrumb Navigation -->
<nav class="bg-gray-50 border-b">
    <div class="container mx-auto px-4 py-3">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="<?php echo e(route('home')); ?>" class="hover:text-green-600 transition-colors">
                <i class="fas fa-home mr-1"></i>Home
            </a></li>
            <li><span class="text-gray-400">/</span></li>
            <li><a href="<?php echo e(route('products')); ?>" class="hover:text-green-600 transition-colors">Products</a></li>
            <li><span class="text-gray-400">/</span></li>
            <li class="text-gray-800 font-medium"><?php echo e($plant->name); ?></li>
        </ol>
    </div>
</nav>

<!-- Product Detail Section -->
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Product Images Section -->
        <div class="space-y-4">
            <!-- Main Image -->
            <div class="relative bg-white rounded-2xl shadow-lg overflow-hidden">
                <?php if($plant->image): ?>
                    <img id="main-image" 
                         src="<?php echo e(asset('images/plants/' . $plant->image)); ?>" 
                         alt="<?php echo e($plant->name); ?>" 
                         class="w-full h-[500px] object-cover">
                <?php else: ?>
                    <div class="w-full h-[500px] bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-leaf text-green-400 text-8xl mb-4"></i>
                            <span class="text-gray-500 text-lg">No Image Available</span>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Stock Status Badge -->
                <div class="absolute top-4 right-4">
                    <?php if($plant->stock_count > 0): ?>
                        <span class="bg-green-500 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                            <i class="fas fa-check-circle mr-2"></i>In Stock (<?php echo e($plant->stock_count); ?> available)
                        </span>
                    <?php else: ?>
                        <span class="bg-red-500 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                            <i class="fas fa-times-circle mr-2"></i>Out of Stock
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Discount Badge (if applicable) -->
                <?php if(false): ?> <!-- Add discount logic here if needed -->
                    <span class="absolute top-4 left-4 bg-orange-500 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                        <i class="fas fa-percentage mr-2"></i>20% OFF
                    </span>
                <?php endif; ?>
            </div>

            <!-- Thumbnail Gallery -->
            <?php if($plant->gallery_images && count($plant->gallery_images) > 1): ?>
                <div class="flex space-x-3 overflow-x-auto pb-2">
                    <?php $__currentLoopData = $plant->gallery_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e(asset('images/plants/' . $image)); ?>" 
                             alt="<?php echo e($plant->name); ?> - Image <?php echo e($index + 1); ?>" 
                             class="w-24 h-24 object-cover rounded-lg cursor-pointer thumbnail-image border-2 <?php echo e($index == 0 ? 'border-green-500' : 'border-transparent'); ?> hover:border-green-500 transition-colors"
                             data-image="<?php echo e($image); ?>">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <!-- Quick Info Cards -->
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-green-50 p-4 rounded-lg text-center">
                    <i class="fas fa-truck text-green-500 text-2xl mb-2"></i>
                    <p class="text-sm font-medium text-gray-700">Free Delivery</p>
                    <p class="text-xs text-gray-500">On orders over ৳1000</p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg text-center">
                    <i class="fas fa-shield-alt text-blue-500 text-2xl mb-2"></i>
                    <p class="text-sm font-medium text-gray-700">Quality Guaranteed</p>
                    <p class="text-xs text-gray-500">7-day warranty</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg text-center">
                    <i class="fas fa-seedling text-purple-500 text-2xl mb-2"></i>
                    <p class="text-sm font-medium text-gray-700">Expert Support</p>
                    <p class="text-xs text-gray-500">Care guidance</p>
                </div>
            </div>
        </div>

        <!-- Product Details Section -->
        <div class="space-y-6">
            <!-- Product Title and Category -->
            <div>
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fas fa-home mr-1"></i><?php echo e(ucfirst($plant->environment)); ?>

                    </span>
                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fas fa-leaf mr-1"></i><?php echo e(ucfirst($plant->plant_type)); ?>

                    </span>
                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-medium">
                        <?php echo e(ucfirst($plant->category)); ?>

                    </span>
                    <?php if($plant->is_seasonal && $plant->season): ?>
                        <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-snowflake mr-1"></i><?php echo e(ucfirst($plant->season)); ?>

                        </span>
                    <?php endif; ?>
                </div>
                
                <h1 class="text-4xl font-bold text-gray-800 mb-4"><?php echo e($plant->name); ?></h1>
                
                <div class="flex items-center space-x-4 mb-6">
                    <span class="text-3xl font-bold text-green-600"><?php echo e($plant->formatted_price); ?></span>
                    <?php if($plant->stock_count > 0 && $plant->stock_count <= 5): ?>
                        <span class="text-orange-500 text-sm font-medium">
                            <i class="fas fa-exclamation-triangle mr-1"></i>Only <?php echo e($plant->stock_count); ?> left!
                        </span>
                    <?php endif; ?>
                </div>
                
                <?php if($plant->description): ?>
                    <p class="text-gray-600 text-lg leading-relaxed"><?php echo e($plant->description); ?></p>
                <?php endif; ?>
            </div>

            <!-- Care Instructions Card -->
            <?php if($plant->care_instructions || $plant->sunlight_requirements || $plant->water_requirements): ?>
                <div class="bg-gradient-to-br from-green-50 to-blue-50 p-6 rounded-2xl border border-green-200">
                    <h3 class="text-xl font-semibold mb-6 flex items-center">
                        <i class="fas fa-heart text-green-500 mr-3"></i>
                        Care Instructions
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php if($plant->sunlight_requirements): ?>
                            <div class="bg-white p-4 rounded-xl shadow-sm">
                                <div class="flex items-center mb-3">
                                    <div class="bg-yellow-100 p-3 rounded-full mr-3">
                                        <i class="fas fa-sun text-yellow-500 text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Sunlight</h4>
                                    </div>
                                </div>
                                <p class="text-gray-600 ml-14"><?php echo e($plant->sunlight_requirements); ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($plant->water_requirements): ?>
                            <div class="bg-white p-4 rounded-xl shadow-sm">
                                <div class="flex items-center mb-3">
                                    <div class="bg-blue-100 p-3 rounded-full mr-3">
                                        <i class="fas fa-tint text-blue-500 text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Watering</h4>
                                    </div>
                                </div>
                                <p class="text-gray-600 ml-14"><?php echo e($plant->water_requirements); ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($plant->care_instructions): ?>
                            <div class="bg-white p-4 rounded-xl shadow-sm md:col-span-2">
                                <div class="flex items-center mb-3">
                                    <div class="bg-green-100 p-3 rounded-full mr-3">
                                        <i class="fas fa-leaf text-green-500 text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">General Care</h4>
                                    </div>
                                </div>
                                <p class="text-gray-600 ml-14"><?php echo e($plant->care_instructions); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Product Features -->
            <div class="bg-gray-50 p-6 rounded-2xl">
                <h3 class="text-xl font-semibold mb-4">Product Features</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-gray-700">Premium Quality Plant</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-gray-700">Healthy Root System</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-gray-700">Potted in Quality Soil</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-gray-700">Care Guide Included</span>
                    </div>
                </div>
            </div>

            <!-- Add to Cart Form -->
            <div class="bg-white p-6 rounded-2xl shadow-lg border">
                <form id="add-to-cart-form" class="space-y-6" data-plant-id="<?php echo e($plant->id); ?>">
                    <div>
                        <label class="block text-lg font-medium text-gray-700 mb-3">
                            <i class="fas fa-shopping-cart mr-2"></i>Quantity
                        </label>
                        <div class="flex items-center space-x-4">
                            <button type="button" class="quantity-btn minus bg-gray-200 text-gray-700 w-12 h-12 rounded-lg hover:bg-gray-300 transition-colors text-xl font-semibold">
                                -
                            </button>
                            <input type="number" 
                                   name="quantity" 
                                   value="1" 
                                   min="1" 
                                   max="<?php echo e($plant->stock_count); ?>" 
                                   class="w-24 px-4 py-3 border-2 border-gray-300 rounded-lg text-center text-lg font-semibold focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   <?php echo e($plant->stock_count < 1 ? 'disabled' : ''); ?>>
                            <button type="button" class="quantity-btn plus bg-gray-200 text-gray-700 w-12 h-12 rounded-lg hover:bg-gray-300 transition-colors text-xl font-semibold">
                                +
                            </button>
                        </div>
                        <?php if($plant->stock_count < 10 && $plant->stock_count > 0): ?>
                            <p class="text-orange-600 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                Only <?php echo e($plant->stock_count); ?> plants available in stock!
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <button type="submit" 
                                class="w-full bg-green-500 text-white px-8 py-4 rounded-xl hover:bg-green-600 disabled:bg-gray-300 disabled:cursor-not-allowed transition-colors text-lg font-semibold shadow-lg"
                                <?php echo e($plant->stock_count < 1 ? 'disabled' : ''); ?>>
                            <i class="fas fa-shopping-cart mr-2"></i>
                            <?php echo e($plant->stock_count < 1 ? 'Out of Stock' : 'Add to Cart'); ?>

                        </button>
                        
                        <div class="flex space-x-4">
                            <?php if(auth()->check()): ?>
                                <a href="<?php echo e(route('checkout.step1')); ?>" 
                                   class="flex-1 bg-orange-500 text-white px-6 py-3 rounded-xl hover:bg-orange-600 transition-colors text-lg font-semibold text-center">
                                    <i class="fas fa-bolt mr-2"></i>Order Now
                                </a>
                                <button type="button" 
                                        class="flex-1 wishlist-toggle bg-white border-2 border-red-500 text-red-500 px-6 py-3 rounded-xl hover:bg-red-50 transition-colors text-lg font-semibold"
                                        data-plant-id="<?php echo e($plant->id); ?>">
                                    <i class="far fa-heart mr-2"></i>Wishlist
                                </button>
                            <?php else: ?>
                                <a href="<?php echo e(route('login_form')); ?>" 
                                   class="flex-1 bg-orange-500 text-white px-6 py-3 rounded-xl hover:bg-orange-600 transition-colors text-lg font-semibold text-center">
                                    <i class="fas fa-bolt mr-2"></i>Login to Order
                                </a>
                                <a href="<?php echo e(route('login_form')); ?>" 
                                   class="flex-1 bg-white border-2 border-gray-300 text-gray-500 px-6 py-3 rounded-xl hover:bg-gray-50 transition-colors text-lg font-semibold text-center">
                                    <i class="far fa-heart mr-2"></i>Login
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Additional Information -->
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <span class="text-gray-500 block mb-1">SKU</span>
                    <span class="font-semibold">PLANT-<?php echo e(str_pad($plant->id, 5, '0', STR_PAD_LEFT)); ?></span>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <span class="text-gray-500 block mb-1">Category</span>
                    <span class="font-semibold"><?php echo e(ucfirst($plant->category)); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Tabs Section -->
    <div class="mt-16">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <button class="tab-btn py-4 px-1 border-b-2 border-green-500 font-medium text-green-600" data-tab="description">
                    Description
                </button>
                <button class="tab-btn py-4 px-1 border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="care">
                    Care Guide
                </button>
                <button class="tab-btn py-4 px-1 border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="shipping">
                    Shipping & Returns
                </button>
                <button class="tab-btn py-4 px-1 border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="reviews">
                    Reviews (<?php echo e($reviews->count()); ?>)
                </button>
            </nav>
        </div>

        <div class="mt-8">
            <!-- Description Tab -->
            <div id="description-tab" class="tab-content">
                <div class="prose max-w-none">
                    <h3 class="text-2xl font-semibold mb-4"><?php echo e($plant->name); ?></h3>
                    <?php if($plant->description): ?>
                        <p class="text-gray-600 text-lg leading-relaxed"><?php echo e($plant->description); ?></p>
                    <?php else: ?>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            This beautiful <?php echo e($plant->name); ?> is perfect for <?php echo e($plant->environment); ?> spaces. 
                            As a <?php echo e($plant->plant_type); ?>, it brings natural beauty and freshness to your home or office. 
                            Our plants are carefully selected and maintained to ensure you receive the highest quality specimen.
                        </p>
                    <?php endif; ?>
                    
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold mb-3">Plant Details:</h4>
                            <ul class="space-y-2 text-gray-600">
                                <li><strong>Type:</strong> <?php echo e(ucfirst($plant->plant_type)); ?></li>
                                <li><strong>Environment:</strong> <?php echo e(ucfirst($plant->environment)); ?></li>
                                <li><strong>Category:</strong> <?php echo e(ucfirst($plant->category)); ?></li>
                                <?php if($plant->is_seasonal): ?>
                                    <li><strong>Season:</strong> <?php echo e(ucfirst($plant->season)); ?></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-3">What's Included:</h4>
                            <ul class="space-y-2 text-gray-600">
                                <li>• Healthy <?php echo e($plant->name); ?> plant</li>
                                <li>• Decorative pot (if applicable)</li>
                                <li>• Care instructions guide</li>
                                <li>• 7-day health guarantee</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Care Guide Tab -->
            <div id="care-tab" class="tab-content hidden">
                <div class="prose max-w-none">
                    <h3 class="text-2xl font-semibold mb-6">Complete Care Guide</h3>
                    
                    <?php if($plant->sunlight_requirements || $plant->water_requirements || $plant->care_instructions): ?>
                        <div class="space-y-6">
                            <?php if($plant->sunlight_requirements): ?>
                                <div class="bg-yellow-50 p-6 rounded-xl border border-yellow-200">
                                    <h4 class="text-lg font-semibold mb-3 flex items-center">
                                        <i class="fas fa-sun text-yellow-500 mr-3"></i>
                                        Sunlight Requirements
                                    </h4>
                                    <p class="text-gray-700"><?php echo e($plant->sunlight_requirements); ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <?php if($plant->water_requirements): ?>
                                <div class="bg-blue-50 p-6 rounded-xl border border-blue-200">
                                    <h4 class="text-lg font-semibold mb-3 flex items-center">
                                        <i class="fas fa-tint text-blue-500 mr-3"></i>
                                        Watering Instructions
                                    </h4>
                                    <p class="text-gray-700"><?php echo e($plant->water_requirements); ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <?php if($plant->care_instructions): ?>
                                <div class="bg-green-50 p-6 rounded-xl border border-green-200">
                                    <h4 class="text-lg font-semibold mb-3 flex items-center">
                                        <i class="fas fa-leaf text-green-500 mr-3"></i>
                                        General Care Instructions
                                    </h4>
                                    <p class="text-gray-700"><?php echo e($plant->care_instructions); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <i class="fas fa-info-circle text-gray-300 text-6xl mb-4"></i>
                            <p class="text-gray-500">Detailed care instructions will be provided with your purchase.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Shipping Tab -->
            <div id="shipping-tab" class="tab-content hidden">
                <div class="prose max-w-none">
                    <h3 class="text-2xl font-semibold mb-6">Shipping & Returns</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-lg font-semibold mb-4">Shipping Information</h4>
                            <ul class="space-y-3 text-gray-600">
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
                                    <span>Free shipping on orders over ৳1000</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
                                    <span>2-3 business days delivery within Dhaka</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
                                    <span>3-5 business days for outside Dhaka</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
                                    <span>Careful packaging to ensure plant safety</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 class="text-lg font-semibold mb-4">Return Policy</h4>
                            <ul class="space-y-3 text-gray-600">
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
                                    <span>7-day health guarantee</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
                                    <span>Return if plant arrives damaged</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
                                    <span>Full refund or replacement available</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mr-3 mt-1"></i>
                                    <span>Customer support available 24/7</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews Tab -->
            <div id="reviews-tab" class="tab-content hidden">

                
                <?php if($reviews->count() > 0): ?>
                <div style="display:flex;align-items:center;gap:1.5rem;background:#f9fafb;border-radius:1rem;padding:1.25rem 1.5rem;margin-bottom:1.5rem;border:1px solid #e5e7eb;">
                    <div style="text-align:center;">
                        <div style="font-size:3rem;font-weight:900;color:#111827;line-height:1;"><?php echo e(number_format($avgRating,1)); ?></div>
                        <div style="margin-top:0.25rem;">
                            <?php for($i=1;$i<=5;$i++): ?>
                            <i class="fas fa-star" style="color:<?php echo e($i<=$avgRating ? '#f59e0b' : '#e5e7eb'); ?>;font-size:1rem;"></i>
                            <?php endfor; ?>
                        </div>
                        <div style="font-size:0.8rem;color:#6b7280;margin-top:0.25rem;"><?php echo e($reviews->count()); ?> review(s)</div>
                    </div>
                </div>
                <?php endif; ?>

                
                <?php if(session('success')): ?>
                <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;padding:0.75rem 1rem;border-radius:0.75rem;margin-bottom:1rem;font-size:0.875rem;">
                    <i class="fas fa-check-circle mr-2"></i><?php echo e(session('success')); ?>

                </div>
                <?php endif; ?>
                <?php if(session('error')): ?>
                <div style="background:#fef2f2;border:1px solid #fecaca;color:#dc2626;padding:0.75rem 1rem;border-radius:0.75rem;margin-bottom:1rem;font-size:0.875rem;">
                    <i class="fas fa-exclamation-circle mr-2"></i><?php echo e(session('error')); ?>

                </div>
                <?php endif; ?>

                
                <?php if(auth()->guard()->check()): ?>
                    <?php if(!$userReview): ?>
                    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:1rem;padding:1.5rem;margin-bottom:1.5rem;">
                        <h4 style="font-size:1rem;font-weight:700;color:#111827;margin-bottom:1rem;"><i class="fas fa-pen mr-2" style="color:#16a34a;"></i>Write a Review</h4>
                        <form method="POST" action="<?php echo e(route('reviews.store', $plant->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <div style="margin-bottom:1rem;">
                                <label style="font-size:0.875rem;font-weight:600;color:#374151;display:block;margin-bottom:0.5rem;">Rating <span style="color:#ef4444;">*</span></label>
                                <div class="star-rating" style="display:flex;gap:0.25rem;">
                                    <?php for($i=5;$i>=1;$i--): ?>
                                    <input type="radio" name="rating" value="<?php echo e($i); ?>" id="star<?php echo e($i); ?>" style="display:none;" <?php echo e(old('rating')==$i?'checked':''); ?>>
                                    <label for="star<?php echo e($i); ?>" class="star-label">&#9733;</label>
                                    <?php endfor; ?>
                                </div>
                                <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="color:#ef4444;font-size:0.8rem;margin-top:0.25rem;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div style="margin-bottom:1rem;">
                                <label style="font-size:0.875rem;font-weight:600;color:#374151;display:block;margin-bottom:0.5rem;">Comment (optional)</label>
                                <textarea name="comment" rows="4" placeholder="Share your experience with this plant..." style="width:100%;padding:0.75rem;border:1.5px solid #d1d5db;border-radius:0.5rem;font-size:0.875rem;resize:vertical;box-sizing:border-box;"><?php echo e(old('comment')); ?></textarea>
                            </div>
                            <button type="submit" style="background:#16a34a;color:#fff;border:none;padding:0.65rem 2rem;border-radius:0.75rem;font-weight:700;cursor:pointer;font-size:0.875rem;">
                                <i class="fas fa-paper-plane mr-2"></i>Submit Review
                            </button>
                        </form>
                    </div>
                    <?php else: ?>
                    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:0.75rem;padding:0.875rem 1rem;margin-bottom:1.5rem;font-size:0.875rem;color:#166534;">
                        <i class="fas fa-check-circle mr-2"></i>You have already submitted a review for this plant.
                    </div>
                    <?php endif; ?>
                <?php else: ?>
                <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:0.75rem;padding:1rem 1.25rem;margin-bottom:1.5rem;text-align:center;">
                    <a href="<?php echo e(route('login_form')); ?>" style="color:#16a34a;font-weight:700;text-decoration:underline;">Login</a> to leave a review.
                </div>
                <?php endif; ?>

                
                <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div style="background:#fff;border:1px solid #f3f4f6;border-radius:1rem;padding:1.25rem;margin-bottom:0.875rem;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.5rem;flex-wrap:wrap;gap:0.5rem;">
                        <div style="display:flex;align-items:center;gap:0.75rem;">
                            <div style="width:36px;height:36px;border-radius:50%;background:#dcfce7;display:flex;align-items:center;justify-content:center;color:#16a34a;font-weight:800;font-size:0.875rem;">
                                <?php echo e(strtoupper(substr($review->user->fname ?? 'U', 0, 1))); ?>

                            </div>
                            <div>
                                <div style="font-weight:700;color:#111827;font-size:0.875rem;"><?php echo e($review->user->fname ?? 'User'); ?> <?php echo e($review->user->lname ?? ''); ?></div>
                                <div style="font-size:0.75rem;color:#9ca3af;"><?php echo e($review->created_at->diffForHumans()); ?></div>
                            </div>
                        </div>
                        <div>
                            <?php for($i=1;$i<=5;$i++): ?>
                            <i class="fas fa-star" style="color:<?php echo e($i<=$review->rating ? '#f59e0b' : '#e5e7eb'); ?>;font-size:0.875rem;"></i>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <?php if($review->comment): ?>
                    <p style="font-size:0.875rem;color:#374151;margin:0.5rem 0 0;line-height:1.6;"><?php echo e($review->comment); ?></p>
                    <?php endif; ?>
                    <?php if(auth()->id() === $review->user_id): ?>
                    <form method="POST" action="<?php echo e(route('reviews.destroy', $review->id)); ?>" style="margin-top:0.5rem;" onsubmit="return confirm('Delete this review?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" style="background:none;border:none;color:#ef4444;font-size:0.75rem;cursor:pointer;padding:0;"><i class="fas fa-trash mr-1"></i>Delete</button>
                    </form>
                    <?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div style="text-align:center;padding:3rem;color:#9ca3af;">
                    <i class="fas fa-star" style="font-size:3rem;display:block;margin-bottom:0.75rem;color:#e5e7eb;"></i>
                    <p>No approved reviews yet. Be the first to review!</p>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <!-- Related Products -->
    <?php if($relatedPlants->count() > 0): ?>
        <div class="mt-16">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">You Might Also Like</h2>
                <p class="text-gray-600">Similar plants that complement your choice</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php $__currentLoopData = $relatedPlants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedPlant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="relative">
                            <?php if($relatedPlant->image): ?>
                                <img src="<?php echo e(asset('images/plants/' . $relatedPlant->image)); ?>" 
                                     alt="<?php echo e($relatedPlant->name); ?>" 
                                     class="w-full h-48 object-cover">
                            <?php else: ?>
                                <div class="w-full h-48 bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                                    <i class="fas fa-leaf text-green-400 text-3xl"></i>
                                </div>
                            <?php endif; ?>
                            
                            <?php if($relatedPlant->stock_count > 0): ?>
                                <span class="absolute top-3 right-3 bg-green-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                    In Stock
                                </span>
                            <?php else: ?>
                                <span class="absolute top-3 right-3 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                    Out of Stock
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-2 line-clamp-1"><?php echo e($relatedPlant->name); ?></h3>
                            <p class="text-gray-600 text-sm mb-3"><?php echo e(Str::limit($relatedPlant->description, 60)); ?></p>
                            
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-green-600 font-bold text-lg"><?php echo e($relatedPlant->formatted_price); ?></span>
                                <span class="text-xs text-gray-500"><?php echo e($relatedPlant->stock_count); ?> available</span>
                            </div>
                            
                            <div class="flex space-x-2">
                                <a href="<?php echo e(route('products.show', $relatedPlant->id)); ?>" 
                                   class="flex-1 bg-blue-500 text-white px-3 py-2 rounded-lg hover:bg-blue-600 transition-colors text-sm text-center">
                                    View
                                </a>
                                <button class="flex-1 add-to-cart bg-green-500 text-white px-3 py-2 rounded-lg hover:bg-green-600 transition-colors text-sm"
                                        data-plant-id="<?php echo e($relatedPlant->id); ?>"
                                        <?php echo e($relatedPlant->stock_count < 1 ? 'disabled' : ''); ?>>
                                    <?php echo e($relatedPlant->stock_count < 1 ? 'Sold Out' : 'Add'); ?>

                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\alone\OneDrive\Desktop\Team Thunder\resources\views/products/show.blade.php ENDPATH**/ ?>