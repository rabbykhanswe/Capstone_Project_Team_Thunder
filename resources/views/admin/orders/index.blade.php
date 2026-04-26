@extends('layouts.admin')
@section('title','Orders')
@section('page-title','Orders Management')
@section('breadcrumb','Orders')
@section('content')

<div class="ap-page-header">
    <div class="ap-page-header-left">
        <h1><i class="fas fa-shopping-bag"></i> Orders Management</h1>
        <p>Review, process and update all customer orders</p>
    </div>
</div>

<div class="ap-filters">
    @foreach([''=>'All Orders','pending'=>'Pending','processing'=>'Processing','shipped'=>'Shipped','delivered'=>'Delivered','cancelled'=>'Cancelled'] as $val=>$label)
    <a href="{{ route('admin.orders.index', $val ? ['status'=>$val] : []) }}"
       class="ap-filter-pill {{ request('status')===$val ? 'active' : '' }}">{{ $label }}</a>
    @endforeach
    <div class="ap-search-wrap" style="margin-left:auto;">
        <i class="fas fa-search"></i>
        <form method="GET" action="{{ route('admin.orders.index') }}">
            @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
            <input class="ap-search-input" type="text" name="search" value="{{ request('search') }}" placeholder="Search order # or customer...">
        </form>
    </div>
</div>

<div class="ap-card">
    <div class="ap-table-wrap">
        <table class="ap-table">
            <thead>
                <tr>
                    <th>Order #</th><th>Customer</th><th>Date</th>
                    <th>Total</th><th>Status</th><th>Payment</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><span style="font-family:monospace;font-weight:700;">{{ $order->order_number }}</span></td>
                    <td>
                        <div class="ap-table-name">{{ $order->user->fname ?? 'N/A' }} {{ $order->user->lname ?? '' }}</div>
                        <div class="ap-table-sub">{{ $order->user->phone ?? '' }}</div>
                    </td>
                    <td style="color:var(--ap-text-muted);font-size:13px;">{{ $order->created_at->format('d M Y') }}</td>
                    <td style="font-weight:700;">{{ $site['currency_symbol'] ?? '৳' }}{{ number_format($order->total_amount,2) }}</td>
                    <td>
                        @php $sc = match($order->status){'pending'=>'yellow','processing'=>'blue','shipped'=>'purple','delivered'=>'green','cancelled'=>'red',default=>'gray'}; @endphp
                        <span class="ap-badge ap-badge-{{ $sc }}">{{ ucfirst($order->status) }}</span>
                    </td>
                    <td>
                        <span class="ap-badge {{ $order->payment_status==='paid' ? 'ap-badge-green' : 'ap-badge-yellow' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="ap-btn ap-btn-outline ap-btn-xs">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7">
                    <div class="ap-empty">
                        <i class="fas fa-box-open"></i>
                        <h3>No orders found</h3>
                        <p>Orders will appear here once customers place them.</p>
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div style="padding:16px 22px;border-top:1px solid var(--ap-border);">{{ $orders->links('vendor.pagination.custom-admin') }}</div>
    @endif
</div>

@endsection
