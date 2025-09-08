<?php $__env->startSection('tiltle'); ?>
    Cập nhật tài khoản
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_admin'); ?>

<div class="container">
    <div class="d-flex nav nav-pills">
        <a href="<?php echo e(route('admin.edit')); ?>" class="nav-link bg-light">Hồ sơ của tôi</a>
        <a href="<?php echo e(route('admin.changepass.form')); ?>" class="nav-link bg-light">Cập nhật mật khẩu</a>
    </div>

    <h1 class="text-center m-5">Cập nhật tài khoản</h1>

    <div class="container">
        <form action="<?php echo e(route('admin.update')); ?>" method="POST" enctype="multipart/form-data" novalidate>
            <?php echo csrf_field(); ?>
            <label for="fullname">Họ và tên</label>
            <input type="text" class="form-control mb-3" name="fullname" id="fullname" value="<?php echo e(old('fullname', Auth::user()->fullname)); ?>">
            <?php $__errorArgs = ['fullname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger mt-1"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    
            <label for="birth_day">Sinh nhật</label>
            <input type="date" class="form-control mb-3" name="birth_day" id="birth_day" value="<?php echo e(old('birth_day', Auth::user()->birth_day)); ?>">
            <?php $__errorArgs = ['birth_day'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger mt-1"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    
            <label for="phone">Số điện thoại</label>
            <input type="text" class="form-control mb-3" name="phone" id="phone" value="<?php echo e(old('phone', Auth::user()->phone)); ?>">
            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger mt-1"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    
            <label for="email">Email</label>
            <input type="email" class="form-control mb-3" id="email" value="<?php echo e(old('email', Auth::user()->email)); ?>" disabled>
            <input type="hidden" name="email" value="<?php echo e(old('email', Auth::user()->email)); ?>">
            
            <label for="address">Địa chỉ</label>
            <input type="text" class="form-control mb-3" name="address" id="address" value="<?php echo e(old('address', Auth::user()->address)); ?>">
            <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger mt-1"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            
            <label for="avatar" class="mt-3">Ảnh đại diện</label>
            <img src="<?php echo e(asset('storage/' . Auth::user()->avatar)); ?>" width="100px" class="ms-3 mt-3">

            <input type="file" class="form-control mb-3 mt-3" name="avatar" id="avatar">
    
            <div class="text-center m-3">
                <button type="submit" class="btn btn-success">Cập nhật</button>
                <a href="<?php echo e(route('user.dashboard')); ?>" class="btn btn-secondary">Quay lai</a>
            </div>
            
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\datn-wd110-46\backend\resources\views/admin/update.blade.php ENDPATH**/ ?>