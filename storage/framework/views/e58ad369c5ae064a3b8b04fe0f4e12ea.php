<?php $__env->startSection('title','Add Category'); ?>
<?php $__env->startSection('page-title','Add Category'); ?>
<?php $__env->startSection('breadcrumb','Add Category'); ?>

<?php $__env->startSection('content'); ?>
<div class="ap-page-header">
    <div class="ap-page-header-left">
        <h1><i class="fas fa-plus-circle"></i> Add New Category</h1>
        <p>Create a new category to organise your plants</p>
    </div>
    <a href="<?php echo e(route('admin.categories.index')); ?>" class="ap-btn ap-btn-gray"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div style="max-width:600px;">
    <div class="ap-card">
        <div class="ap-card-header"><div class="ap-card-title"><i class="fas fa-layer-group"></i> Category Details</div></div>
        <div class="ap-card-body">
            <form action="<?php echo e(route('admin.categories.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="ap-form-group">
                    <label>Category Name <span class="req">*</span></label>
                    <input type="text" name="name" value="<?php echo e(old('name')); ?>" class="ap-form-control <?php echo e($errors->has('name')?'error':''); ?>" placeholder="e.g. Indoor Plants" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="ap-form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="ap-form-group">
                    <label>Slug</label>
                    <input type="text" name="slug" value="<?php echo e(old('slug')); ?>" class="ap-form-control" placeholder="auto-generated from name">
                    <div class="ap-form-hint">Leave blank to auto-generate from the name</div>
                    <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="ap-form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="ap-form-group">
                    <label>Description</label>
                    <textarea name="description" class="ap-form-control" rows="3" placeholder="Brief description of this category"><?php echo e(old('description')); ?></textarea>
                </div>
                <div class="ap-form-group">
                    <label class="ap-form-check">
                        <input type="checkbox" name="is_active" value="1" <?php echo e(old('is_active', '1') ? 'checked' : ''); ?>>
                        <span>Active (visible to customers)</span>
                    </label>
                </div>
                <div class="ap-form-actions">
                    <button type="submit" class="ap-btn ap-btn-green"><i class="fas fa-save"></i> Create Category</button>
                    <a href="<?php echo e(route('admin.categories.index')); ?>" class="ap-btn ap-btn-gray">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\alone\OneDrive\Desktop\Team Thunder\resources\views/admin/categories/create.blade.php ENDPATH**/ ?>