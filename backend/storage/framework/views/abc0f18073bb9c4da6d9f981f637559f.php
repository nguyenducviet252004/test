<?php $__env->startSection('title'); ?>
    Cập nhật tài khoản
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="text-center">Cập nhật tài khoản</h1>

    <form action="<?php echo e(route('user.update')); ?>" method="POST" enctype="multipart/form-data" novalidate>
        <?php echo csrf_field(); ?>
        <label for="fullname">Full Name</label>
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

        <label for="birth_day">Birth Day</label>
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

        <label for="phone">Phone</label>
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
        <input type="email" class="form-control mb-3" name="email" id="email" value="<?php echo e(old('email', Auth::user()->email)); ?>">

        <div class="d-flex">
            <?php if(!empty(Auth::user()->email)): ?>
                <?php if(Auth::user()->email_verified_at == null): ?>
                    <span>Trạng thái:</span>
                    <p style="color: red" class="ms-3">Chưa xác thực</p>
                    <div class="">
                        <a href="<?php echo e(route('verify')); ?>" class="btn badge bg-success ms-3">Xác minh email</a>
                    </div>
                <?php else: ?>
                    <span>Trạng thái email:</span>
                    <p style="color: green" class="ms-3">Đã xác thực</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        
        <label for="address">Address</label>
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

        <label for="ship_address">Ship Default</label>
        <a href="<?php echo e(route('address.create')); ?>" class="btn badge bg-success ms-3 mb-2">Thêm mới</a>
        <select name="address_id" class="form-control">
            <?php if($addresses->isNotEmpty()): ?>
                <?php
                    $defaultAddress = $addresses->firstWhere('is_default', 1);
                ?>
        
                <?php if($defaultAddress): ?>
                    <option value="<?php echo e($defaultAddress->id); ?>">
                        <strong style="color: red;">Địa chỉ:</strong> <?php echo e($defaultAddress->ship_address); ?> - 
                        <strong style="color: red;">Số điện thoại:</strong> <?php echo e($defaultAddress->phone_number); ?> - 
                        <strong style="color: red;">Tên người nhận:</strong> <?php echo e($user->recipient_name ?? $user->fullname); ?>

                    </option>
                <?php else: ?>
                    <option value="">Chưa có địa chỉ mặc định, hãy thêm địa chỉ mới</option>
                <?php endif; ?>
            <?php else: ?>
                <option value="">Chưa có địa chỉ giao hàng nào, hãy thêm địa chỉ mới</option>
            <?php endif; ?>
        
            <!-- Duyệt qua tất cả địa chỉ để tạo danh sách chọn -->
            <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($address->id); ?>">
                    <?php echo e($address->ship_address); ?> - <?php echo e($address->phone_number); ?> - <?php echo e($user->fullname ?? $user->account); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        
        <label for="avatar" class="mt-3">Avatar</label>
        <img src="<?php echo e(asset('storage/' . Auth::user()->avatar)); ?>" width="100px" class="ms-3 mt-3">
        <input type="file" class="form-control mb-3 mt-3" name="avatar" id="avatar">

        <button type="submit" class="btn btn-success mt-3">Cập nhật</button>
        <a href="<?php echo e(route('user.dashboard')); ?>" class="btn btn-secondary mt-3">Quay lai</a>
        
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\datn-wd110-46\backend\resources\views/user/update.blade.php ENDPATH**/ ?>