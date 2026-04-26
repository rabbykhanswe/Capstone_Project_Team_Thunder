@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
@php
    $totalPlants     = \App\Models\Plant::count();
    $totalUsers      = \App\Models\User::count();
    $totalCategories = \App\Models\Category::count();
    $totalOrders     = \App\Models\Order::count();
    $pendingOrders   = \App\Models\Order::whereIn('status',['pending','processing'])->count();
    $totalReviews    = \App\Models\Review::count();
    $pendingReviews  = \App\Models\Review::where('status','pending')->count();
    $newInquiries    = \App\Models\ContactInquiry::where('status','new')->count();
    $recentOrders    = \App\Models\Order::with('user')->latest()->take(6)->get();
    $lowStock        = \App\Models\Plant::where('stock_count','<=',5)->orderBy('stock_count')->take(5)->get();
@endphp

{{-- Stats Grid --}}
<div class="ap-stats">
    <div class="ap-stat">
        <div class="ap-stat-icon green"><i class="fas fa-seedling"></i></div>
        <div>
            <div class="ap-stat-num">{{ $totalPlants }}</div>
            <div class="ap-stat-label">Total Plants</div>
            <div class="ap-stat-sub"><a href="{{ route('admin.plants.index') }}" style="color:inherit">Manage →</a></div>
        </div>
    </div>
    <div class="ap-stat">
        <div class="ap-stat-icon blue"><i class="fas fa-users"></i></div>
        <div>
            <div class="ap-stat-num">{{ $totalUsers }}</div>
            <div class="ap-stat-label">Registered Users</div>
            <div class="ap-stat-sub"><a href="{{ route('admin.users') }}" style="color:inherit">View →</a></div>
        </div>
    </div>
    <div class="ap-stat">
        <div class="ap-stat-icon yellow"><i class="fas fa-shopping-bag"></i></div>
        <div>
            <div class="ap-stat-num">{{ $totalOrders }}</div>
            <div class="ap-stat-label">Total Orders</div>
            @if($pendingOrders)
            <div class="ap-stat-sub">{{ $pendingOrders }} pending</div>
            @endif
        </div>
    </div>
    <div class="ap-stat">
        <div class="ap-stat-icon purple"><i class="fas fa-star"></i></div>
        <div>
            <div class="ap-stat-num">{{ $totalReviews }}</div>
            <div class="ap-stat-label">Reviews</div>
            @if($pendingReviews)
            <div class="ap-stat-sub">{{ $pendingReviews }} pending</div>
            @endif
        </div>
    </div>
    <div class="ap-stat">
        <div class="ap-stat-icon green"><i class="fas fa-layer-group"></i></div>
        <div>
            <div class="ap-stat-num">{{ $totalCategories }}</div>
            <div class="ap-stat-label">Categories</div>
            <div class="ap-stat-sub"><a href="{{ route('admin.categories.index') }}" style="color:inherit">Manage →</a></div>
        </div>
    </div>
    <div class="ap-stat">
        <div class="ap-stat-icon red"><i class="fas fa-envelope"></i></div>
        <div>
            <div class="ap-stat-num">{{ $newInquiries }}</div>
            <div class="ap-stat-label">New Inquiries</div>
            <div class="ap-stat-sub"><a href="{{ route('admin.inquiries.index') }}" style="color:inherit">View →</a></div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="ap-section-grid" style="margin-bottom:28px;">
    <div class="ap-section-card">
        <h3><i class="fas fa-seedling"></i> Plant Catalogue</h3>
        <p>Add new plants, update prices, manage stock levels, and organise your inventory.</p>
        <div class="ap-action-row">
            <a href="{{ route('admin.plants.create') }}" class="ap-btn ap-btn-green ap-btn-sm"><i class="fas fa-plus"></i> Add Plant</a>
            <a href="{{ route('admin.plants.index') }}" class="ap-btn ap-btn-outline ap-btn-sm"><i class="fas fa-list"></i> All Plants</a>
        </div>
    </div>
    <div class="ap-section-card">
        <h3><i class="fas fa-shopping-bag"></i> Order Management</h3>
        <p>Process customer orders, update statuses, manage shipping and deliveries.</p>
        <div class="ap-action-row">
            <a href="{{ route('admin.orders.index') }}" class="ap-btn ap-btn-green ap-btn-sm"><i class="fas fa-eye"></i> View Orders</a>
            <a href="{{ route('admin.orders.index', ['status'=>'pending']) }}" class="ap-btn ap-btn-yellow ap-btn-sm"><i class="fas fa-clock"></i> Pending ({{ $pendingOrders }})</a>
        </div>
    </div>
    <div class="ap-section-card">
        <h3><i class="fas fa-layer-group"></i> Categories</h3>
        <p>Organise plants by category to help customers navigate your store easily.</p>
        <div class="ap-action-row">
            <a href="{{ route('admin.categories.create') }}" class="ap-btn ap-btn-green ap-btn-sm"><i class="fas fa-plus"></i> Add Category</a>
            <a href="{{ route('admin.categories.index') }}" class="ap-btn ap-btn-outline ap-btn-sm"><i class="fas fa-list"></i> All Categories</a>
        </div>
    </div>
    <div class="ap-section-card">
        <h3><i class="fas fa-star"></i> Reviews & Inquiries</h3>
        <p>Moderate customer reviews and respond to contact inquiries promptly.</p>
        <div class="ap-action-row">
            <a href="{{ route('admin.reviews.index') }}" class="ap-btn ap-btn-green ap-btn-sm"><i class="fas fa-star"></i> Reviews</a>
            <a href="{{ route('admin.inquiries.index') }}" class="ap-btn ap-btn-outline ap-btn-sm"><i class="fas fa-envelope"></i> Inquiries</a>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;flex-wrap:wrap;">

    {{-- Recent Orders --}}
    <div class="ap-card">
        <div class="ap-card-header">
            <div class="ap-card-title"><i class="fas fa-shopping-bag"></i> Recent Orders</div>
            <a href="{{ route('admin.orders.index') }}" class="ap-btn ap-btn-gray ap-btn-sm">View All</a>
        </div>
        @if($recentOrders->isEmpty())
            <div class="ap-empty" style="padding:32px"><i class="fas fa-box-open"></i><p>No orders yet.</p></div>
        @else
        <div class="ap-table-wrap">
            <table class="ap-table">
                <thead>
                    <tr><th>Order</th><th>Customer</th><th>Amount</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td><a href="{{ route('admin.orders.show', $order->id) }}" style="color:var(--ap-green);font-weight:600;text-decoration:none">{{ $order->order_number }}</a></td>
                        <td>{{ $order->user->fname ?? '—' }} {{ $order->user->lname ?? '' }}</td>
                        <td style="font-weight:700">{{ $site['currency_symbol'] ?? '৳' }}{{ number_format($order->total_amount,0) }}</td>
                        <td>
                            @php $sc = match($order->status){
                                'pending'=>'yellow','processing'=>'blue','shipped'=>'purple',
                                'delivered'=>'green','cancelled'=>'red',default=>'gray'}; @endphp
                            <span class="ap-badge ap-badge-{{ $sc }}">{{ ucfirst($order->status) }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    {{-- Low Stock --}}
    <div class="ap-card">
        <div class="ap-card-header">
            <div class="ap-card-title"><i class="fas fa-exclamation-triangle" style="color:var(--ap-yellow)"></i> Low Stock Alert</div>
            <a href="{{ route('admin.plants.index') }}" class="ap-btn ap-btn-gray ap-btn-sm">Manage</a>
        </div>
        @if($lowStock->isEmpty())
            <div class="ap-empty" style="padding:32px"><i class="fas fa-check-circle" style="color:var(--ap-green)"></i><p>All plants are well stocked!</p></div>
        @else
        <div class="ap-table-wrap">
            <table class="ap-table">
                <thead>
                    <tr><th>Plant</th><th>Category</th><th>Stock</th><th>Action</th></tr>
                </thead>
                <tbody>
                    @foreach($lowStock as $plant)
                    <tr>
                        <td>
                            <div class="ap-table-name">{{ $plant->name }}</div>
                        </td>
                        <td><span class="ap-badge ap-badge-green">{{ ucfirst($plant->category) }}</span></td>
                        <td>
                            @if($plant->stock_count == 0)
                                <span class="ap-badge ap-badge-red">Out of Stock</span>
                            @else
                                <span class="ap-badge ap-badge-yellow">{{ $plant->stock_count }} left</span>
                            @endif
                        </td>
                        <td><a href="{{ route('admin.plants.edit', $plant->id) }}" class="ap-btn ap-btn-outline ap-btn-xs">Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
