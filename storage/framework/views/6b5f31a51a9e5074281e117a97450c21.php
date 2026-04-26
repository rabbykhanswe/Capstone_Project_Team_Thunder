

<?php $__env->startSection('title', 'Login - '.($site['site_name'] ?? 'Oronno Plants')); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/login.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">

        
        <div class="text-center mb-8">
            <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center gap-3">
                <img src="<?php echo e(asset('images/footer/logo.png')); ?>" 
                     alt="<?php echo e($site['site_name'] ?? 'Oronno Plants'); ?>" 
                     class="w-14 h-14 object-contain">
                <span class="text-2xl font-extrabold text-gray-800"><?php echo e($site['site_name'] ?? 'Oronno Plants'); ?></span>
            </a>
            <h1 class="text-3xl font-extrabold text-gray-900 mt-6 mb-2">Welcome back!</h1>
            <p class="text-gray-500">Sign in to your account to continue</p>
        </div>

        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            
            <?php if($errors->any()): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-circle mt-0.5 flex-shrink-0"></i>
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>

            <?php if(session('success')): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 flex items-center gap-3">
                <i class="fas fa-check-circle flex-shrink-0"></i>
                <span class="text-sm"><?php echo e(session('success')); ?></span>
            </div>
            <?php endif; ?>

            
            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
                <?php echo csrf_field(); ?>

                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-phone mr-1 text-green-500"></i> Phone Number
                    </label>
                    <div class="flex gap-2">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 px-4 bg-gray-100 border border-gray-300 rounded-xl text-gray-700 font-semibold">
                                +880
                            </div>
                        </div>
                        <input type="text" id="phone" name="phone" value="<?php echo e(old('phone')); ?>"
                               placeholder="1712345678" maxlength="10" required
                               class="flex-1 border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all text-gray-800 <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    </div>
                    <small class="text-gray-500 text-xs mt-1 block">Enter 10 digits (e.g., 1712345678)</small>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-lock mr-1 text-green-500"></i> Password
                        </label>
                        <a href="<?php echo e(route('password.forgot')); ?>" class="text-sm text-green-600 hover:text-green-700 font-medium">
                            Forgot password?
                        </a>
                    </div>
                    <div class="relative">
                        <input type="password" id="password" name="password" placeholder="Enter your password" required
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 pr-12 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all text-gray-800 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <button type="button" id="toggle-password"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-xl transition-colors shadow-md flex items-center justify-center gap-2 text-base">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>

            
            <div class="flex items-center gap-4 my-6">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-xs text-gray-400 font-medium">OR</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            
            <p class="text-center text-gray-600 text-sm">
                Don't have an account?
                <a href="<?php echo e(route('register')); ?>" class="text-green-600 hover:text-green-700 font-bold ml-1">
                    Create one free <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </p>
        </div>

        
        <div class="flex justify-center gap-6 mt-6 text-xs text-gray-400">
            <span><i class="fas fa-shield-alt mr-1 text-green-400"></i>Secure Login</span>
            <span><i class="fas fa-lock mr-1 text-green-400"></i>SSL Encrypted</span>
            <span><i class="fas fa-leaf mr-1 text-green-400"></i>Trusted Store</span>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('toggle-password').addEventListener('click', function () {
    const pw = document.getElementById('password');
    const icon = this.querySelector('i');
    if (pw.type === 'password') {
        pw.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        pw.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\alone\OneDrive\Desktop\Team Thunder\resources\views/auth/login.blade.php ENDPATH**/ ?>