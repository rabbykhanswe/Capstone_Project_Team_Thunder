<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('breadcrumb', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $totalPlants     = \App\Models\Plant::count();
    $totalUsers      = \App\Models\User::count();
    $totalCategories = \App\Models\Category::count();
    $totalOrders     = \App\Models\Order::count();
    $pendingOrders   = \App\Models\Order::whereIn('status',['pending','processing'])->count();
    $totalReviews    = \App\Models\Review::count();
    $pendingReviews  = \App\Models\Review::where('status','pending')->count();
    $newInquiries    = \App\Models\ContactInquiry::where('status','new')->count();
    $recentOrders    = \App\Models\Order::with('user')->latest()->take(6)->get();
    $lowStock        = \App\Models\Plant::where('stock_count','<=',5)->orderBy('stock_count')->take(5)->get();
?>


<div class="ap-stats">
    <div class="ap-stat">
        <div class="ap-stat-icon green"><i class="fas fa-seedling"></i></div>
        <div>
            <div class="ap-stat-num"><?php echo e($totalPlants); ?></div>
            <div class="ap-stat-label">Total Plants</div>
            <div class="ap-stat-sub"><a href="<?php echo e(route('admin.plants.index')); ?>" style="color:inherit">Manage →</a></div>
        </div>
    </div>
    <div class="ap-stat">
        <div class="ap-stat-icon blue"><i class="fas fa-users"></i></div>
        <div>
            <div class="ap-stat-num"><?php echo e($totalUsers); ?></div>
            <div class="ap-stat-label">Registered Users</div>
            <div class="ap-stat-sub"><a href="<?php echo e(route('admin.users')); ?>" style="color:inherit">View →</a></div>
        </div>
    </div>
    <div class="ap-stat">
        <div class="ap-stat-icon yellow"><i class="fas fa-shopping-bag"></i></div>
        <div>
            <div class="ap-stat-num"><?php echo e($totalOrders); ?></div>
            <div class="ap-stat-label">Total Orders</div>
            <?php if($pendingOrders): ?>
            <div class="ap-stat-sub"><?php echo e($pendingOrders); ?> pending</div>
            <?php endif; ?>
        </div>
    </div>
    <div class="ap-stat">
        <div class="ap-stat-icon purple"><i class="fas fa-star"></i></div>
        <div>
            <div class="ap-stat-num"><?php echo e($totalReviews); ?></div>
            <div class="ap-stat-label">Reviews</div>
            <?php if($pendingReviews): ?>
            <div class="ap-stat-sub"><?php echo e($pendingReviews); ?> pending</div>
            <?php endif; ?>
        </div>
    </div>
    <div class="ap-stat">
        <div class="ap-stat-icon green"><i class="fas fa-layer-group"></i></div>
        <div>
            <div class="ap-stat-num"><?php echo e($totalCategories); ?></div>
            <div class="ap-stat-label">Categories</div>
            <div class="ap-stat-sub"><a href="<?php echo e(route('admin.categories.index')); ?>" style="color:inherit">Manage →</a></div>
        </div>
    </div>
    <div class="ap-stat">
        <div class="ap-stat-icon red"><i class="fas fa-envelope"></i></div>
        <div>
            <div class="ap-stat-num"><?php echo e($newInquiries); ?></div>
            <div class="ap-stat-label">New Inquiries</div>
            <div class="ap-stat-sub"><a href="<?php echo e(route('admin.inquiries.index')); ?>" style="color:inherit">View →</a></div>
        </div>
    </div>
</div>


<div class="ap-section-grid" style="margin-bottom:28px;">
    <div class="ap-section-card">
        <h3><i class="fas fa-seedling"></i> Plant Catalogue</h3>
        <p>Add new plants, update prices, manage stock levels, and organise your inventory.</p>
        <div class="ap-action-row">
            <a href="<?php echo e(route('admin.plants.create')); ?>" class="ap-btn ap-btn-green ap-btn-sm"><i class="fas fa-plus"></i> Add Plant</a>
            <a href="<?php echo e(route('admin.plants.index')); ?>" class="ap-btn ap-btn-outline ap-btn-sm"><i class="fas fa-list"></i> All Plants</a>
        </div>
    </div>
    <div class="ap-section-card">
        <h3><i class="fas fa-shopping-bag"></i> Order Management</h3>
        <p>Process customer orders, update statuses, manage shipping and deliveries.</p>
        <div class="ap-action-row">
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="ap-btn ap-btn-green ap-btn-sm"><i class="fas fa-eye"></i> View Orders</a>
            <a href="<?php echo e(route('admin.orders.index', ['status'=>'pending'])); ?>" class="ap-btn ap-btn-yellow ap-btn-sm"><i class="fas fa-clock"></i> Pending (<?php echo e($pendingOrders); ?>)</a>
        </div>
    </div>
    <div class="ap-section-card">
        <h3><i class="fas fa-layer-group"></i> Categories</h3>
        <p>Organise plants by category to help customers navigate your store easily.</p>
        <div class="ap-action-row">
            <a href="<?php echo e(route('admin.categories.create')); ?>" class="ap-btn ap-btn-green ap-btn-sm"><i class="fas fa-plus"></i> Add Category</a>
            <a href="<?php echo e(route('admin.categories.index')); ?>" class="ap-btn ap-btn-outline ap-btn-sm"><i class="fas fa-list"></i> All Categories</a>
        </div>
    </div>
    <div class="ap-section-card">
        <h3><i class="fas fa-star"></i> Reviews & Inquiries</h3>
        <p>Moderate customer reviews and respond to contact inquiries promptly.</p>
        <div class="ap-action-row">
            <a href="<?php echo e(route('admin.reviews.index')); ?>" class="ap-btn ap-btn-green ap-btn-sm"><i class="fas fa-star"></i> Reviews</a>
            <a href="<?php echo e(route('admin.inquiries.index')); ?>" class="ap-btn ap-btn-outline ap-btn-sm"><i class="fas fa-envelope"></i> Inquiries</a>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;flex-wrap:wrap;">

    
    <div class="ap-card">
        <div class="ap-card-header">
            <div class="ap-card-title"><i class="fas fa-shopping-bag"></i> Recent Orders</div>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="ap-btn ap-btn-gray ap-btn-sm">View All</a>
        </div>
        <?php if($recentOrders->isEmpty()): ?>
            <div class="ap-empty" style="padding:32px"><i class="fas fa-box-open"></i><p>No orders yet.</p></div>
        <?php else: ?>
        <div class="ap-table-wrap">
            <table class="ap-table">
                <thead>
                    <tr><th>Order</th><th>Customer</th><th>Amount</th><th>Status</th></tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" style="color:var(--ap-green);font-weight:600;text-decoration:none"><?php echo e($order->order_number); ?></a></td>
                        <td><?php echo e($order->user->fname ?? '—'); ?> <?php echo e($order->user->lname ?? ''); ?></td>
                        <td style="font-weight:700"><?php echo e($site['currency_symbol'] ?? '৳'); ?><?php echo e(number_format($order->total_amount,0)); ?></td>
                        <td>
                            <?php $sc = match($order->status){
                                'pending'=>'yellow','processing'=>'blue','shipped'=>'purple',
                                'delivered'=>'green','cancelled'=>'red',default=>'gray'}; ?>
                            <span class="ap-badge ap-badge-<?php echo e($sc); ?>"><?php echo e(ucfirst($order->status)); ?></span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>

    
    <div class="ap-card">
        <div class="ap-card-header">
            <div class="ap-card-title"><i class="fas fa-exclamation-triangle" style="color:var(--ap-yellow)"></i> Low Stock Alert</div>
            <a href="<?php echo e(route('admin.plants.index')); ?>" class="ap-btn ap-btn-gray ap-btn-sm">Manage</a>
        </div>
        <?php if($lowStock->isEmpty()): ?>
            <div class="ap-empty" style="padding:32px"><i class="fas fa-check-circle" style="color:var(--ap-green)"></i><p>All plants are well stocked!</p></div>
        <?php else: ?>
        <div class="ap-table-wrap">
            <table class="ap-table">
                <thead>
                    <tr><th>Plant</th><th>Category</th><th>Stock</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $lowStock; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <div class="ap-table-name"><?php echo e($plant->name); ?></div>
                        </td>
                        <td><span class="ap-badge ap-badge-green"><?php echo e(ucfirst($plant->category)); ?></span></td>
                        <td>
                            <?php if($plant->stock_count == 0): ?>
                                <span class="ap-badge ap-badge-red">Out of Stock</span>
                            <?php else: ?>
                                <span class="ap-badge ap-badge-yellow"><?php echo e($plant->stock_count); ?> left</span>
                            <?php endif; ?>
                        </td>
                        <td><a href="<?php echo e(route('admin.plants.edit', $plant->id)); ?>" class="ap-btn ap-btn-outline ap-btn-xs">Edit</a></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\alone\OneDrive\Desktop\Team Thunder\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>