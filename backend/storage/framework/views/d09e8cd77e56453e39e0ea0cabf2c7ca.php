<?php $__env->startSection('title'); ?>
    Danh sách đơn hàng
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

    <h1 class="text-center mt-5 mb-3">Danh sách đơn hàng</h1>
    <div class="d-flex justify-content-between px-3">

        <form action="<?php echo e(route('orders.index')); ?>" method="GET" class="mb-3">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Tất cả trạng thái</option>
                <option value="0" <?php echo e(request('status') == 0 ? 'selected' : ''); ?>>Chờ xử lý</option>
                <option value="1" <?php echo e(request('status') == 1 ? 'selected' : ''); ?>>Đã xử lý</option>
                <option value="2" <?php echo e(request('status') == 2 ? 'selected' : ''); ?>>Đang vận chuyển</option>
                <option value="3" <?php echo e(request('status') == 3 ? 'selected' : ''); ?>>Giao hàng thành công</option>
                <option value="4" <?php echo e(request('status') == 4 ? 'selected' : ''); ?>>Đã hủy</option>
                <option value="5" <?php echo e(request('status') == 5 ? 'selected' : ''); ?>>Đã trả lại</option>
            </select>
        </form>

    </div>
    <div class="container mt-2">

        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>Mã Đơn hàng</th>
                        <th>Người dùng</th>
                        <th>Địa chỉ giao hàng</th>
                        <th>Số lượng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ghi chú</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($order->id); ?></td>
                            <td><?php echo e($order->user->email); ?></td>
                            <td>
                                <?php if($order->shipAddress && $order->shipAddress->ship_address): ?>
                                    <?php echo e($order->shipAddress->ship_address); ?>

                                <?php else: ?>
                                    Không rõ
                                <?php endif; ?>
                            </td>

                            <td><?php echo e($order->quantity); ?></td>
                            <td><?php echo e(number_format($order->total_amount, 2)); ?> VNĐ</td>
                            <td>
                                <form action="<?php echo e(route('orders.index')); ?>" method="GET" style="width: 200px;"
                                    id="orderStatusForm-<?php echo e($order->id); ?>">
                                    <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">
                                    <select name="status" class="form-select" onchange="confirmAndSubmit(this)">
                                        <option value="0" <?php echo e($order->status == 0 ? 'selected' : ''); ?>

                                            <?php echo e($order->status != 0 ? 'disabled' : ''); ?>>
                                            Chờ xử lý
                                        </option>
                                        <option value="1" <?php echo e($order->status == 1 ? 'selected' : ''); ?>

                                            <?php echo e($order->status >= 1 ? 'disabled' : ''); ?>>
                                            Đã xử lý
                                        </option>
                                        <option value="2" <?php echo e($order->status == 2 ? 'selected' : ''); ?>

                                            <?php echo e($order->status >= 2 ? 'disabled' : ''); ?>>
                                            Đang vận chuyển
                                        </option>
                                        <option value="3" <?php echo e($order->status == 3 ? 'selected' : ''); ?>

                                            <?php echo e($order->status >= 3 ? 'disabled' : ''); ?>>
                                            Giao hàng thành công
                                        </option>
                                        <option value="4" <?php echo e($order->status == 4 ? 'selected' : ''); ?>

                                            <?php echo e($order->status == 4 ? 'disabled' : ''); ?>>
                                            Đã hủy
                                        </option>
                                        <option value="5" <?php echo e($order->status == 5 ? 'selected' : ''); ?>

                                            <?php echo e($order->status == 5 ? 'disabled' : ''); ?>>
                                            Đã trả lại
                                        </option>
                                    </select>
                                </form>


                                <script>
                                    function confirmAndSubmit(selectElement) {
                                        const currentStatus = <?php echo e($order->status); ?>; // Lấy trạng thái hiện tại từ backend
                                        const selectedStatus = selectElement.value;

                                        // Nếu chọn trạng thái mới và muốn quay lại trạng thái cũ, hiển thị cảnh báo
                                        if ((currentStatus >= 1 && selectedStatus <= currentStatus) || (currentStatus >= 3 && selectedStatus <=
                                                currentStatus)) {
                                            alert('Bạn không thể quay lại trạng thái cũ.');
                                            selectElement.value = currentStatus; // Đặt lại giá trị trạng thái hiện tại
                                            return;
                                        }

                                        selectElement.form.submit(); // Nếu không có vấn đề, submit form
                                    }
                                </script>

                            </td>

                            <td><?php echo e($order->message); ?></td>
                            <td>
                                <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="btn btn-info btn-sm">Chi tiết</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <?php echo e($orders->links()); ?>

    </div>

    <style>
        /* Chỉnh sửa màu sắc các option để chúng luôn dễ nhìn */
        select.form-select {
            font-weight: bold;
            color: #7339b6;
            /* Màu chữ mặc định */
            background-color: #f8f9fa;
            /* Màu nền sáng cho select */
        }

        /* Các option bên trong select */
        select.form-select option {
            color: #000;
            /* Màu chữ đen cho tất cả các option */
            background-color: #fff;
            /* Màu nền trắng */
        }

        select.form-select option[value="0"] {

            color: #d3d3d3;
            /* Màu chữ đen */
        }

        select.form-select option[value="1"] {

            color: #4e73df;
            /* Màu chữ trắng */
        }

        select.form-select option[value="2"] {
            /* Màu nền cam cho trạng thái 'Đang vận chuyển' */
            color: #f39c12;
            /* Màu chữ trắng */
        }

        select.form-select option[value="3"] {
            /* Màu nền xanh lá cho trạng thái 'Giao hàng thành công' */
            color: #28a745;
            /* Màu chữ trắng */
        }

        select.form-select option[value="4"] {
            /* Màu nền đỏ cho trạng thái 'Đã hủy' */
            color: #dc3545;
            /* Màu chữ trắng */
        }

        select.form-select option[value="5"] {
            /* Màu nền tím cho trạng thái 'Đã trả lại' */
            color: #6f42c1;
            /* Màu chữ trắng */
        }

        /* Chỉnh sửa màu sắc khi select được focus */
        select.form-select:focus {
            border-color: #4e73df;
            outline: none;
        }
    </style>


    <script>
        function confirmAndSubmit(selectElement) {
            const form = selectElement.closest('form');
            const selectedStatus = selectElement.value;

            if (confirm('Có chắc muốn chỉnh sửa trạng thái đơn hàng này?')) {
                form.submit();
            } else {
                selectElement.value = '';
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\datn-wd110-46\backend\resources\views/order/index.blade.php ENDPATH**/ ?>