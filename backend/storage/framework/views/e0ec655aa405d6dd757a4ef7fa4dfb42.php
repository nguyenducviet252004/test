<?php $__env->startSection('tiltle'); ?>
    Đổi mật khẩu
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_admin'); ?>

<div class="container">
    <div class="d-flex nav nav-pills">
        <a href="<?php echo e(route('admin.edit')); ?>" class="nav-link bg-light">Hồ sơ của tôi</a>
        <a href="<?php echo e(route('admin.changepass.form')); ?>" class="nav-link bg-light">Cập nhật mật khẩu</a>
    </div>

    <h1 class="text-center m-5">Đổi mật khẩu</h1>

    <form action="<?php echo e(route('admin.password.change')); ?>" method="POST" novalidate>
        <?php echo csrf_field(); ?>

        <div>
            <label for="current_password">Mật khẩu hiện tại</label>
            <input type="password" class="form-control mb-3" name="current_password" id="current_password" required value="<?php echo e(old('current_password')); ?>">
            <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger mt-1"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="new_password">Mật khẩu mới</label>
            <input type="password" class="form-control mb-3" name="new_password" id="new_password" required>
            <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger mt-1"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="new_password_confirmation">Xác nhận mật khẩu mới</label>
            <input type="password" class="form-control mb-5" name="new_password_confirmation" id="new_password_confirmation" required>
            <?php $__errorArgs = ['new_password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger mt-1"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success text-center">Đổi mật khẩu</button>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\New folder (2)\backend\resources\views/admin/changepass.blade.php ENDPATH**/ ?>