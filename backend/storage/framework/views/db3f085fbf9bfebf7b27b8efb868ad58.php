<?php $__env->startSection('title'); ?>
    Danh sách Voucher
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-4">
        <!-- Header -->
        <div class="row align-items-center mb-3">
            <div class="col-md-8">
                <h1>Kho Voucher</h1>
            </div>
            <div class="col-md-4 text-end">
                <input type="text" class="form-control d-inline w-75" placeholder="Nhập mã voucher tại đây">
                <button class="btn btn-primary d-inline">Lưu</button>
            </div>
        </div>

        <!-- Voucher List -->
        <div class="row">
            <?php $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $voucher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <span class="badge bg-danger"><?php echo e($voucher->type == 0 ? 'Shop Mall' : 'Voucher Độc Quyền'); ?></span>
                            </div>
                            <h5 class="card-title mt-2">Giảm <?php echo e($voucher->discount_value); ?> đ</h5>
                            <p class="card-text">Đơn tối thiểu: <?php echo e($voucher->total_min); ?>đ</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Có hiệu lực đến: <?php echo e($voucher->end_day); ?></small>
                      
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

          <!-- Phân trang -->
    <div class="mt-3">
        <?php echo e($vouchers->links()); ?>

    </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\New folder (2)\backend\resources\views/user/voucher.blade.php ENDPATH**/ ?>