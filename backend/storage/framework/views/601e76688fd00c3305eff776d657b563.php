<?php $__env->startSection('title'); ?>
    Chi tiết đơn hàng
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-4">
        <h2 class="mb-4">Chi tiết đơn hàng #<?php echo e($order->id); ?></h2>
        <div class="card mb-4">
            <div class="card-header">
                <strong>Trạng thái:</strong>
                <span class="badge
                    <?php if($order->status == 3): ?> bg-success
                    <?php elseif($order->status == 4): ?> bg-danger
                    <?php elseif($order->status == 2): ?> bg-primary
                    <?php else: ?> bg-info <?php endif; ?>">
                    <?php echo e($order->status == 2 ? 'Đang vận chuyển' : ($order->status == 3 ? 'Giao hàng thành công' : ($order->status == 4 ? 'Đã hủy' : 'Đang xử lý'))); ?>

                </span>
            </div>
            <div class="card-body">
                <p><strong>Ngày đặt hàng:</strong> <?php echo e($order->created_at); ?></p>
                <p><strong>Thành tiền:</strong> ₫<?php echo e(number_format($order->total_amount ?? 0)); ?></p>
                <p><strong>Đã giảm giá:</strong> <?php echo e(number_format($order->discount_value ?? 0)); ?> VNĐ</p>
                <p><strong>Địa chỉ nhận hàng:</strong> <?php echo e($order->shipAddress->ship_address ?? 'Không có'); ?></p>
                <p><strong>Số điện thoại:</strong> <?php echo e($order->shipAddress->phone_number ?? 'Không có'); ?></p>
                <p><strong>Người nhận:</strong> <?php echo e($order->shipAddress->recipient_name ?? 'Không có'); ?></p>
                <p><strong>Người gửi:</strong> <?php echo e($order->shipAddress->sender_name ?? 'Không có'); ?></p>
            </div>
        </div>
        <h4>Sản phẩm trong đơn hàng</h4>
        <div class="card">
            <div class="card-body">
                <?php $__currentLoopData = $order->orderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <img src="<?php echo e(Storage::url($detail->product->img_thumb ?? '')); ?>" alt="<?php echo e($detail->product->name ?? ''); ?>" class="img-fluid rounded">
                        </div>
                        <div class="col-md-6">
                            <h6><?php echo e($detail->product->name ?? 'Sản phẩm đã bị xóa'); ?></h6>
                            <p>Danh mục: <?php echo e($detail->product->categories->name ?? 'Không rõ'); ?></p>
                            <p>Màu sắc: <?php echo e($detail->color->name_color ?? 'Không rõ'); ?></p>
                            <p>Kích cỡ: <?php echo e($detail->size->size ?? 'Không rõ'); ?></p>
                        </div>
                        <div class="col-md-2">
                            <p>Số lượng: x<?php echo e($detail->quantity); ?></p>
                        </div>
                        <div class="col-md-2">
                            <p>Đơn giá: ₫<?php echo e(number_format($detail->price, 0, ',', '.')); ?></p>
                            <p>Tổng: ₫<?php echo e(number_format($detail->total, 0, ',', '.')); ?></p>
                        </div>
                    </div>
                    <hr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <a href="<?php echo e(route('userorder.index')); ?>" class="btn btn-secondary mt-4">Quay lại danh sách đơn hàng</a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\datn-wd110-46\backend\resources\views/user/orderdetail.blade.php ENDPATH**/ ?>