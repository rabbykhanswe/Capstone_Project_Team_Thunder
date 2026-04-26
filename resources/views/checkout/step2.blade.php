@extends('layouts.app')
@section('title', 'Checkout — Payment Method')
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
            <div class="step-circle active">2</div>
            <span class="step-label active">Payment</span>
        </div>
        <div class="step-line"></div>
        <div class="step-item">
            <div class="step-circle">3</div>
            <span class="step-label">Review</span>
        </div>
    </div>

    <div class="checkout-body">

        {{-- Payment Form --}}
        <div>
            <a href="{{ route('checkout.step1') }}" class="btn-checkout-back"><i class="fas fa-arrow-left"></i> Back to Address</a>
            <div class="checkout-card">
                <h2 class="checkout-card-title"><i class="fas fa-wallet"></i> Payment Method</h2>

                <form action="{{ route('checkout.post.step2') }}" method="POST">
                    @csrf
                    <div class="payment-options">

                        <input type="radio" name="payment_method" id="cod" value="cash_on_delivery" class="payment-option" checked>
                        <label for="cod">
                            <span class="payment-icon"><i class="fas fa-money-bill-wave" style="color:#16a34a;"></i></span>
                            <div>
                                <div class="payment-name">Cash on Delivery</div>
                                <div class="payment-desc">Pay when your order arrives at your door</div>
                            </div>
                        </label>

                        <input type="radio" name="payment_method" id="bkash" value="bkash" class="payment-option">
                        <label for="bkash">
                            <span class="payment-icon"><i class="fas fa-mobile-alt" style="color:#e2136e;"></i></span>
                            <div>
                                <div class="payment-name">bKash</div>
                                <div class="payment-desc">Pay via bKash mobile banking</div>
                            </div>
                        </label>

                        <input type="radio" name="payment_method" id="nagad" value="nagad" class="payment-option">
                        <label for="nagad">
                            <span class="payment-icon"><i class="fas fa-mobile-alt" style="color:#f7941d;"></i></span>
                            <div>
                                <div class="payment-name">Nagad</div>
                                <div class="payment-desc">Pay via Nagad mobile financial service</div>
                            </div>
                        </label>

                        <input type="radio" name="payment_method" id="rocket" value="rocket" class="payment-option">
                        <label for="rocket">
                            <span class="payment-icon"><i class="fas fa-mobile-alt" style="color:#8b21b8;"></i></span>
                            <div>
                                <div class="payment-name">Rocket</div>
                                <div class="payment-desc">Pay via Dutch-Bangla Rocket</div>
                            </div>
                        </label>

                    </div>

                    @error('payment_method')
                        <div style="color:#ef4444;font-size:0.8rem;margin-top:0.5rem;">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn-checkout-primary btn-checkout-mt">
                        Continue to Review <i class="fas fa-arrow-right"></i>
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
                <div class="summary-row"><span>Shipping</span><span>৳{{ number_format($shippingFee, 2) }}</span></div>
                <div class="summary-row-total"><span>Total</span><span>৳{{ number_format($total, 2) }}</span></div>
            </div>
        </div>

    </div>
</div>
</div>
@endsection
