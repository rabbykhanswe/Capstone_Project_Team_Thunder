@extends('layouts.app')
@section('title', 'My Orders')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/orders.css') }}">
@endpush
@section('content')
<div class="orders-page">
<div class="orders-container">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
        <div>
            <h1 class="page-title"><i class="fas fa-box mr-2 text-green-600"></i>My Orders</h1>
            <p class="page-sub">Track and manage all your plant purchases</p>
        </div>
        <a href="{{ route('products') }}" style="background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;padding:0.5rem 1.25rem;border-radius:9999px;font-size:0.875rem;font-weight:700;text-decoration:none;">
            <i class="fas fa-plus mr-1"></i> Shop More
        </a>
    </div>

    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;padding:0.75rem 1rem;border-radius:0.75rem;margin-bottom:1rem;font-size:0.875rem;">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    @if($orders->isEmpty())
        <div class="empty-orders">
            <i class="fas fa-box-open"></i>
            <h3>No orders yet</h3>
            <p>You haven't placed any orders. <a href="{{ route('products') }}">Start shopping!</a></p>
        </div>
    @else
        @foreach($orders as $order)
        <div class="order-card">
            <div class="order-card-header">
                <div class="order-card-meta">
                    <span class="order-num"># {{ $order->order_number }}</span>
                    <span class="order-date"><i class="fas fa-calendar-alt mr-1"></i>{{ $order->created_at->format('d M Y') }}</span>
                    <span class="order-total">৳{{ number_format($order->total_amount, 2) }}</span>
                    <span class="status-badge badge-{{ $order->status }}">
                        @php $icons = ['pending'=>'clock','processing'=>'cog','shipped'=>'truck','delivered'=>'check-circle','cancelled'=>'times-circle']; @endphp
                        <i class="fas fa-{{ $icons[$order->status] ?? 'circle' }}"></i>
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="order-card-actions">
                    <a href="{{ route('orders.show', $order->id) }}" class="btn-order-detail">
                        <i class="fas fa-eye mr-1"></i>Details
                    </a>
                    <a href="{{ route('orders.invoice', $order->id) }}" style="color:#6b7280;font-size:0.8rem;text-decoration:none;" title="Download Invoice">
                        <i class="fas fa-file-invoice"></i>
                    </a>
                </div>
            </div>
            <div class="order-card-body">
                @foreach($order->items->take(4) as $item)
                <div class="order-item-thumb">
                    <i class="fas fa-leaf"></i> {{ $item->plant_name }}
                    <span style="color:#374151;font-weight:700;">×{{ $item->quantity }}</span>
                </div>
                @endforeach
                @if($order->items->count() > 4)
                <div class="order-item-thumb" style="color:#9ca3af;">+{{ $order->items->count() - 4 }} more</div>
                @endif
            </div>
        </div>
        @endforeach

        <div style="margin-top:1.5rem;">{{ $orders->links() }}</div>
    @endif

</div>
</div>
@endsection
