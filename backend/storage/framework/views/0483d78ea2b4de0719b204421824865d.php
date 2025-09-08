<?php $__env->startSection('title'); ?>
    Chi tiết đơn hàng
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_admin'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success text-center">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <h1 class="text-center mt-5">Chi tiết đơn hàng</h1>

    <div class="container">
        <h2 class="my-4">Chi tiết đơn hàng #<?php echo e($order->id); ?></h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Màu sắc</th>
                        <th>Kích cỡ</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $order->orderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <?php if($detail->is_deleted): ?>
                                <td colspan="8" class="text-center">Sản phẩm đã bị xóa bởi hệ thống</td>
                                <!-- Hiển thị thông báo nếu sản phẩm đã bị xóa -->
                            <?php else: ?>
                                <td><?php echo e($detail->product->id); ?></td>
                                <td><?php echo e($detail->product->name); ?></td>
                                <td class="text-center" style="vertical-align: middle; text-align: center;">
                                    <img src="<?php echo e(asset('storage/' . $detail->product->img_thumb)); ?>" alt="image"
                                        style="width: 80px; height: 80px; object-fit: cover; border-radius: 0; display: block; margin: auto;">
                                </td>
                                <td><?php echo e($detail->quantity); ?></td>
                                <td><?php echo e(number_format($detail->price)); ?> VNĐ</td>
                                <td><?php echo e($detail->color->name_color); ?></td>
                                <td><?php echo e($detail->size->size); ?></td>
                                <td><?php echo e(number_format($detail->total)); ?> VNĐ</td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </tbody>
            </table>
        </div>

        <div class="my-4" style="font-size: 16px;">
            <p><strong>Tổng tiền:</strong> <span class="text-success"><?php echo e(number_format($order->total_amount)); ?> VNĐ</span></p>

            <?php if($order->payment_method == 2): ?>
                <!-- Thông tin thanh toán online -->
                <?php if($order->payment): ?>
                    <!-- Kiểm tra nếu có dữ liệu payment -->
                    <div class="mt-3">
                        <p><strong>Thông tin thanh toán online</strong></p>
                        <ul style="font-size: 16px;">
                            <li><strong>Mã giao dịch:</strong>
                                <?php echo e($order->payment->transaction_id ?? 'Không có thông tin'); ?></li>
                            <li><strong>Ngày thanh toán:</strong>
                                <?php echo e($order->payment->created_at ? $order->payment->created_at->format('d-m-Y H:i') : 'Không có thông tin'); ?>

                            </li>
                            <li><strong>Số tiền thanh toán:</strong>
                                ₫<?php echo e(isset($order->payment->amount) ? number_format($order->payment->amount, 0, ',', '.') : 'Không có thông tin'); ?>

                            </li>
                            <li><strong>Trạng thái:</strong>
                                <?php echo e($order->payment->status ?? 'Không có thông tin'); ?>

                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <!-- Không có dữ liệu thanh toán online -->
                    <div class="mt-3">
                        <p><strong>Không có thông tin thanh toán online</strong></p>
                    </div>
                <?php endif; ?>
            <?php elseif($order->payment_method == 1): ?>
                <!-- Thông tin thanh toán COD -->
                <div class="mt-3">
                    <p><strong>Phương thức thanh toán:</strong> <span class="text-success">COD (Thanh toán khi nhận hàng)</span></p>
                </div>
            <?php else: ?>
                <!-- Phương thức thanh toán không xác định -->
                <div class="mt-3">
                    <p><strong>Phương thức thanh toán không xác định</strong></p>
                </div>
            <?php endif; ?>

            <p><strong>Đã giảm giá:</strong>
                <span class="text-warning">
                    <?php echo e(number_format($order->discount_value ?? 0)); ?> VNĐ
                </span>
            </p>

            <p><strong>Người dùng:</strong> <?php echo e($order->user->email); ?></p>
            <p><strong>Thông tin giao hàng:</strong></p>
            <?php if($order->shipAddress): ?>
                <div class="border p-3 mb-3 bg-light" style="font-size: 16px;">
                    <p><strong>Tên người nhận:</strong> <?php echo e($order->shipAddress->recipient_name ?? 'Chưa cập nhật'); ?></p>
                    <p><strong>Tên người gửi:</strong> <?php echo e($order->shipAddress->sender_name ?? ($order->sender_name ?? 'Chưa cập nhật')); ?></p>
                    <p><strong>Số điện thoại:</strong> <?php echo e($order->shipAddress->phone_number ?? 'Chưa cập nhật'); ?></p>
                    <p><strong>Địa chỉ giao hàng:</strong>
                        <?php if($order->shipAddress->ship_address): ?>
                            <?php echo e($order->shipAddress->ship_address); ?>

                            <?php if(strlen($order->shipAddress->ship_address) < 10): ?>
                                <br><span class="text-warning" style="font-size: 16px;">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Cảnh báo:</strong> Địa chỉ có vẻ không đầy đủ. Vui lòng liên hệ khách hàng để xác nhận địa chỉ chi tiết.
                                </span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="text-danger">Chưa có địa chỉ</span>
                        <?php endif; ?>
                    </p>
                </div>
            <?php else: ?>
                <div class="alert alert-danger" style="font-size: 16px;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Lỗi:</strong> Không tìm thấy thông tin địa chỉ giao hàng cho đơn hàng này.
                </div>
            <?php endif; ?>

            <p><strong style="font-size: 20px;">Trạng thái:</strong>
                <?php switch($order->status):
                    case (0): ?>
                        <span class="badge bg-warning text-dark" style="font-size: 18px;">Chờ xử lý</span>
                    <?php break; ?>

                    <?php case (1): ?>
                        <span class="badge bg-info text-dark" style="font-size: 18px;">Đã xử lý</span>
                    <?php break; ?>

                    <?php case (2): ?>
                        <span class="badge bg-primary text-white" style="font-size: 18px;">Đang vận chuyển</span>
                    <?php break; ?>

                    <?php case (3): ?>
                        <span class="badge bg-success" style="font-size: 18px;">Giao hàng thành công</span>
                    <?php break; ?>

                    <?php case (4): ?>
                        <span class="badge bg-danger" style="font-size: 18px;">Đã hủy</span>
                    <?php break; ?>

                    <?php case (5): ?>
                        <span class="badge bg-secondary" style="font-size: 18px;">Đã trả lại</span>
                    <?php break; ?>
                <?php endswitch; ?>
            </p>
        </div>

        <div class="text-center">
            <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-primary">Quay lại danh sách đơn hàng</a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\datn-wd110-46\backend\resources\views/order/show.blade.php ENDPATH**/ ?>