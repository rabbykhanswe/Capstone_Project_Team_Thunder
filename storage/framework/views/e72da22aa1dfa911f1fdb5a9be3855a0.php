<?php $__env->startSection('title','Edit Plant'); ?>
<?php $__env->startSection('page-title','Edit Plant'); ?>
<?php $__env->startSection('breadcrumb','Edit Plant'); ?>

<?php $__env->startSection('content'); ?>
<div class="ap-page-header">
    <div class="ap-page-header-left">
        <h1><i class="fas fa-edit"></i> Edit Plant</h1>
        <p>Update details for <strong><?php echo e($plant->name); ?></strong></p>
    </div>
    <a href="<?php echo e(route('admin.plants.index')); ?>" class="ap-btn ap-btn-gray"><i class="fas fa-arrow-left"></i> Back to Plants</a>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:22px;align-items:start;">
    <div>
        <form action="<?php echo e(route('admin.plants.update', $plant->id)); ?>" method="POST" enctype="multipart/form-data" id="plant-edit-form">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

            <div class="ap-card" style="margin-bottom:20px;">
                <div class="ap-card-header"><div class="ap-card-title"><i class="fas fa-info-circle"></i> Basic Information</div></div>
                <div class="ap-card-body">
                    <div class="ap-form-group">
                        <label>Plant Name <span class="req">*</span></label>
                        <input type="text" name="name" value="<?php echo e(old('name',$plant->name)); ?>" class="ap-form-control <?php echo e($errors->has('name')?'error':''); ?>" required>
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
                        <label>Description</label>
                        <textarea name="description" class="ap-form-control" rows="4"><?php echo e(old('description',$plant->description)); ?></textarea>
                    </div>
                    <div class="ap-form-grid">
                        <div class="ap-form-group">
                            <label>Category <span class="req">*</span></label>
                            <select name="category" class="ap-form-control" required>
                                <option value="">Select category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat->name); ?>" <?php echo e(old('category',$plant->category)===$cat->name?'selected':''); ?>><?php echo e(ucfirst($cat->name)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="ap-form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="ap-form-group">
                            <label>Price (<?php echo e($site['currency_symbol'] ?? '৳'); ?>) <span class="req">*</span></label>
                            <input type="number" name="price" value="<?php echo e(old('price',$plant->price)); ?>" class="ap-form-control" step="0.01" min="0" required>
                            <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="ap-form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="ap-form-grid">
                        <div class="ap-form-group">
                            <label>Environment <span class="req">*</span></label>
                            <select name="environment" class="ap-form-control" required>
                                <option value="">Select environment</option>
                                <?php $__currentLoopData = ['indoor','outdoor','both']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $env): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($env); ?>" <?php echo e(old('environment',$plant->environment)===$env?'selected':''); ?>><?php echo e(ucfirst($env)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['environment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="ap-form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="ap-form-group">
                            <label>Plant Type <span class="req">*</span></label>
                            <select name="plant_type" class="ap-form-control" required>
                                <option value="">Select type</option>
                                <?php $__currentLoopData = ['plant','succulent','tool','herb','flowering','foliage']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($pt); ?>" <?php echo e(old('plant_type',$plant->plant_type)===$pt?'selected':''); ?>><?php echo e(ucfirst($pt)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['plant_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="ap-form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="ap-form-group">
                        <label>Stock Count</label>
                        <input type="number" name="stock_count" value="<?php echo e(old('stock_count',$plant->stock_count)); ?>" class="ap-form-control" min="0">
                    </div>
                </div>
            </div>

            <div class="ap-card" style="margin-bottom:20px;">
                <div class="ap-card-header"><div class="ap-card-title"><i class="fas fa-sun"></i> Seasonal Info</div></div>
                <div class="ap-card-body">
                    <div class="ap-form-group">
                        <label class="ap-form-check">
                            <input type="checkbox" name="is_seasonal" value="1" id="isSeasonalChk"
                                <?php echo e(old('is_seasonal',$plant->is_seasonal)?'checked':''); ?>

                                onchange="document.getElementById('seasonField').style.display=this.checked?'block':'none'">
                            <span>This is a seasonal plant</span>
                        </label>
                    </div>
                    <div id="seasonField" style="display:<?php echo e(old('is_seasonal',$plant->is_seasonal)?'block':'none'); ?>">
                        <div class="ap-form-group">
                            <label>Season</label>
                            <select name="season" class="ap-form-control">
                                <option value="">Select season</option>
                                <?php $__currentLoopData = ['spring','summer','autumn','winter','monsoon']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s); ?>" <?php echo e(old('season',$plant->season)===$s?'selected':''); ?>><?php echo e(ucfirst($s)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ap-form-actions">
                <button type="submit" class="ap-btn ap-btn-green"><i class="fas fa-save"></i> Update Plant</button>
                <a href="<?php echo e(route('admin.plants.index')); ?>" class="ap-btn ap-btn-gray">Cancel</a>
                <button type="button" class="ap-btn ap-btn-red" style="margin-left:auto;" onclick="if(confirm('Delete this plant permanently?')) document.getElementById('plant-delete-form').submit()">
                    <i class="fas fa-trash"></i> Delete Plant
                </button>
            </div>
        </form>

        <form id="plant-delete-form" action="<?php echo e(route('admin.plants.destroy', $plant->id)); ?>" method="POST">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
        </form>
    </div>

    <div class="ap-card">
        <div class="ap-card-header"><div class="ap-card-title"><i class="fas fa-image"></i> Plant Image</div></div>
        <div class="ap-card-body">
            <?php if($plant->image): ?>
            <img src="<?php echo e(asset('images/plants/'.$plant->image)); ?>" id="imgPreview" style="width:100%;border-radius:10px;object-fit:cover;max-height:200px;margin-bottom:12px;">
            <?php else: ?>
            <img id="imgPreview" src="" style="display:none;width:100%;border-radius:10px;object-fit:cover;max-height:200px;margin-bottom:12px;">
            <?php endif; ?>
            <div class="ap-form-group">
                <label>Replace Image</label>
                <input type="file" name="image" class="ap-form-control" accept="image/*" form="plant-edit-form"
                    onchange="var r=new FileReader();r.onload=function(e){document.getElementById('imgPreview').src=e.target.result;document.getElementById('imgPreview').style.display='block';};r.readAsDataURL(this.files[0])">
                <div class="ap-form-hint">Leave blank to keep current image</div>
                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="ap-form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\alone\OneDrive\Desktop\Team Thunder\resources\views/admin/plants/edit.blade.php ENDPATH**/ ?>