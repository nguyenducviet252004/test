<?php $__env->startSection('title'); ?>
    Khôi phục tài khoản
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('password.update')); ?>" method="POST" class="container bg-light mt-5"
        style="width: 500px; height: 350px;">
        <h1 class="text-center mb-5 mt-5">Cập nhật mật khẩu mới</h1>
        <?php echo csrf_field(); ?>
        <input type="hidden" name="token" value="<?php echo e($token); ?>">
        <input type="email" name="email" class="form-control mt-3 mb-3" value="<?php echo e(old('email', $email)); ?>" hidden>

        <label for="password">Mật khẩu mới</label>
        <input type="password" name="password" class="form-control mt-3 mb-3">

        <label for="password_confirmation">xác nhận mật khẩu</label>
        <input type="password" name="password_confirmation" class="form-control mt-3 mb-3">
        
        <div class="text-center">
            <button type="submit" class="btn btn-success">Cập nhật mật khẩu</button>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('account.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\datn-wd110-46\backend\resources\views/account/resetpass.blade.php ENDPATH**/ ?>