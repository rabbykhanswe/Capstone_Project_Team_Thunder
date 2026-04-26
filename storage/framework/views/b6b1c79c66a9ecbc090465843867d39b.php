<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin Panel'); ?> — <?php echo e($site['site_name'] ?? 'Oronno Plants'); ?></title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicone.png')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('css/admin-panel.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="admin-body">
<div class="ap-layout">

    
    <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <div class="ap-main">

        
        <header class="ap-topbar">
            <div class="ap-topbar-left">
                <button class="ap-topbar-btn" id="apSidebarToggle" title="Toggle sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <div class="ap-topbar-title"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></div>
                    <div class="ap-breadcrumb">
                        <a href="<?php echo e(route('admin.dashboard')); ?>">Home</a>
                        <span class="ap-breadcrumb-sep">/</span>
                        <span><?php echo $__env->yieldContent('breadcrumb', 'Dashboard'); ?></span>
                    </div>
                </div>
            </div>
            <div class="ap-topbar-right">
                <a href="<?php echo e(route('home')); ?>" class="ap-topbar-btn" title="View site" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                </a>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="ap-topbar-btn" title="Orders">
                    <i class="fas fa-box"></i>
                </a>
                <div class="ap-topbar-user">
                    <div class="ap-topbar-avatar">
                        <?php echo e(strtoupper(substr(Auth::user()->fname ?? 'A', 0, 1))); ?>

                    </div>
                    <span><?php echo e(Auth::user()->fname ?? 'Admin'); ?></span>
                </div>
            </div>
        </header>

        
        <div class="ap-page">
            <?php if(session('success')): ?>
                <div class="ap-alert ap-alert-success"><i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="ap-alert ap-alert-danger"><i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>

    </div>
</div>

<script>
document.getElementById('apSidebarToggle')?.addEventListener('click', function() {
    document.querySelector('.ap-sidebar').classList.toggle('open');
});
</script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\alone\OneDrive\Desktop\Team Thunder\resources\views/layouts/admin.blade.php ENDPATH**/ ?>