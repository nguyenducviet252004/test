<?php $__env->startSection('title'); ?>
    Sửa địa chỉ
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="text-center">Sửa địa chỉ</h1>


    <form action="<?php echo e(route('address.update', $address->id)); ?>" method="POST" novalidate>
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>

        <div class="mb-3">
            <label for="recipient_name" class="form-label">Tên người nhận</label>
            <input type="text" name="recipient_name" id="recipient_name" class="form-control mb-3"
                value="<?php echo e(old('recipient_name', $address->recipient_name)); ?>" required>
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
        <div class="mb-3">
            <label for="sender_name" class="form-label">Người gửi</label>
            <input type="text" name="sender_name" id="sender_name" class="form-control mb-3"
                value="<?php echo e(old('sender_name', $address->sender_name)); ?>">
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

        <div class="mb-3">
            <label for="ship_address" class="form-label">Địa chỉ</label>
            <input type="text" name="ship_address" id="ship_address" class="form-control mb-3"
                value="<?php echo e(old('ship_address', $address->ship_address)); ?>" required>
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

        <div class="mb-3">
            <label for="phone_number" class="form-label">Số điện thoại</label>
            <input type="text" name="phone_number" id="phone_number" class="form-control mb-3"
                value="<?php echo e(old('phone_number', $address->phone_number)); ?>" required>
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

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_default" id="is_default" class="form-check-input mb-3"
                <?php echo e($address->is_default ? 'checked' : ''); ?>>
            <label for="is_default" class="form-check-label">Đặt làm địa chỉ mặc định</label>
            <?php $__errorArgs = ['is_default'];
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
            <button type="submit" class="btn btn-warning">Cập nhật</button>
            <a href="<?php echo e(route('address.index')); ?>" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\datn-wd110-46\backend\resources\views/user/editAddress.blade.php ENDPATH**/ ?>