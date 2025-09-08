<?php $__env->startSection('title'); ?>
    Thêm mới địa chỉ
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <h2 class="text-center">Thêm mới địa chỉ</h2>

    <form action="<?php echo e(route('address.store')); ?>" method="POST" novalidate>
        <?php echo csrf_field(); ?>
        <div>
            <label for="recipient_name" class="form-label">Tên người nhận</label>
            <input type="text" class="form-control mb-3" name="recipient_name" id="recipient_name" value="<?php echo e(old('recipient_name')); ?>" required>
            <?php $__errorArgs = ['recipient_name'];
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
            <label for="sender_name" class="form-label">Người gửi</label>
            <input type="text" class="form-control mb-3" name="sender_name" id="sender_name" value="<?php echo e(old('sender_name')); ?>">
            <?php $__errorArgs = ['sender_name'];
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
            <label for="ship_address">Địa chỉ:</label>
            <input type="text" class="form-control mb-3" id="ship_address" name="ship_address" value="<?php echo e(old('ship_address')); ?>" required>
            <?php $__errorArgs = ['ship_address'];
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
            <label for="phone_number">Số điện thoại:</label>
            <input type="text" class="form-control mb-3" id="phone_number" name="phone_number" value="<?php echo e(old('phone_number')); ?>" required>
            <?php $__errorArgs = ['phone_number'];
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
            <button type="submit" class="btn btn-success">Thêm địa chỉ</button>
            <a href="<?php echo e(route('address.index')); ?>" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\datn-wd110-46\backend\resources\views/user/addresscreate.blade.php ENDPATH**/ ?>