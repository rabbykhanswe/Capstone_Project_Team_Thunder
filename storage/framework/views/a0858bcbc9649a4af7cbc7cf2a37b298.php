<?php
    $ap_pendingOrders  = \App\Models\Order::whereIn('status',['pending','processing'])->count();
    $ap_pendingReviews = \App\Models\Review::where('status','pending')->count();
    $ap_newInquiries   = \App\Models\ContactInquiry::where('status','new')->count();
    $ap_siteName       = $site['site_name'] ?? 'Oronno Plants';
?>
<aside class="ap-sidebar" id="apSidebar">

    
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="ap-sidebar-brand">
        <img src="<?php echo e(asset('images/footer/logo.png')); ?>" alt="<?php echo e($ap_siteName); ?>" class="ap-sidebar-logo-img">
        <div class="ap-sidebar-brand-text">
            <span class="ap-sidebar-brand-name"><?php echo e($ap_siteName); ?></span>
            <span class="ap-sidebar-brand-sub">Admin Panel</span>
        </div>
    </a>

    <div class="ap-sidebar-section">
        <div class="ap-sidebar-section-label">Overview</div>
        <a href="<?php echo e(route('admin.dashboard')); ?>"
           class="ap-nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
    </div>

    <div class="ap-sidebar-section">
        <div class="ap-sidebar-section-label">Catalogue</div>
        <a href="<?php echo e(route('admin.plants.index')); ?>"
           class="ap-nav-link <?php echo e(request()->routeIs('admin.plants.*') ? 'active' : ''); ?>">
            <i class="fas fa-seedling"></i> Plants
        </a>
        <a href="<?php echo e(route('admin.categories.index')); ?>"
           class="ap-nav-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
            <i class="fas fa-layer-group"></i> Categories
        </a>
    </div>

    <div class="ap-sidebar-section">
        <div class="ap-sidebar-section-label">Sales</div>
        <a href="<?php echo e(route('admin.orders.index')); ?>"
           class="ap-nav-link <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>">
            <i class="fas fa-shopping-bag"></i> Orders
            <?php if($ap_pendingOrders > 0): ?>
                <span class="ap-badge"><?php echo e($ap_pendingOrders); ?></span>
            <?php endif; ?>
        </a>
    </div>

    <div class="ap-sidebar-section">
        <div class="ap-sidebar-section-label">Community</div>
        <a href="<?php echo e(route('admin.reviews.index')); ?>"
           class="ap-nav-link <?php echo e(request()->routeIs('admin.reviews.*') ? 'active' : ''); ?>">
            <i class="fas fa-star"></i> Reviews
            <?php if($ap_pendingReviews > 0): ?>
                <span class="ap-badge"><?php echo e($ap_pendingReviews); ?></span>
            <?php endif; ?>
        </a>
        <a href="<?php echo e(route('admin.inquiries.index')); ?>"
           class="ap-nav-link <?php echo e(request()->routeIs('admin.inquiries.*') ? 'active' : ''); ?>">
            <i class="fas fa-envelope"></i> Inquiries
            <?php if($ap_newInquiries > 0): ?>
                <span class="ap-badge"><?php echo e($ap_newInquiries); ?></span>
            <?php endif; ?>
        </a>
    </div>

    <div class="ap-sidebar-section">
        <div class="ap-sidebar-section-label">Admin</div>
        <a href="<?php echo e(route('admin.users')); ?>"
           class="ap-nav-link <?php echo e(request()->routeIs('admin.users') ? 'active' : ''); ?>">
            <i class="fas fa-users"></i> Users
        </a>
        <a href="<?php echo e(route('admin.settings')); ?>"
           class="ap-nav-link <?php echo e(request()->routeIs('admin.settings') ? 'active' : ''); ?>">
            <i class="fas fa-cog"></i> Settings
        </a>
    </div>

    <div class="ap-sidebar-footer">
        <div class="ap-sidebar-user">
            <div class="ap-sidebar-avatar"><?php echo e(strtoupper(substr(Auth::user()->fname ?? 'A', 0, 1))); ?></div>
            <div>
                <div class="ap-sidebar-uname"><?php echo e(Auth::user()->fname ?? 'Admin'); ?> <?php echo e(Auth::user()->lname ?? ''); ?></div>
                <div class="ap-sidebar-urole">Administrator</div>
            </div>
        </div>
        <form action="<?php echo e(route('logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="ap-logout-btn">
                <i class="fas fa-sign-out-alt"></i> Sign Out
            </button>
        </form>
    </div>

</aside>
<?php /**PATH C:\Users\alone\OneDrive\Desktop\Team Thunder\resources\views/admin/partials/sidebar.blade.php ENDPATH**/ ?>