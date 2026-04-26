@php
    $ap_pendingOrders  = \App\Models\Order::whereIn('status',['pending','processing'])->count();
    $ap_pendingReviews = \App\Models\Review::where('status','pending')->count();
    $ap_newInquiries   = \App\Models\ContactInquiry::where('status','new')->count();
    $ap_siteName       = $site['site_name'] ?? 'Oronno Plants';
@endphp
<aside class="ap-sidebar" id="apSidebar">

    {{-- Brand --}}
    <a href="{{ route('admin.dashboard') }}" class="ap-sidebar-brand">
        <img src="{{ asset('images/footer/logo.png') }}" alt="{{ $ap_siteName }}" class="ap-sidebar-logo-img">
        <div class="ap-sidebar-brand-text">
            <span class="ap-sidebar-brand-name">{{ $ap_siteName }}</span>
            <span class="ap-sidebar-brand-sub">Admin Panel</span>
        </div>
    </a>

    <div class="ap-sidebar-section">
        <div class="ap-sidebar-section-label">Overview</div>
        <a href="{{ route('admin.dashboard') }}"
           class="ap-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
    </div>

    <div class="ap-sidebar-section">
        <div class="ap-sidebar-section-label">Catalogue</div>
        <a href="{{ route('admin.plants.index') }}"
           class="ap-nav-link {{ request()->routeIs('admin.plants.*') ? 'active' : '' }}">
            <i class="fas fa-seedling"></i> Plants
        </a>
        <a href="{{ route('admin.categories.index') }}"
           class="ap-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="fas fa-layer-group"></i> Categories
        </a>
    </div>

    <div class="ap-sidebar-section">
        <div class="ap-sidebar-section-label">Sales</div>
        <a href="{{ route('admin.orders.index') }}"
           class="ap-nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-bag"></i> Orders
            @if($ap_pendingOrders > 0)
                <span class="ap-badge">{{ $ap_pendingOrders }}</span>
            @endif
        </a>
    </div>

    <div class="ap-sidebar-section">
        <div class="ap-sidebar-section-label">Community</div>
        <a href="{{ route('admin.reviews.index') }}"
           class="ap-nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <i class="fas fa-star"></i> Reviews
            @if($ap_pendingReviews > 0)
                <span class="ap-badge">{{ $ap_pendingReviews }}</span>
            @endif
        </a>
        <a href="{{ route('admin.inquiries.index') }}"
           class="ap-nav-link {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">
            <i class="fas fa-envelope"></i> Inquiries
            @if($ap_newInquiries > 0)
                <span class="ap-badge">{{ $ap_newInquiries }}</span>
            @endif
        </a>
    </div>

    <div class="ap-sidebar-section">
        <div class="ap-sidebar-section-label">Admin</div>
        <a href="{{ route('admin.users') }}"
           class="ap-nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Users
        </a>
        <a href="{{ route('admin.settings') }}"
           class="ap-nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
            <i class="fas fa-cog"></i> Settings
        </a>
    </div>

    <div class="ap-sidebar-footer">
        <div class="ap-sidebar-user">
            <div class="ap-sidebar-avatar">{{ strtoupper(substr(Auth::user()->fname ?? 'A', 0, 1)) }}</div>
            <div>
                <div class="ap-sidebar-uname">{{ Auth::user()->fname ?? 'Admin' }} {{ Auth::user()->lname ?? '' }}</div>
                <div class="ap-sidebar-urole">Administrator</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="ap-logout-btn">
                <i class="fas fa-sign-out-alt"></i> Sign Out
            </button>
        </form>
    </div>

</aside>
