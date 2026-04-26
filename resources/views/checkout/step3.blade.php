@extends('layouts.app')
@section('title', 'Checkout — Review Order')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endpush
@section('content')
<div class="checkout-page">
<div class="checkout-container">

    {{-- Stepper --}}
    <div class="checkout-stepper">
        <div class="step-item">
            <div class="step-circle done"><i class="fas fa-check"></i></div>
            <span class="step-label">Address</span>
        </div>
        <div class="step-line done"></div>
        <div class="step-item">
            <div class="step-circle done"><i class="fas fa-check"></i></div>
            <span class="step-label">Payment</span>
        </div>
        <div class="step-line done"></div>
        <div class="step-item">
            <div class="step-circle active">3</div>
            <span class="step-label active">Review</span>
        </div>
    </div>

    <div class="checkout-body">

        {{-- Review Details --}}
        <div>
            <a href="{{ route('checkout.step2') }}" class="btn-checkout-back"><i class="fas fa-arrow-left"></i> Back to Payment</a>
            <div class="checkout-card">
                <h2 class="checkout-card-title"><i class="fas fa-clipboard-check"></i> Review Your Order</h2>

                {{-- Delivery Info --}}
                <div class="review-box">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <div class="review-box-label"><i class="fas fa-map-marker-alt mr-1"></i> Delivery Address</div>
                        <a href="{{ route('checkout.step1') }}" class="review-change-link">Change</a>
                    </div>
                    <div class="review-box-value" style="margin-top:0.5rem;">
                        <strong>{{ $address['shipping_name'] }}</strong> &nbsp;|&nbsp; {{ $address['shipping_phone'] }}<br>
                        {{ $address['shipping_address'] }}, {{ $address['shipping_city'] }}
                        @if($address['shipping_postal_code']) - {{ $address['shipping_postal_code'] }} @endif
                    </div>
                </div>

                {{-- Payment Info --}}
                <div class="review-box">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <div class="review-box-label"><i class="fas fa-wallet mr-1"></i> Payment Method</div>
                        <a href="{{ route('checkout.step2') }}" class="review-change-link">Change</a>
                    </div>
                    <div class="review-box-value" style="margin-top:0.5rem;">
                        @php
                            $paymentLabels = [
                                'cash_on_delivery' => '<i class="fas fa-money-bill-wave mr-2" style="color:#16a34a;"></i>Cash on Delivery',
                                'bkash'  => '<i class="fas fa-mobile-alt mr-2" style="color:#e2136e;"></i>bKash',
                                'nagad'  => '<i class="fas fa-mobile-alt mr-2" style="color:#f7941d;"></i>Nagad',
                                'rocket' => '<i class="fas fa-mobile-alt mr-2" style="color:#8b21b8;"></i>Rocket',
                            ];
                        @endphp
                        {!! $paymentLabels[$payment['payment_method']] ?? ucfirst($payment['payment_method']) !!}
                    </div>
                </div>

                {{-- Items List --}}
                <div class="review-box">
                    <div class="review-box-label"><i class="fas fa-seedling mr-1"></i> Order Items ({{ count($cartItems) }})</div>
                    @foreach($cartItems as $item)
                    <div class="summary-item" style="margin-top:0.5rem;">
                        @if($item['plant']->image)
                            <img src="{{ asset('images/plants/' . $item['plant']->image) }}" class="summary-item-img" alt="{{ $item['plant']->name }}">
                        @else
                            <div class="summary-item-img-placeholder"><i class="fas fa-leaf"></i></div>
                        @endif
                        <div style="flex:1;">
                            <div class="summary-item-name">{{ $item['plant']->name }}</div>
                            <div class="summary-item-qty">Qty: {{ $item['quantity'] }} × ৳{{ number_format($item['plant']->price, 2) }}</div>
                        </div>
                        <div class="summary-item-price">৳{{ number_format($item['item_total'], 2) }}</div>
                    </div>
                    @endforeach
                </div>

                {{-- Place Order Form --}}
                <form action="{{ route('checkout.place') }}" method="POST">
                    @csrf
                    <div class="form-row-full form-group" style="margin-bottom:1rem;">
                        <label class="form-label">Order Notes (optional)</label>
                        <textarea name="notes" class="form-input form-textarea" placeholder="Any special instructions for delivery..."></textarea>
                    </div>
                    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:0.75rem;padding:1rem;margin-bottom:1rem;font-size:0.875rem;color:#166534;">
                        <i class="fas fa-info-circle mr-2"></i>
                        By placing your order you agree to our terms. You'll receive an SMS confirmation on your registered phone.
                    </div>
                    <button type="submit" class="btn-checkout-primary">
                        <i class="fas fa-check-circle"></i> Place Order — ৳{{ number_format($total, 2) }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Price Summary --}}
        <div class="order-summary-card">
            <div class="order-summary-title"><i class="fas fa-receipt mr-2 text-green-600"></i>Price Breakdown</div>
            @foreach($cartItems as $item)
            <div class="summary-item">
                <div class="summary-item-img-placeholder"><i class="fas fa-leaf"></i></div>
                <div>
                    <div class="summary-item-name">{{ $item['plant']->name }}</div>
                    <div class="summary-item-qty">× {{ $item['quantity'] }}</div>
                </div>
                <div class="summary-item-price">৳{{ number_format($item['item_total'], 2) }}</div>
            </div>
            @endforeach
            <div class="summary-totals">
                <div class="summary-row"><span>Subtotal</span><span>৳{{ number_format($subtotal, 2) }}</span></div>
                <div class="summary-row"><span>Shipping Fee</span><span>৳{{ number_format($shippingFee, 2) }}</span></div>
                <div class="summary-row-total"><span>Total Payable</span><span>৳{{ number_format($total, 2) }}</span></div>
            </div>
        </div>

    </div>
</div>
</div>
@endsection
