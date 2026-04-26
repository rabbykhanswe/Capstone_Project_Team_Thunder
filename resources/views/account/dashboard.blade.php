@extends('layouts.app')
@section('title', 'My Dashboard')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush
@section('content')
<div class="dashboard-wrapper">

    {{-- Sidebar --}}
    <aside class="dashboard-sidebar">
        <div class="sidebar-profile">
            @if($user->profile_picture)
                <img src="{{ asset('images/profile_pictures/' . $user->profile_picture) }}" alt="Profile" class="sidebar-avatar" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="sidebar-avatar-placeholder" style="display:none;"><i class="fas fa-user"></i></div>
            @else
                <div class="sidebar-avatar-placeholder"><i class="fas fa-user"></i></div>
            @endif
            <div>
                <div class="sidebar-name">{{ $user->fname }} {{ $user->lname }}</div>
                <div class="sidebar-phone">{{ $user->phone }}</div>
            </div>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('account.dashboard') }}" class="sidebar-link active"><i class="fas fa-th-large"></i> Dashboard</a>
            <a href="{{ route('orders.index') }}" class="sidebar-link"><i class="fas fa-box"></i> My Orders</a>
            <a href="{{ route('wishlist') }}" class="sidebar-link"><i class="fas fa-heart"></i> Wishlist</a>
            <a href="{{ route('cart') }}" class="sidebar-link"><i class="fas fa-shopping-cart"></i> Cart</a>
            <a href="{{ route('profile') }}" class="sidebar-link"><i class="fas fa-user-circle"></i> Profile</a>
            <a href="{{ route('profile.edit') }}" class="sidebar-link"><i class="fas fa-edit"></i> Edit Profile</a>
            <form action="{{ route('logout') }}" method="POST" class="sidebar-logout-form">
                @csrf
                <button type="submit" class="sidebar-link sidebar-link-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </nav>
    </aside>

    {{-- Main Content --}}
    <main class="dashboard-main">

        {{-- Welcome Banner --}}
        <div class="dashboard-welcome">
            <div>
                <h1 class="dashboard-welcome-title">Welcome back, {{ $user->fname }}!</h1>
                <p class="dashboard-welcome-sub">Here's a summary of your account activity.</p>
            </div>
            <a href="{{ route('checkout.step1') }}" class="btn-shop-now"><i class="fas fa-leaf mr-2"></i>Shop Now</a>
        </div>

        {{-- Stats Cards --}}
        <div class="stats-grid">
            <div class="stat-card stat-card-blue">
                <div class="stat-icon"><i class="fas fa-box"></i></div>
                <div class="stat-info">
                    <div class="stat-number">{{ $totalOrders }}</div>
                    <div class="stat-label">Total Orders</div>
                </div>
            </div>
            <div class="stat-card stat-card-green">
                <div class="stat-icon"><i class="fas fa-taka-sign"></i></div>
                <div class="stat-info">
                    <div class="stat-number">৳{{ number_format($totalSpent, 0) }}</div>
                    <div class="stat-label">Total Spent</div>
                </div>
            </div>
            <div class="stat-card stat-card-yellow">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-info">
                    <div class="stat-number">{{ $pendingOrders }}</div>
                    <div class="stat-label">Active Orders</div>
                </div>
            </div>
            <div class="stat-card stat-card-emerald">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-info">
                    <div class="stat-number">{{ $deliveredOrders }}</div>
                    <div class="stat-label">Delivered</div>
                </div>
            </div>
            <div class="stat-card stat-card-red">
                <div class="stat-icon"><i class="fas fa-heart"></i></div>
                <div class="stat-info">
                    <div class="stat-number">{{ $wishlistCount }}</div>
                    <div class="stat-label">Wishlist Items</div>
                </div>
            </div>
        </div>

        {{-- Two Column Layout --}}
        <div class="dashboard-grid-2">

            {{-- Recent Orders --}}
            <section class="dashboard-card">
                <div class="card-header-row">
                    <h2 class="card-title"><i class="fas fa-box mr-2 text-green-600"></i>Recent Orders</h2>
                    <a href="{{ route('orders.index') }}" class="card-link">View All</a>
                </div>
                @if($recentOrders->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-box-open"></i>
                        <p>No orders yet. <a href="{{ route('products') }}">Start shopping!</a></p>
                    </div>
                @else
                    <div class="orders-table-wrap">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td class="order-number">{{ $order->order_number }}</td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="font-semibold">৳{{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        <span class="status-badge {{ $order->status_badge }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td><a href="{{ route('orders.show', $order->id) }}" class="table-action-link">Details</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>

            {{-- Wishlist Preview --}}
            <section class="dashboard-card">
                <div class="card-header-row">
                    <h2 class="card-title"><i class="fas fa-heart mr-2 text-red-500"></i>Saved Wishlist</h2>
                    <a href="{{ route('wishlist') }}" class="card-link">View All</a>
                </div>
                @if($wishlistItems->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-heart-broken"></i>
                        <p>Your wishlist is empty. <a href="{{ route('products') }}">Browse plants!</a></p>
                    </div>
                @else
                    <div class="wishlist-grid">
                        @foreach($wishlistItems as $item)
                            @if($item->plant)
                            <a href="{{ route('products.show', $item->plant->id) }}" class="wishlist-mini-card">
                                <div class="wishlist-mini-img">
                                    @if($item->plant->image)
                                        <img src="{{ asset('images/plants/' . $item->plant->image) }}" alt="{{ $item->plant->name }}">
                                    @else
                                        <div class="wishlist-mini-placeholder"><i class="fas fa-leaf"></i></div>
                                    @endif
                                </div>
                                <div class="wishlist-mini-info">
                                    <div class="wishlist-mini-name">{{ $item->plant->name }}</div>
                                    <div class="wishlist-mini-price">৳{{ number_format($item->plant->price, 2) }}</div>
                                </div>
                            </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </section>
        </div>

        {{-- Quick Actions --}}
        <section class="dashboard-card mt-6">
            <h2 class="card-title mb-4"><i class="fas fa-bolt mr-2 text-yellow-500"></i>Quick Actions</h2>
            <div class="quick-actions-grid">
                <a href="{{ route('products') }}" class="quick-action-btn quick-action-green">
                    <i class="fas fa-seedling"></i><span>Browse Plants</span>
                </a>
                <a href="{{ route('cart') }}" class="quick-action-btn quick-action-blue">
                    <i class="fas fa-shopping-cart"></i><span>View Cart @if($cartCount > 0)<span class="qa-badge">{{ $cartCount }}</span>@endif</span>
                </a>
                <a href="{{ route('orders.index') }}" class="quick-action-btn quick-action-purple">
                    <i class="fas fa-truck"></i><span>Track Orders</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="quick-action-btn quick-action-gray">
                    <i class="fas fa-user-edit"></i><span>Edit Profile</span>
                </a>
                <a href="{{ route('contact') }}" class="quick-action-btn quick-action-emerald">
                    <i class="fas fa-headset"></i><span>Get Support</span>
                </a>
                <a href="{{ route('wishlist') }}" class="quick-action-btn quick-action-red">
                    <i class="fas fa-heart"></i><span>Wishlist</span>
                </a>
            </div>
        </section>

    </main>
</div>
@endsection
