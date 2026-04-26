@extends('layouts.app')
@section('title', 'Invoice #' . $order->order_number)
@push('styles')
<link rel="stylesheet" href="{{ asset('css/orders.css') }}">
@endpush
@section('content')
<div class="invoice-page">

    {{-- Print Controls --}}
    <div class="no-print" style="background:#f9fafb;border-bottom:1px solid #e5e7eb;padding:0.875rem 2rem;display:flex;align-items:center;justify-content:space-between;">
        <a href="{{ route('orders.show', $order->id) }}" class="btn-back-link">
            <i class="fas fa-arrow-left mr-1"></i> Back to Order
        </a>
        <div style="display:flex;gap:0.75rem;">
            <button onclick="window.print()" class="btn-print">
                <i class="fas fa-print mr-2"></i>Print / Download PDF
            </button>
        </div>
    </div>

    <div class="invoice-container">

        {{-- Invoice Header --}}
        <div class="invoice-header">
            <div>
                <div class="invoice-logo">{{ $site['site_name'] ?? 'Oronno Plants' }}</div>
                <div style="font-size:0.8rem;color:#6b7280;margin-top:0.25rem;">{{ $site['contact_address'] ?? 'Dhaka, Bangladesh' }}</div>
                <div style="font-size:0.8rem;color:#6b7280;">{{ $site['contact_phone'] ?? '+8801920202157' }}</div>
                <div style="font-size:0.8rem;color:#6b7280;">{{ $site['contact_email'] ?? 'oronnoplants@gmail.com' }}</div>
            </div>
            <div>
                <div class="invoice-title">INVOICE</div>
                <div class="invoice-subtitle"># {{ $order->order_number }}</div>
                <div class="invoice-subtitle">Date: {{ $order->created_at->format('d M Y') }}</div>
                <div style="margin-top:0.5rem;">
                    <span class="status-badge badge-{{ $order->status }}" style="font-size:0.75rem;">{{ ucfirst($order->status) }}</span>
                </div>
            </div>
        </div>

        <hr class="invoice-divider">

        {{-- Parties --}}
        <div class="invoice-parties">
            <div>
                <div class="invoice-party-label">Bill From</div>
                <div class="invoice-party-value">
                    <strong>{{ $site['site_name'] ?? 'Oronno Plants' }}</strong><br>
                    {{ $site['contact_address'] ?? 'Dhaka, Bangladesh' }}<br>
                    {{ $site['contact_phone'] ?? '+8801920202157' }}<br>
                    {{ $site['contact_email'] ?? 'oronnoplants@gmail.com' }}
                </div>
            </div>
            <div>
                <div class="invoice-party-label">Bill To</div>
                <div class="invoice-party-value">
                    <strong>{{ $order->shipping_name }}</strong><br>
                    {{ $order->shipping_phone }}<br>
                    {{ $order->shipping_address }}<br>
                    {{ $order->shipping_city }}@if($order->shipping_postal_code) - {{ $order->shipping_postal_code }}@endif
                </div>
            </div>
        </div>

        {{-- Items Table --}}
        <table class="invoice-items-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Plant / Item</th>
                    <th style="text-align:center;">Qty</th>
                    <th style="text-align:right;">Unit Price</th>
                    <th style="text-align:right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $i => $item)
                <tr>
                    <td style="color:#9ca3af;">{{ $i + 1 }}</td>
                    <td><strong>{{ $item->plant_name }}</strong></td>
                    <td style="text-align:center;">{{ $item->quantity }}</td>
                    <td style="text-align:right;">৳{{ number_format($item->unit_price, 2) }}</td>
                    <td style="text-align:right;font-weight:700;">৳{{ number_format($item->item_total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        <div class="invoice-totals">
            <div class="invoice-total-row"><span>Subtotal</span><span>৳{{ number_format($order->subtotal, 2) }}</span></div>
            <div class="invoice-total-row"><span>Shipping Fee</span><span>৳{{ number_format($order->shipping_fee, 2) }}</span></div>
            <div class="invoice-total-final"><span>Total Payable</span><span>৳{{ number_format($order->total_amount, 2) }}</span></div>
        </div>

        {{-- Payment Info --}}
        <div style="margin-top:2rem;padding:1rem;background:#f9fafb;border-radius:0.75rem;font-size:0.875rem;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div><span style="color:#9ca3af;">Payment Method:</span><br><strong>{{ $order->payment_method_label }}</strong></div>
                <div><span style="color:#9ca3af;">Payment Status:</span><br>
                    <strong style="color:{{ $order->payment_status === 'paid' ? '#16a34a' : '#f59e0b' }};">{{ ucfirst($order->payment_status) }}</strong>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="invoice-footer">
            <p>Thank you for shopping with <strong>{{ $site['site_name'] ?? 'Oronno Plants' }}</strong>!</p>
            <p style="margin-top:0.25rem;">For queries, contact us at {{ $site['contact_email'] ?? 'oronnoplants@gmail.com' }} or {{ $site['contact_phone'] ?? '+8801920202157' }}</p>
        </div>

    </div>
</div>
@endsection
