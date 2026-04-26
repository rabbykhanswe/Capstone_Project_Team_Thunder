<?php $__env->startSection('title','Plants'); ?>
<?php $__env->startSection('page-title','Plant Catalogue'); ?>
<?php $__env->startSection('breadcrumb','Plants'); ?>

<?php $__env->startSection('content'); ?>
<div class="ap-page-header">
    <div class="ap-page-header-left">
        <h1><i class="fas fa-seedling"></i> Plant Catalogue</h1>
        <p>Manage your plant inventory, prices, and stock levels</p>
    </div>
    <div style="display:flex;gap:10px;">
        <a href="<?php echo e(route('admin.plants.create')); ?>" class="ap-btn ap-btn-green"><i class="fas fa-plus"></i> Add Plant</a>
    </div>
</div>

<div class="ap-filters">
    <div class="ap-search-wrap">
        <i class="fas fa-search"></i>
        <form method="GET" action="<?php echo e(route('admin.plants.index')); ?>">
            <input class="ap-search-input" type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search plants...">
        </form>
    </div>
    <span class="ap-badge ap-badge-green" style="margin-left:auto;"><?php echo e($plants->total() ?? count($plants)); ?> plants</span>
</div>

<div class="ap-card">
<div class="ap-table-wrap">
<table class="ap-table">
    <thead>
        <tr><th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Seasonal</th><th>Actions</th></tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $plants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td>
                <?php if($plant->image): ?>
                    <img src="<?php echo e(asset('images/plants/'.$plant->image)); ?>" class="ap-table-img">
                <?php else: ?>
                    <div class="ap-table-img-placeholder"><i class="fas fa-leaf"></i></div>
                <?php endif; ?>
            </td>
            <td>
                <div class="ap-table-name"><?php echo e($plant->name); ?></div>
                <?php if($plant->description): ?>
                <div class="ap-table-sub"><?php echo e(Str::limit($plant->description,50)); ?></div>
                <?php endif; ?>
            </td>
            <td><span class="ap-badge ap-badge-outline"><?php echo e(ucfirst($plant->category)); ?></span></td>
            <td>
                <form action="<?php echo e(route('admin.plants.price', $plant->id)); ?>" method="POST" style="display:inline-flex;align-items:center;gap:6px;">
                    <?php echo csrf_field(); ?>
                    <input type="number" name="price" value="<?php echo e($plant->price); ?>" step="0.01" min="0" class="ap-quick-input">
                    <button type="submit" class="ap-btn ap-btn-green ap-btn-xs" title="Save price"><i class="fas fa-save"></i></button>
                </form>
            </td>
            <td>
                <form action="<?php echo e(route('admin.plants.stock', $plant->id)); ?>" method="POST" style="display:inline-flex;align-items:center;gap:6px;">
                    <?php echo csrf_field(); ?>
                    <input type="number" name="stock_count" value="<?php echo e($plant->stock_count); ?>" min="0" class="ap-quick-input">
                    <button type="submit" class="ap-btn ap-btn-green ap-btn-xs" title="Save stock"><i class="fas fa-save"></i></button>
                </form>
                <?php if($plant->stock_count == 0): ?>
                    <span class="ap-badge ap-badge-red" style="margin-top:4px;display:inline-block;">Out of Stock</span>
                <?php elseif($plant->stock_count <= 5): ?>
                    <span class="ap-badge ap-badge-yellow" style="margin-top:4px;display:inline-block;">Low</span>
                <?php endif; ?>
            </td>
            <td>
                <?php if($plant->is_seasonal): ?>
                    <span class="ap-badge ap-badge-purple"><i class="fas fa-sun"></i> <?php echo e(ucfirst($plant->season ?? 'Seasonal')); ?></span>
                <?php else: ?>
                    <span class="ap-badge ap-badge-gray">Year-round</span>
                <?php endif; ?>
            </td>
            <td>
                <div style="display:flex;gap:6px;">
                    <a href="<?php echo e(route('admin.plants.edit', $plant->id)); ?>" class="ap-btn ap-btn-outline ap-btn-xs"><i class="fas fa-edit"></i></a>
                    <form action="<?php echo e(route('admin.plants.destroy', $plant->id)); ?>" method="POST" onsubmit="return confirm('Delete <?php echo e(addslashes($plant->name)); ?>?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="ap-btn ap-btn-red ap-btn-xs"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="7">
            <div class="ap-empty"><i class="fas fa-seedling"></i><h3>No plants found</h3>
            <p><a href="<?php echo e(route('admin.plants.create')); ?>" class="ap-btn ap-btn-green ap-btn-sm" style="margin-top:12px;"><i class="fas fa-plus"></i> Add Your First Plant</a></p></div>
        </td></tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
<?php if(method_exists($plants,'hasPages') && $plants->hasPages()): ?>
<div style="padding:16px 22px;border-top:1px solid var(--ap-border);"><?php echo e($plants->links('vendor.pagination.custom-admin')); ?></div>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\alone\OneDrive\Desktop\Team Thunder\resources\views/admin/plants/index.blade.php ENDPATH**/ ?>