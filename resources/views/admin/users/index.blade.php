@extends('layouts.admin')
@section('title','Users')
@section('page-title','User Management')
@section('breadcrumb','Users')

@section('content')
<div class="ap-page-header">
    <div class="ap-page-header-left">
        <h1><i class="fas fa-users"></i> User Management</h1>
        <p>View and manage all registered customers</p>
    </div>
    <span class="ap-badge ap-badge-green" style="font-size:13px;padding:8px 16px;">{{ $users->total() ?? count($users) }} users</span>
</div>

<div class="ap-filters">
    <div class="ap-search-wrap">
        <i class="fas fa-search"></i>
        <form method="GET" action="{{ route('admin.users') }}">
            <input class="ap-search-input" type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email or phone...">
        </form>
    </div>
</div>

<div class="ap-card">
<div class="ap-table-wrap">
<table class="ap-table">
    <thead>
        <tr><th>Customer</th><th>Email</th><th>Phone</th><th>Orders</th><th>Role</th><th>Joined</th></tr>
    </thead>
    <tbody>
        @forelse($users as $user)
        <tr>
            <td>
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:38px;height:38px;border-radius:8px;background:var(--ap-green-100);display:flex;align-items:center;justify-content:center;color:var(--ap-green);font-weight:800;font-size:14px;flex-shrink:0;">
                        {{ strtoupper(substr($user->fname ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <div class="ap-table-name">{{ $user->fname }} {{ $user->lname }}</div>
                        <div class="ap-table-sub">ID #{{ $user->id }}</div>
                    </div>
                </div>
            </td>
            <td style="color:var(--ap-text-muted);font-size:13px;">{{ $user->email }}</td>
            <td style="font-size:13px;">{{ $user->phone ?? '—' }}</td>
            <td>
                <span class="ap-badge ap-badge-blue">{{ $user->orders_count ?? $user->orders()->count() }} orders</span>
            </td>
            <td>
                @if($user->is_admin)
                    <span class="ap-badge ap-badge-purple"><i class="fas fa-shield-alt"></i> Admin</span>
                @else
                    <span class="ap-badge ap-badge-gray">Customer</span>
                @endif
            </td>
            <td style="color:var(--ap-text-muted);font-size:13px;">{{ $user->created_at->format('d M Y') }}</td>
        </tr>
        @empty
        <tr><td colspan="6">
            <div class="ap-empty"><i class="fas fa-users"></i><h3>No users found</h3><p>Registered customers will appear here.</p></div>
        </td></tr>
        @endforelse
    </tbody>
</table>
</div>
@if(method_exists($users,'hasPages') && $users->hasPages())
<div style="padding:16px 22px;border-top:1px solid var(--ap-border);">{{ $users->links('vendor.pagination.custom-admin') }}</div>
@endif
</div>
@endsection
