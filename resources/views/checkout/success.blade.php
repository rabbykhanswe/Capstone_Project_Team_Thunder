@extends('layouts.app')
@section('title', 'Order Placed Successfully!')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endpush
@section('content')
<div class="checkout-page">
<div class="success-wrapper">

    <div class="success-icon"><i class="fas fa-check"></i></div>
    <h1 class="success-title">Order Placed!</h1>
    <p class="success-sub">
        Thank you for your order. An SMS confirmation has been sent to your registered phone number.
    </p>

    <div class="success-order-box">
        <div class="success-order-row">
            <span class="success-order-label">Order Number</span>
            <span class="success-order-value" style="font-family:monospace;">{{ $order->order_number }}</span>
        </div>
        <div class="success-order-row">
            <span class="success-order-label">Date</span>
            <span class="success-order-value">{{ $order->created_at->format('d M Y, h:i A') }}</span>
        </div>
        <div class="success-order-row">
            <span class="success-order-label">Items</span>
            <span class="success-order-value">{{ $order->items->sum('quantity') }} item(s)</span>
        </div>
        <div class="success-order-row">
            <span class="success-order-label">Payment</span>
            <span class="success-order-value">{{ $order->payment_method_label }}</span>
        </div>
        <div class="success-order-row">
            <span class="success-order-label">Shipping To</span>
            <span class="success-order-value">{{ $order->shipping_city }}</span>
        </div>
        <div class="success-order-row">
            <span class="success-order-label"><strong>Total Payable</strong></span>
            <span class="success-order-value" style="color:#16a34a;font-size:1.1rem;">৳{{ number_format($order->total_amount, 2) }}</span>
        </div>
    </div>

    <div style="background:#fef9c3;border:1px solid #fde047;border-radius:0.75rem;padding:1rem 1.5rem;margin-bottom:2rem;font-size:0.875rem;color:#854d0e;text-align:left;">
        <i class="fas fa-truck mr-2"></i>
        <strong>Estimated delivery:</strong> 2–5 business days. We'll send you an SMS when your order is shipped.
    </div>

    <div class="success-actions">
        <a href="{{ route('orders.show', $order->id) }}" class="btn-success-primary">
            <i class="fas fa-box mr-2"></i>Track Order
        </a>
        <a href="{{ route('products') }}" class="btn-success-outline">
            <i class="fas fa-leaf mr-2"></i>Continue Shopping
        </a>
    </div>

</div>
</div>
@endsection
