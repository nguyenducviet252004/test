<?php $__env->startSection('title'); ?>
    Đổi mật khẩu
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <h2 class="text-center">Đổi mật khẩu</h2>

    <form action="<?php echo e(route('user.password.change')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div>
            <label for="current_password">Mật khẩu hiện tại</label>
            <input type="password" class="form-control mb-3" name="current_password" id="current_password" required value="<?php echo e(old('current_password')); ?>">
        </div>

        <div>
            <label for="new_password">Mật khẩu mới</label>
            <input type="password" class="form-control mb-3" name="new_password" id="new_password" required>
        </div>

        <div>
            <label for="new_password_confirmation">Xác nhận mật khẩu mới</label>
            <input type="password" class="form-control mb-5" name="new_password_confirmation" id="new_password_confirmation" required>
        </div>
        <div class="text-center"> 
            <button type="submit" class="btn btn-success text-center">Đổi mật khẩu</button>
            <a href="<?php echo e(route('user.dashboard')); ?>" class="btn btn-secondary">Quay lai</a>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\datn-wd110-46\backend\resources\views/user/changepass.blade.php ENDPATH**/ ?>