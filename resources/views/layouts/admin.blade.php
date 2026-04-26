<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — {{ $site['site_name'] ?? 'Oronno Plants' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicone.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-panel.css') }}">
    @stack('styles')
</head>
<body class="admin-body">
<div class="ap-layout">

    {{-- Sidebar --}}
    @include('admin.partials.sidebar')

    {{-- Main --}}
    <div class="ap-main">

        {{-- Topbar --}}
        <header class="ap-topbar">
            <div class="ap-topbar-left">
                <button class="ap-topbar-btn" id="apSidebarToggle" title="Toggle sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <div class="ap-topbar-title">@yield('page-title', 'Dashboard')</div>
                    <div class="ap-breadcrumb">
                        <a href="{{ route('admin.dashboard') }}">Home</a>
                        <span class="ap-breadcrumb-sep">/</span>
                        <span>@yield('breadcrumb', 'Dashboard')</span>
                    </div>
                </div>
            </div>
            <div class="ap-topbar-right">
                <a href="{{ route('home') }}" class="ap-topbar-btn" title="View site" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="ap-topbar-btn" title="Orders">
                    <i class="fas fa-box"></i>
                </a>
                <div class="ap-topbar-user">
                    <div class="ap-topbar-avatar">
                        {{ strtoupper(substr(Auth::user()->fname ?? 'A', 0, 1)) }}
                    </div>
                    <span>{{ Auth::user()->fname ?? 'Admin' }}</span>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <div class="ap-page">
            @if(session('success'))
                <div class="ap-alert ap-alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="ap-alert ap-alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
            @endif

            @yield('content')
        </div>

    </div>
</div>

<script>
document.getElementById('apSidebarToggle')?.addEventListener('click', function() {
    document.querySelector('.ap-sidebar').classList.toggle('open');
});
</script>
@stack('scripts')
</body>
</html>
