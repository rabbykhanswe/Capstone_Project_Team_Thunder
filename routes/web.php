<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NotificationController;
use App\Models\Plant;

Route::get('/', function () {
    $plants = Plant::orderBy('category')->orderBy('name')->get();
    $reviews = \App\Models\Review::where('status', 'approved')->with('user')->latest()->take(3)->get();
    
    // Calculate average rating
    $avgRating = \App\Models\Review::where('status', 'approved')->avg('rating') ?? 0;
    $totalReviews = \App\Models\Review::where('status', 'approved')->count();
    
    return view('home', compact('plants', 'reviews', 'avgRating', 'totalReviews'));
})->name('home');
Route::get('/about',function(){return view('about');})->name('about');
Route::get('/contact',function(){return view('contact');})->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Product Discovery Routes
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// AJAX Routes for Search and Filter
Route::get('/api/search', [SearchController::class, 'search'])->name('api.search');
Route::get('/api/autocomplete', [SearchController::class, 'autocomplete'])->name('api.autocomplete');
Route::get('/api/products/filter', [ProductController::class, 'filter'])->name('api.products.filter');

// Shopping Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/api/cart/count', [CartController::class, 'getCartCount'])->name('api.cart.count');

// Wishlist Routes
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/add/{plantId}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{plantId}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/wishlist/toggle/{plantId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');
    Route::get('/api/wishlist/count', [WishlistController::class, 'getWishlistCount'])->name('api.wishlist.count');
    Route::get('/api/wishlist/check/{plantId}', [WishlistController::class, 'checkWishlistStatus'])->name('api.wishlist.check');
});

//Auth Routes
Route::get('/register',[AuthController::class,'ShowRegister'])->name('register');
Route::get('/login',[AuthController::class,'ShowLogin'])->name('login_form');
Route::post('/login',[AuthController::class,'Login'])->name('login');
Route::match(['get', 'post'], '/logout',[AuthController::class,'Logout'])->name('logout')->middleware('auth');

// Mobile OTP Registration Routes
Route::post('/api/auth/register', [CustomAuthController::class, 'register'])
    ->middleware(['guest', 'throttle:3,1'])
    ->name('custom.auth.register');
Route::post('/api/auth/verify-otp', [CustomAuthController::class, 'verifyOtp'])
    ->middleware(['guest', 'throttle:10,1'])
    ->name('custom.auth.verify.otp');
Route::post('/api/auth/resend-otp', [CustomAuthController::class, 'resendOtp'])
    ->middleware(['guest', 'throttle:3,1'])
    ->name('custom.auth.resend.otp');

// OTP Routes
Route::get('/otp/send', [OtpController::class, 'otpSend'])->name('otp.send.form');
Route::post('/otp/send', [OtpController::class, 'sendOTP'])->name('otp.send');
Route::get('/otp/verify', [OtpController::class, 'showVerification'])->name('otp.verify.form');
Route::post('/otp/verify', [OtpController::class, 'verifyOTP'])->name('otp.verify');

// Password Reset Routes
Route::get('/forgot-password', [OtpController::class, 'showForgotPassword'])->name('password.forgot');
Route::post('/forgot-password', [OtpController::class, 'sendPasswordOTP'])->name('password.otp.send');
Route::get('/reset-password', [OtpController::class, 'showResetPassword'])->name('password.reset.form');
Route::post('/reset-password', [OtpController::class, 'resetPassword'])->name('password.reset');

// Profile & Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/account/dashboard', [DashboardController::class, 'index'])->name('account.dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Checkout Routes (Multi-Step)
    Route::get('/checkout',          [CheckoutController::class, 'step1'])->name('checkout.step1');
    Route::post('/checkout/address', [CheckoutController::class, 'postStep1'])->name('checkout.post.step1');
    Route::get('/checkout/payment',  [CheckoutController::class, 'step2'])->name('checkout.step2');
    Route::post('/checkout/payment', [CheckoutController::class, 'postStep2'])->name('checkout.post.step2');
    Route::get('/checkout/review',   [CheckoutController::class, 'step3'])->name('checkout.step3');
    Route::post('/checkout/place',   [CheckoutController::class, 'placeOrder'])->name('checkout.place');
    Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Order History & Tracking
    Route::get('/orders',             [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}',        [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{id}/invoice',[OrderController::class, 'invoice'])->name('orders.invoice');

    // Plant Reviews
    Route::post('/products/{plantId}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{id}',             [ReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // Notifications
    Route::get('/notifications',            [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});


// Admin Management Routes
Route::get('/admin/dashboard',function(){return view('admin.dashboard');})->name('admin.dashboard')->middleware('admin');
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    // Order Management
    Route::get('/orders',                  [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}',             [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/status',     [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    // Review Moderation
    Route::get('/reviews',                 [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{id}/status',    [AdminReviewController::class, 'updateStatus'])->name('reviews.status');
    Route::delete('/reviews/{id}',         [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
    // Contact Inquiries
    Route::get('/inquiries',               [AdminReviewController::class, 'inquiries'])->name('inquiries.index');
    Route::post('/inquiries/{id}/reply',   [AdminReviewController::class, 'replyInquiry'])->name('inquiries.reply');
    Route::post('/inquiries/{id}/read',    [AdminReviewController::class, 'markInquiryRead'])->name('inquiries.read');

    Route::get('/users', function(\Illuminate\Http\Request $request){
        $query = \App\Models\User::withCount('orders');
        if ($request->search) {
            $s = $request->search;
            $query->where(function($q) use ($s){
                $q->where('fname','like',"%$s%")->orWhere('lname','like',"%$s%")->orWhere('email','like',"%$s%")->orWhere('phone','like',"%$s%");
            });
        }
        $users = $query->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    })->name('users');
    Route::get('/settings',     [AdminSettingsController::class, 'index'])->name('settings');
    Route::put('/settings',     [AdminSettingsController::class, 'update'])->name('settings.update');
    Route::put('/settings/sms', [AdminSettingsController::class, 'updateSms'])->name('settings.sms.update');
    
    // Category Management Routes
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

// Admin Plant Management Routes
Route::middleware(['admin'])->prefix('admin/plants')->name('admin.plants.')->group(function () {
    Route::get('/', [PlantController::class, 'index'])->name('index');
    Route::get('/create', [PlantController::class, 'create'])->name('create');
    Route::post('/', [PlantController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [PlantController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PlantController::class, 'update'])->name('update');
    Route::delete('/{id}', [PlantController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/stock', [PlantController::class, 'updateStock'])->name('stock');
    Route::post('/{id}/price', [PlantController::class, 'updatePrice'])->name('price');
});