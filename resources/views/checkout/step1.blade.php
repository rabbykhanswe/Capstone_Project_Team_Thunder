@extends('layouts.app')
@section('title', 'Checkout — Delivery Address')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endpush
@section('content')
<div class="checkout-page">
<div class="checkout-container">

    {{-- Stepper --}}
    <div class="checkout-stepper">
        <div class="step-item">
            <div class="step-circle active">1</div>
            <span class="step-label active">Address</span>
        </div>
        <div class="step-line"></div>
        <div class="step-item">
            <div class="step-circle">2</div>
            <span class="step-label">Payment</span>
        </div>
        <div class="step-line"></div>
        <div class="step-item">
            <div class="step-circle">3</div>
            <span class="step-label">Review</span>
        </div>
    </div>

    <div class="checkout-body">

        {{-- Address Form --}}
        <div>
            <a href="{{ route('cart') }}" class="btn-checkout-back"><i class="fas fa-arrow-left"></i> Back to Cart</a>
            <div class="checkout-card">
                <h2 class="checkout-card-title"><i class="fas fa-map-marker-alt"></i> Delivery Address</h2>

                @if($errors->any())
                <div style="background:#fef2f2;border:1px solid #fecaca;color:#dc2626;padding:0.75rem 1rem;border-radius:0.5rem;margin-bottom:1rem;font-size:0.875rem;">
                    @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
                </div>
                @endif

                <form action="{{ route('checkout.post.step1') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Full Name <span>*</span></label>
                            <input type="text" name="shipping_name" class="form-input"
                                value="{{ old('shipping_name', $user->fname . ' ' . $user->lname) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone Number <span>*</span></label>
                            <input type="text" name="shipping_phone" class="form-input"
                                value="{{ old('shipping_phone', $user->phone) }}" required>
                        </div>
                    </div>
                    <div class="form-row-full form-group">
                        <label class="form-label">Full Address <span>*</span></label>
                        <input type="text" name="shipping_address" class="form-input"
                            value="{{ old('shipping_address', $user->address) }}"
                            placeholder="House/Flat, Road, Area" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">City <span>*</span></label>
                            <input type="text" name="shipping_city" class="form-input"
                                value="{{ old('shipping_city', $user->city ?? 'Dhaka') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Postal Code</label>
                            <input type="text" name="shipping_postal_code" class="form-input"
                                value="{{ old('shipping_postal_code', $user->postal_code) }}"
                                placeholder="e.g. 1212">
                        </div>
                    </div>
                    <button type="submit" class="btn-checkout-primary btn-checkout-mt">
                        Continue to Payment <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- Order Summary --}}
        <div class="order-summary-card">
            <div class="order-summary-title"><i class="fas fa-receipt mr-2 text-green-600"></i>Order Summary</div>
            @foreach($cartItems as $item)
            <div class="summary-item">
                <div class="summary-item-img-placeholder"><i class="fas fa-leaf"></i></div>
                <div>
                    <div class="summary-item-name">{{ $item['plant']->name }}</div>
                    <div class="summary-item-qty">Qty: {{ $item['quantity'] }}</div>
                </div>
                <div class="summary-item-price">৳{{ number_format($item['item_total'], 2) }}</div>
            </div>
            @endforeach
            <div class="summary-totals">
                <div class="summary-row"><span>Subtotal</span><span>৳{{ number_format($subtotal, 2) }}</span></div>
                <div class="summary-row"><span>Shipping</span><span>৳60.00</span></div>
                <div class="summary-row-total"><span>Total</span><span>৳{{ number_format($subtotal + 60, 2) }}</span></div>
            </div>
        </div>

    </div>
</div>
</div>
@endsection
