<?php $__env->startSection('title'); ?>
    Danh sách Đơn hàng
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="text-center mb-4">Danh sách Đơn hàng</h1>

    <div class="container mt-2">
        <!-- Navigation Tabs for Filtering by Order Status -->
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link <?php echo e(request()->get('status') === null ? 'active' : ''); ?>"
                    href="<?php echo e(route('userorder.index')); ?>">Tất cả</a></li>
            <li class="nav-item"><a class="nav-link <?php echo e(request()->get('status') == 0 ? 'active' : ''); ?>"
                    href="<?php echo e(route('userorder.index', ['status' => 0])); ?>">Chờ Xử lí</a></li>
            <li class="nav-item"><a class="nav-link <?php echo e(request()->get('status') == 1 ? 'active' : ''); ?>"
                    href="<?php echo e(route('userorder.index', ['status' => 1])); ?>">Đã xử lý</a></li>
            <li class="nav-item"><a class="nav-link <?php echo e(request()->get('status') == 2 ? 'active' : ''); ?>"
                    href="<?php echo e(route('userorder.index', ['status' => 2])); ?>">Vận chuyển</a></li>
            <li class="nav-item"><a class="nav-link <?php echo e(request()->get('status') == 3 ? 'active' : ''); ?>"
                    href="<?php echo e(route('userorder.index', ['status' => 3])); ?>">Hoàn thành</a></li>
            <li class="nav-item"><a class="nav-link <?php echo e(request()->get('status') == 4 ? 'active' : ''); ?>"
                    href="<?php echo e(route('userorder.index', ['status' => 4])); ?>">Đã hủy</a></li>
            <li class="nav-item"><a class="nav-link <?php echo e(request()->get('status') == 5 ? 'active' : ''); ?>"
                    href="<?php echo e(route('userorder.index', ['status' => 5])); ?>">Trả hàng/Hoàn tiền</a></li>
        </ul>

        <!-- Order List -->
        <?php if($orders->isEmpty()): ?>
            <p class="text-center mt-4">Không có đơn hàng nào. Vui lòng mua sắm.</p>
        <?php else: ?>
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card my-4 shadow-sm border-0">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
                        <span><strong>ID đơn hàng:</strong> #<?php echo e($order->id); ?></span>
                        <p
                            class="<?php echo e($order->status == 3 ? 'text-success' : ($order->status == 4 ? 'text-danger' : 'text-muted')); ?>">
                            <?php echo e($order->message); ?>

                        </p>
                        <span
                            class="badge
                        <?php if($order->status == 3): ?> bg-success
                        <?php elseif($order->status == 4): ?> bg-danger
                        <?php elseif($order->status == 2): ?> bg-primary
                        <?php else: ?> bg-info <?php endif; ?>">
                            <?php echo e($order->status == 2
                                ? 'Đang vận chuyển'
                                : ($order->status == 3
                                    ? 'Giao hàng thành công'
                                    : ($order->status == 4
                                        ? 'Đã hủy'
                                        : 'Đang xử lý'))); ?>


                        </span>
                    </div>

                    <div class="card-body p-4">
                        <!-- Display Order Details -->
                        <?php
                            $orderTotal = 0;
                        ?>
                        <?php $__currentLoopData = $order->orderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex align-items-start mb-3">
                                    <?php if($orderDetail->product): ?>
                                        <a href="http://localhost:3000/product-detail/<?php echo e($orderDetail->product->id); ?>">
                                            <img src="<?php echo e(Storage::url($orderDetail->product->img_thumb)); ?>" alt="<?php echo e($orderDetail->product->name); ?>" class="rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        </a>
                                        <div style="flex: 1;">
                                            <h6 class="mb-1 fw-bold"><?php echo e($orderDetail->product->name); ?></h6>
                                            <p class="mb-1 text-muted"><small>Danh mục: <?php echo e($orderDetail->product->categories->name ?? 'Không rõ'); ?></small></p>
                                            <p class="mb-0 text-muted"><small>Số lượng: <strong>x<?php echo e($orderDetail->quantity); ?></strong></small></p>
                                        </div>
                                        <div style="flex: 1;" class="mt-4">
                                            <p class="mb-1 text-muted"><small>Màu sắc: <?php echo e($orderDetail->color->name_color ?? 'Không rõ'); ?></small></p>
                                            <p class="mb-0 text-muted"><small>Kích cỡ: <?php echo e($orderDetail->size->size ?? 'Không rõ'); ?></small></p>
                                        </div>
                                        <div class="d-flex flex-column align-items-center" style="width: 100px;">
                                            <p class="mb-0">Đơn giá:</p>
                                            <p class="mb-0 fw-bold">
                                                <?php if(isset($orderDetail->price) && $orderDetail->price > 0): ?>
                                                    ₫<?php echo e(number_format($orderDetail->price, 0, ',', '.')); ?>

                                                <?php else: ?>
                                                    <span class="text-danger">Không có</span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <div class="d-flex flex-column align-items-end" style="width: 120px;">
                                            <p class="mb-0">Tổng:</p>
                                            <p class="mb-0 text-danger fw-bold">₫<?php echo e(number_format($orderDetail->total, 0, ',', '.')); ?></p>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-flex align-items-center">
                                            <p class="text-danger" style="color:red;">Sản phẩm đã bị xóa bởi hệ thống </p>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            <hr class="mt-3 mb-3">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                    <!-- Display Order Total -->
                    <div class="card-footer bg-light d-flex justify-content-between align-items-center py-3">
                        <div>
                            <h6 class="m-0">Thành tiền: <span
                                    class="fw-bold text-danger">₫<?php echo e(number_format($order->total_amount ?? 0)); ?></span></h6>
                            <h6 class="mt-1">Đã giảm giá:
                                <span class="text-warning">
                                    <?php echo e(number_format($order->discount_value ?? 0)); ?> VNĐ
                                </span>
                            </h6>
                            <p class="mt-2 mb-0">Đã tạo lúc: <span style="color: green"><?php echo e($order->created_at); ?></span></p>
                        </div>
                        <div>
                            <a href="<?php echo e(route('userorder.show', $order->id)); ?>" class="btn btn-outline-info btn-sm me-2">Xem chi tiết</a>
                            <?php if($order->status == 0 || $order->status == 1): ?>
                                <!-- Only show cancel button if order is Pending or Processed -->
                                <button class="btn btn-outline-danger btn-sm me-2" data-bs-toggle="modal"
                                    data-bs-target="#cancelOrderModal-<?php echo e($order->id); ?>">Hủy Đơn Hàng</button>
                            <?php else: ?>
                                <button class="btn btn-outline-secondary btn-sm me-2" disabled data-bs-toggle="tooltip"
                                    title="Không thể hủy khi đã vận chuyển, hoàn thành hoặc đã hủy">Hủy Đơn Hàng</button>
                            <?php endif; ?>

                            <?php if($order->status == 2): ?>
                                <!-- Nút "Đã nhận hàng" đã bị ẩn theo yêu cầu -->
                                
                            <?php elseif($order->status == 3): ?>
                                <!-- Show "Đánh giá" button when order is "Hoàn thành" -->
                                <?php
                                    $reviewExists = \App\Models\Review::where('order_id', $order->id)->exists();
                                ?>
                                <?php if($reviewExists): ?>
                                    <button class="btn btn-outline-warning btn-sm me-2"
                                        onclick="alert('Bạn đã đánh giá đơn hàng này rồi.')">Đã đánh giá</button>
                                <?php else: ?>
                                    <button class="btn btn-outline-warning btn-sm me-2" data-bs-toggle="modal"
                                        data-bs-target="#reviewModal-<?php echo e($order->id); ?>">Đánh giá</button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Confirm Receipt Modal -->
                <div class="modal fade" id="confirmReceiptModal-<?php echo e($order->id); ?>" tabindex="-1"
                    aria-labelledby="confirmReceiptModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmReceiptModalLabel">Xác nhận đã nhận hàng</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="<?php echo e(route('done', $order->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <div class="modal-body">
                                    <p>Bạn có chắc chắn đã nhận hàng và muốn hoàn thành đơn hàng này?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="submit" class="btn btn-success">Xác nhận</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- Cancel Order Modal -->
                <div class="modal fade" id="cancelOrderModal-<?php echo e($order->id); ?>" tabindex="-1"
                    aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="cancelOrderModalLabel">Lý do hủy đơn hàng</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="<?php echo e(route('userorder.update', $order->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="cancelReason" class="form-label">Chọn lý do hủy đơn hàng:</label>
                                        <select class="form-select" id="cancelReason" name="cancel_reason" required>
                                            <option value="Tôi không muốn đặt hàng nữa">Tôi không muốn đặt hàng nữa
                                            </option>
                                            <option value="Mặt hàng quá đắt">Mặt hàng quá đắt</option>
                                            <option value="Thời gian giao hàng quá lâu">Thời gian giao hàng quá lâu
                                            </option>
                                            <option value="Other">Khác</option>
                                        </select>
                                    </div>
                                    <div class="mb-3" id="otherReasonInput" style="display: none;">
                                        <label for="otherReason" class="form-label">Nhập lý do khác:</label>
                                        <input type="text" class="form-control" id="otherReason" name="other_reason">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="submit" class="btn btn-danger">Hủy Đơn Hàng</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Review Modal -->
                <div class="modal fade" id="reviewModal-<?php echo e($order->id); ?>" tabindex="-1"
                    aria-labelledby="reviewModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reviewModalLabel">Đánh giá Đơn Hàng</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="<?php echo e(route('review.store', $order->id)); ?>" method="POST"
                                enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="rating" class="form-label">Đánh giá sao:</label>
                                        <select name="rating" id="rating" class="form-select" required>
                                            <option value="1">1 Sao</option>
                                            <option value="2">2 Sao</option>
                                            <option value="3">3 Sao</option>
                                            <option value="4">4 Sao</option>
                                            <option value="5" selected>5 Sao</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="comment" class="form-label">Bình luận:</label>
                                        <textarea name="comment" id="comment" class="form-control" rows="4" maxlength="1000"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Ảnh minh họa (nếu có):</label>
                                        <input type="file" name="image" id="image" class="form-control"
                                            accept="image/*">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="submit" class="btn btn-primary">Gửi Đánh Giá</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <?php echo e($orders->appends(['status' => request()->get('status')])->links()); ?>

    </div>


    <script>
        // JavaScript to handle the "Other" cancel reason
        document.addEventListener('DOMContentLoaded', function() {
            const cancelReasonSelect = document.getElementById('cancelReason');
            const otherReasonInput = document.getElementById('otherReasonInput');

            cancelReasonSelect.addEventListener('change', function() {
                if (this.value === 'Other') {
                    otherReasonInput.style.display = 'block'; // Show the other reason input
                } else {
                    otherReasonInput.style.display = 'none'; // Hide the other reason input
                }
            });

            // Optional: You can set a listener to reset the "Other" input when modal is closed
            const cancelOrderModal = document.querySelectorAll('.modal');
            cancelOrderModal.forEach(function(modal) {
                modal.addEventListener('hidden.bs.modal', function() {
                    otherReasonInput.style.display =
                        'none'; // Reset the display of the other reason field when modal is closed
                    cancelReasonSelect.value = ''; // Reset the select value
                    document.getElementById('otherReason').value =
                        ''; // Clear the "Other" reason text field
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\datn-wd110-46\backend\resources\views/user/order.blade.php ENDPATH**/ ?>