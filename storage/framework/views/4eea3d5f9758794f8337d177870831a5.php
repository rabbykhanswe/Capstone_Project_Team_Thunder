<?php $__env->startSection('title','Categories'); ?>
<?php $__env->startSection('page-title','Categories'); ?>
<?php $__env->startSection('breadcrumb','Categories'); ?>

<?php $__env->startSection('content'); ?>
<div class="ap-page-header">
    <div class="ap-page-header-left">
        <h1><i class="fas fa-layer-group"></i> Plant Categories</h1>
        <p>Organise your plant catalogue with categories</p>
    </div>
    <a href="<?php echo e(route('admin.categories.create')); ?>" class="ap-btn ap-btn-green"><i class="fas fa-plus"></i> Add Category</a>
</div>

<div class="ap-card">
<div class="ap-table-wrap">
<table class="ap-table">
    <thead>
        <tr><th>Name</th><th>Slug</th><th>Plants</th><th>Status</th><th>Description</th><th>Actions</th></tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><div class="ap-table-name"><?php echo e(ucfirst($category->name)); ?></div></td>
            <td><code style="font-size:12px;background:var(--ap-green-50);color:var(--ap-green);padding:2px 8px;border-radius:4px;"><?php echo e($category->slug); ?></code></td>
            <td><span class="ap-badge ap-badge-green"><?php echo e($category->products_count ?? 0); ?> plants</span></td>
            <td>
                <?php if($category->is_active): ?>
                    <span class="ap-badge ap-badge-green">Active</span>
                <?php else: ?>
                    <span class="ap-badge" style="background:#fef2f2;color:#dc2626;">Inactive</span>
                <?php endif; ?>
            </td>
            <td style="color:var(--ap-text-muted);font-size:13px;max-width:220px;"><?php echo e(Str::limit($category->description,60)); ?></td>
            <td>
                <div style="display:flex;gap:6px;">
                    <a href="<?php echo e(route('admin.categories.edit', $category->id)); ?>" class="ap-btn ap-btn-outline ap-btn-xs"><i class="fas fa-edit"></i> Edit</a>
                    <form action="<?php echo e(route('admin.categories.destroy', $category->id)); ?>" method="POST" onsubmit="return confirm('Delete category <?php echo e(addslashes(ucfirst($category->name))); ?>?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="ap-btn ap-btn-red ap-btn-xs"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="5">
            <div class="ap-empty"><i class="fas fa-layer-group"></i><h3>No categories yet</h3>
            <p><a href="<?php echo e(route('admin.categories.create')); ?>" class="ap-btn ap-btn-green ap-btn-sm" style="margin-top:12px;"><i class="fas fa-plus"></i> Add First Category</a></p></div>
        </td></tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\alone\OneDrive\Desktop\Team Thunder\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>