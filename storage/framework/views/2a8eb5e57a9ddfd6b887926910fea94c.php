<?php if($paginator->hasPages()): ?>
<nav role="navigation" style="display:flex;align-items:center;justify-content:space-between;gap:12px;">
    <p style="font-size:13px;color:#64748b;margin:0;">
        Showing <strong><?php echo e($paginator->firstItem()); ?></strong> to <strong><?php echo e($paginator->lastItem()); ?></strong> of <strong><?php echo e($paginator->total()); ?></strong>
    </p>
    <div style="display:flex;align-items:center;gap:6px;">
        
        <?php if($paginator->onFirstPage()): ?>
            <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 14px;height:32px;background:#f8fafc;color:#94a3b8;border:1.5px solid #e2e8f0;border-radius:6px;font-size:13px;font-weight:600;cursor:not-allowed;">
                <i class="fas fa-chevron-left" style="font-size:11px;"></i> Previous
            </span>
        <?php else: ?>
            <a href="<?php echo e($paginator->previousPageUrl()); ?>" style="display:inline-flex;align-items:center;gap:5px;padding:6px 14px;height:32px;background:#fff;color:#1a2e1e;border:1.5px solid #e2e8f0;border-radius:6px;font-size:13px;font-weight:600;text-decoration:none;transition:all .15s;" onmouseover="this.style.background='#f0fdf4';this.style.borderColor='#16a34a';this.style.color='#16a34a'" onmouseout="this.style.background='#fff';this.style.borderColor='#e2e8f0';this.style.color='#1a2e1e'">
                <i class="fas fa-chevron-left" style="font-size:11px;"></i> Previous
            </a>
        <?php endif; ?>

        
        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(is_string($element)): ?>
                <span style="display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:32px;padding:0 6px;font-size:13px;color:#94a3b8;"><?php echo e($element); ?></span>
            <?php endif; ?>
            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $paginator->currentPage()): ?>
                        <span style="display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:32px;padding:0 8px;background:#16a34a;color:#fff;border-radius:6px;font-size:13px;font-weight:700;"><?php echo e($page); ?></span>
                    <?php else: ?>
                        <a href="<?php echo e($url); ?>" style="display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:32px;padding:0 8px;background:#fff;color:#1a2e1e;border:1.5px solid #e2e8f0;border-radius:6px;font-size:13px;font-weight:600;text-decoration:none;transition:all .15s;" onmouseover="this.style.background='#f0fdf4';this.style.borderColor='#16a34a';this.style.color='#16a34a'" onmouseout="this.style.background='#fff';this.style.borderColor='#e2e8f0';this.style.color='#1a2e1e'"><?php echo e($page); ?></a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php if($paginator->hasMorePages()): ?>
            <a href="<?php echo e($paginator->nextPageUrl()); ?>" style="display:inline-flex;align-items:center;gap:5px;padding:6px 14px;height:32px;background:#fff;color:#1a2e1e;border:1.5px solid #e2e8f0;border-radius:6px;font-size:13px;font-weight:600;text-decoration:none;transition:all .15s;" onmouseover="this.style.background='#f0fdf4';this.style.borderColor='#16a34a';this.style.color='#16a34a'" onmouseout="this.style.background='#fff';this.style.borderColor='#e2e8f0';this.style.color='#1a2e1e'">
                Next <i class="fas fa-chevron-right" style="font-size:11px;"></i>
            </a>
        <?php else: ?>
            <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 14px;height:32px;background:#f8fafc;color:#94a3b8;border:1.5px solid #e2e8f0;border-radius:6px;font-size:13px;font-weight:600;cursor:not-allowed;">
                Next <i class="fas fa-chevron-right" style="font-size:11px;"></i>
            </span>
        <?php endif; ?>
    </div>
</nav>
<?php endif; ?>
<?php /**PATH C:\Users\alone\OneDrive\Desktop\Team Thunder\resources\views/vendor/pagination/custom-admin.blade.php ENDPATH**/ ?>