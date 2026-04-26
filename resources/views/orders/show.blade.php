@extends('layouts.app')
@section('title', 'Order #' . $order->order_number)
@push('styles')
<link rel="stylesheet" href="{{ asset('css/orders.css') }}">
@endpush
@section('content')
<div class="orders-page">
<div class="orders-container" style="max-width:960px;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
        <div>
            <a href="{{ route('orders.index') }}" style="color:#16a34a;font-size:0.875rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;margin-bottom:0.5rem;">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
            <h1 class="page-title" style="font-size:1.5rem;">Order #{{ $order->order_number }}</h1>
            <p class="page-sub">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
        </div>
        <div style="display:flex;gap:0.75rem;align-items:center;">
            <span class="status-badge badge-{{ $order->status }}" style="font-size:0.85rem;padding:0.4rem 1rem;">
                {{ ucfirst($order->status) }}
            </span>
            <a href="{{ route('orders.invoice', $order->id) }}" class="btn-order-detail">
                <i class="fas fa-file-invoice mr-1"></i>Invoice
            </a>
        </div>
    </div>

    <div class="order-detail-grid">

        {{-- Left Column --}}
        <div>

            {{-- Tracking Timeline --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <i class="fas fa-map-marked-alt" style="color:#16a34a;"></i>
                    <span class="detail-card-title">Order Tracking</span>
                </div>
                <div class="detail-card-body">
                    @php
                        $steps = [
                            'pending'    => ['label'=>'Order Placed',    'icon'=>'shopping-cart', 'time'=>$order->created_at],
                            'processing' => ['label'=>'Processing',      'icon'=>'cog',           'time'=>null],
                            'shipped'    => ['label'=>'Shipped',         'icon'=>'truck',         'time'=>$order->shipped_at],
                            'delivered'  => ['label'=>'Delivered',       'icon'=>'check-circle',  'time'=>$order->delivered_at],
                        ];
                        $statusOrder = ['pending','processing','shipped','delivered'];
                        $currentIdx  = array_search($order->status, $statusOrder);
                        if ($order->status === 'cancelled') $currentIdx = -1;
                    @endphp

                    @if($order->status === 'cancelled')
                        <div style="text-align:center;padding:1.5rem;color:#dc2626;">
                            <i class="fas fa-times-circle" style="font-size:2.5rem;display:block;margin-bottom:0.75rem;"></i>
                            <strong>This order has been cancelled.</strong>
                        </div>
                    @else
                    <div class="tracking-timeline">
                        @foreach($steps as $key => $step)
                        @php $idx = array_search($key, $statusOrder); $done = $idx <= $currentIdx; $active = $idx === $currentIdx; @endphp
                        <div class="timeline-item {{ !$done ? 'timeline-inactive' : '' }}">
                            <div class="timeline-dot {{ $done ? ($active ? 'active' : 'done') : '' }}"></div>
                            <div class="timeline-label">
                                <i class="fas fa-{{ $step['icon'] }} mr-2" style="color:{{ $done ? '#16a34a' : '#d1d5db' }};"></i>
                                {{ $step['label'] }}
                            </div>
                            <div class="timeline-time">
                                @if($step['time'] && $done){{ $step['time']->format('d M Y, h:i A') }}
                                @elseif($done)Completed
                                @else Pending
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @if($order->tracking_number)
                    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:0.75rem;padding:0.875rem;margin-top:1rem;font-size:0.875rem;">
                        <i class="fas fa-barcode mr-2 text-green-600"></i>
                        <strong>Tracking No:</strong> <span style="font-family:monospace;">{{ $order->tracking_number }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Order Items --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <i class="fas fa-seedling" style="color:#16a34a;"></i>
                    <span class="detail-card-title">Order Items ({{ $order->items->sum('quantity') }})</span>
                </div>
                <div style="overflow-x:auto;">
                    <table class="items-table" style="width:100%;border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th style="text-align:left;padding:0.6rem 1rem;background:#f9fafb;color:#6b7280;font-size:0.75rem;font-weight:700;border-bottom:1px solid #e5e7eb;">Plant</th>
                                <th style="text-align:center;padding:0.6rem;background:#f9fafb;color:#6b7280;font-size:0.75rem;font-weight:700;border-bottom:1px solid #e5e7eb;">Qty</th>
                                <th style="text-align:right;padding:0.6rem 1rem;background:#f9fafb;color:#6b7280;font-size:0.75rem;font-weight:700;border-bottom:1px solid #e5e7eb;">Price</th>
                                <th style="text-align:right;padding:0.6rem 1rem;background:#f9fafb;color:#6b7280;font-size:0.75rem;font-weight:700;border-bottom:1px solid #e5e7eb;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td style="padding:0.875rem 1rem;border-bottom:1px solid #f3f4f6;">
                                    <div style="display:flex;align-items:center;gap:0.75rem;">
                                        @if($item->plant && $item->plant->image)
                                            <img src="{{ asset('images/plants/' . $item->plant->image) }}" class="item-plant-img" alt="{{ $item->plant_name }}">
                                        @else
                                            <div class="item-plant-placeholder"><i class="fas fa-leaf"></i></div>
                                        @endif
                                        <div>
                                            <div class="item-name">{{ $item->plant_name }}</div>
                                            @if($item->plant)
                                            <a href="{{ route('products.show', $item->plant_id) }}" style="font-size:0.75rem;color:#16a34a;text-decoration:none;">View Plant</a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align:center;padding:0.875rem;border-bottom:1px solid #f3f4f6;font-weight:600;">{{ $item->quantity }}</td>
                                <td style="text-align:right;padding:0.875rem 1rem;border-bottom:1px solid #f3f4f6;color:#6b7280;">৳{{ number_format($item->unit_price, 2) }}</td>
                                <td style="text-align:right;padding:0.875rem 1rem;border-bottom:1px solid #f3f4f6;font-weight:700;">৳{{ number_format($item->item_total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- Right Column --}}
        <div>

            {{-- Price Summary --}}
            <div class="detail-card" style="margin-bottom:1rem;">
                <div class="detail-card-header">
                    <i class="fas fa-receipt" style="color:#16a34a;"></i>
                    <span class="detail-card-title">Price Summary</span>
                </div>
                <div class="detail-card-body">
                    <div class="meta-row"><span class="meta-label">Subtotal</span><span class="meta-value">৳{{ number_format($order->subtotal, 2) }}</span></div>
                    <div class="meta-row"><span class="meta-label">Shipping Fee</span><span class="meta-value">৳{{ number_format($order->shipping_fee, 2) }}</span></div>
                    <div class="meta-row" style="border-top:2px solid #e5e7eb;padding-top:0.75rem;margin-top:0.25rem;">
                        <span class="meta-label meta-total-label">Total</span>
                        <span class="meta-value meta-total" style="color:#16a34a;">৳{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    <div class="meta-row" style="margin-top:0.5rem;">
                        <span class="meta-label">Payment</span>
                        <span class="meta-value">{{ $order->payment_method_label }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Payment Status</span>
                        <span class="meta-value" style="color:{{ $order->payment_status === 'paid' ? '#16a34a' : '#f59e0b' }};">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Shipping Info --}}
            <div class="detail-card" style="margin-bottom:1rem;">
                <div class="detail-card-header">
                    <i class="fas fa-map-marker-alt" style="color:#16a34a;"></i>
                    <span class="detail-card-title">Shipping Address</span>
                </div>
                <div class="detail-card-body" style="font-size:0.875rem;line-height:1.8;">
                    <strong>{{ $order->shipping_name }}</strong><br>
                    <i class="fas fa-phone mr-1" style="color:#9ca3af;"></i>{{ $order->shipping_phone }}<br>
                    {{ $order->shipping_address }}<br>
                    {{ $order->shipping_city }}@if($order->shipping_postal_code) - {{ $order->shipping_postal_code }}@endif
                </div>
            </div>

            @if($order->notes)
            <div class="detail-card">
                <div class="detail-card-header">
                    <i class="fas fa-sticky-note" style="color:#f59e0b;"></i>
                    <span class="detail-card-title">Order Notes</span>
                </div>
                <div class="detail-card-body" style="font-size:0.875rem;color:#6b7280;">
                    {{ $order->notes }}
                </div>
            </div>
            @endif

        </div>
    </div>

</div>
</div>
@endsection
