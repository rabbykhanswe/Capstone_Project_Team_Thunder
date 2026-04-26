@extends('layouts.admin')
@section('title','Order #'.$order->order_number)
@section('page-title','Order Details')
@section('breadcrumb','Order #'.$order->order_number)

@section('content')
<div class="ap-page-header">
    <div class="ap-page-header-left">
        <h1><i class="fas fa-receipt"></i> Order #{{ $order->order_number }}</h1>
        <p>{{ $order->created_at->format('d M Y, h:i A') }} &mdash; {{ $order->user->fname ?? 'N/A' }} {{ $order->user->lname ?? '' }}</p>
    </div>
    <div style="display:flex;gap:10px;align-items:center;">
        @php $sc = match($order->status){'pending'=>'yellow','processing'=>'blue','shipped'=>'purple','delivered'=>'green','cancelled'=>'red',default=>'gray'}; @endphp
        <span class="ap-badge ap-badge-{{ $sc }}" style="font-size:13px;padding:6px 14px;">{{ ucfirst($order->status) }}</span>
        <a href="{{ route('admin.orders.index') }}" class="ap-btn ap-btn-gray ap-btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start;">

    {{-- Left column --}}
    <div>
        {{-- Update Status --}}
        <div class="ap-card" style="margin-bottom:20px;">
            <div class="ap-card-header">
                <div class="ap-card-title"><i class="fas fa-edit"></i> Update Status</div>
            </div>
            <div class="ap-card-body">
                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
                    @csrf
                    <div style="flex:1;min-width:160px;">
                        <label class="ap-form-group"><label style="font-size:13px;font-weight:600;margin-bottom:6px;display:block;">New Status</label>
                        <select name="status" class="ap-form-control">
                            @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                            <option value="{{ $s }}" {{ $order->status===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select></label>
                    </div>
                    <div style="flex:1;min-width:160px;">
                        <label style="font-size:13px;font-weight:600;margin-bottom:6px;display:block;">Tracking Number</label>
                        <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" placeholder="e.g. SA123456789BD" class="ap-form-control">
                    </div>
                    <button type="submit" class="ap-btn ap-btn-green"><i class="fas fa-save"></i> Update</button>
                </form>
            </div>
        </div>

        {{-- Order Items --}}
        <div class="ap-card">
            <div class="ap-card-header">
                <div class="ap-card-title"><i class="fas fa-seedling"></i> Order Items</div>
                <span class="ap-badge ap-badge-gray">{{ $order->items->count() }} items</span>
            </div>
            <div class="ap-table-wrap">
                <table class="ap-table">
                    <thead>
                        <tr><th>Plant</th><th style="text-align:center">Qty</th><th style="text-align:right">Unit Price</th><th style="text-align:right">Total</th></tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:12px;">
                                    @if($item->plant && $item->plant->image)
                                        <img src="{{ asset('images/plants/'.$item->plant->image) }}" class="ap-table-img">
                                    @else
                                        <div class="ap-table-img-placeholder"><i class="fas fa-leaf"></i></div>
                                    @endif
                                    <span class="ap-table-name">{{ $item->plant_name }}</span>
                                </div>
                            </td>
                            <td style="text-align:center;font-weight:700;">{{ $item->quantity }}</td>
                            <td style="text-align:right;color:var(--ap-text-muted);">{{ $site['currency_symbol'] ?? '৳' }}{{ number_format($item->unit_price,2) }}</td>
                            <td style="text-align:right;font-weight:700;">{{ $site['currency_symbol'] ?? '৳' }}{{ number_format($item->item_total,2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Right column --}}
    <div style="display:flex;flex-direction:column;gap:16px;">
        <div class="ap-detail-block">
            <h4><i class="fas fa-user" style="margin-right:6px;color:var(--ap-green)"></i>Customer</h4>
            <div class="ap-detail-row"><span>Name</span><span>{{ $order->user->fname ?? 'N/A' }} {{ $order->user->lname ?? '' }}</span></div>
            <div class="ap-detail-row"><span>Phone</span><span>{{ $order->user->phone ?? 'N/A' }}</span></div>
            @if($order->user->email)
            <div class="ap-detail-row"><span>Email</span><span>{{ $order->user->email }}</span></div>
            @endif
        </div>

        <div class="ap-detail-block">
            <h4><i class="fas fa-map-marker-alt" style="margin-right:6px;color:var(--ap-green)"></i>Shipping Address</h4>
            <div class="ap-detail-row"><span>Name</span><span>{{ $order->shipping_name }}</span></div>
            <div class="ap-detail-row"><span>Phone</span><span>{{ $order->shipping_phone }}</span></div>
            <div class="ap-detail-row"><span>Address</span><span>{{ $order->shipping_address }}</span></div>
            <div class="ap-detail-row"><span>City</span><span>{{ $order->shipping_city }}{{ $order->shipping_postal_code ? ', '.$order->shipping_postal_code : '' }}</span></div>
        </div>

        <div class="ap-detail-block">
            <h4><i class="fas fa-receipt" style="margin-right:6px;color:var(--ap-green)"></i>Payment Summary</h4>
            <div class="ap-detail-row"><span>Subtotal</span><span>{{ $site['currency_symbol'] ?? '৳' }}{{ number_format($order->subtotal,2) }}</span></div>
            <div class="ap-detail-row"><span>Shipping</span><span>{{ $site['currency_symbol'] ?? '৳' }}{{ number_format($order->shipping_fee,2) }}</span></div>
            <div class="ap-detail-row" style="padding-top:8px;border-top:1px solid var(--ap-border);margin-top:4px;">
                <span style="font-weight:800;">Total</span>
                <span class="ap-detail-total">{{ $site['currency_symbol'] ?? '৳' }}{{ number_format($order->total_amount,2) }}</span>
            </div>
            <div class="ap-detail-row"><span>Method</span><span>{{ $order->payment_method_label }}</span></div>
            <div class="ap-detail-row"><span>Pay Status</span>
                <span class="ap-badge {{ $order->payment_status==='paid'?'ap-badge-green':'ap-badge-yellow' }}">{{ ucfirst($order->payment_status) }}</span>
            </div>
            @if($order->tracking_number)
            <div class="ap-detail-row"><span>Tracking</span><span style="font-family:monospace;font-size:12px;">{{ $order->tracking_number }}</span></div>
            @endif
        </div>

        @if($order->notes)
        <div class="ap-detail-block">
            <h4><i class="fas fa-sticky-note" style="margin-right:6px;color:var(--ap-green)"></i>Notes</h4>
            <p style="font-size:13.5px;color:var(--ap-text-muted);line-height:1.6;">{{ $order->notes }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
