<?php $__env->startSection('title'); ?>
    Địa chỉ
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>



    <h2 class="text-center"> Địa chỉ của tôi</h2>
    <a href="<?php echo e(route('address.create')); ?>" class="btn btn-success">Thêm mới</a>

    <ul class="list-group mt-2">
        <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="list-group-item <?php echo e($address->is_default ? 'list-group-item-primary' : ''); ?>">
                <strong>Tên người nhận:</strong> <?php echo e($address->recipient_name); ?><br>
                <strong>Người gửi:</strong> <?php echo e($address->sender_name); ?><br>
                <strong>Địa chỉ:</strong> <?php echo e($address->ship_address); ?><br>
                <strong>Số điện thoại:</strong> <?php echo e($address->phone_number); ?><br>
                <?php if($address->is_default): ?>
                    <span class="badge bg-primary">Địa chỉ mặc định</span>
                <?php else: ?>
                    <form action="<?php echo e(route('address.set-default', $address->id)); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="btn btn-sm btn-outline-primary">Đặt làm địa chỉ mặc định</button>
                    </form>
                <?php endif; ?>
                <a href="<?php echo e(route('address.edit', $address->id)); ?>" class="btn btn-sm btn-warning float-end ms-5 ">Cập
                    nhật</a>

                <form action="<?php echo e(route('address.destroy', $address->id)); ?>" method="POST" class="d-inline float-end ms-2">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa địa chỉ này?')"
                        class="btn btn-sm btn-outline-danger">
                        Xóa
                    </button>
                </form>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <!-- Phân trang -->
    <div class="mt-3">
        <?php echo e($addresses->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\datn-wd110-46\backend\resources\views/user/address.blade.php ENDPATH**/ ?>