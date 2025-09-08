<?php $__env->startSection('title'); ?>
    Danh sách đơn hàng
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_admin'); ?>
    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Include realtime CSS and JavaScript -->
    <link rel="stylesheet" href="<?php echo e(asset('css/realtime-orders.css')); ?>">
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="<?php echo e(asset('js/realtime-orders.js')); ?>"></script>
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

    <!-- Thông báo hướng dẫn -->
    <div class="alert alert-info mx-3 mb-3">
        <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Hướng dẫn cập nhật trạng thái đơn hàng:</h6>
        <ul class="mb-0">
            <li><strong>Quy tắc:</strong> Chỉ có thể cập nhật từng bước một, không được nhảy cóc</li>
            <li><strong>Quy trình:</strong> Chờ xử lý → Đã xử lý → Đang vận chuyển → Giao hàng thành công</li>
            <li><strong>Hủy đơn:</strong> Có thể hủy đơn ở bất kỳ bước nào trước khi giao hàng thành công</li>
            <li><strong>Trả lại:</strong> Chỉ có thể trả lại sau khi giao hàng thành công</li>
        </ul>
    </div>

    <div class="d-flex justify-content-between px-3">

            <!-- Bộ lọc nâng cao -->
            <form action="<?php echo e(route('orders.index')); ?>" method="GET" class="row g-2 align-items-center mb-3" style="width:100%">
                <div class="col-md-3">
                    <input type="text" name="keyword" class="form-control" placeholder="Mã đơn / Tên / Email / SĐT" value="<?php echo e(request('keyword')); ?>">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Tất cả trạng thái đơn</option>
                        <option value="0" <?php echo e(request('status') == '0' ? 'selected' : ''); ?>>Chờ xử lý</option>
                        <option value="1" <?php echo e(request('status') == '1' ? 'selected' : ''); ?>>Đã xử lý</option>
                        <option value="2" <?php echo e(request('status') == '2' ? 'selected' : ''); ?>>Đang vận chuyển</option>
                        <option value="3" <?php echo e(request('status') == '3' ? 'selected' : ''); ?>>Giao hàng thành công</option>
                        <option value="4" <?php echo e(request('status') == '4' ? 'selected' : ''); ?>>Đã hủy</option>
                        <option value="5" <?php echo e(request('status') == '5' ? 'selected' : ''); ?>>Đã trả lại</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="payment_status" class="form-select">
                        <option value="">Tất cả thanh toán</option>
                        <option value="paid" <?php echo e(request('payment_status') == 'paid' ? 'selected' : ''); ?>>Đã thanh toán</option>
                        <option value="unpaid" <?php echo e(request('payment_status') == 'unpaid' ? 'selected' : ''); ?>>Chưa thanh toán</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Lọc kết quả</button>
                </div>
            </form>

    </div>
    <div class="container mt-2">

        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
                <thead class="thead-dark">
                    <tr>
                            <th style="min-width: 120px;">Mã Đơn hàng</th>
                            <th style="min-width: 160px;">Người dùng</th>
                            <th style="min-width: 180px;">Địa chỉ giao hàng</th>
                            <th style="min-width: 80px;">Số lượng</th>
                            <th style="min-width: 130px;">Tổng tiền</th>
                            <th style="min-width: 150px;">Trạng thái</th>
                            <th style="min-width: 180px;">Ghi chú</th>
                            <th style="min-width: 110px;">Thao tác</th>

                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr data-order-id="<?php echo e($order->id); ?>">
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
                                    <select name="status" class="form-select" data-current-status="<?php echo e($order->status); ?>" onchange="confirmAndSubmit(this, <?php echo e($order->status); ?>)">
                                        <option value="0" <?php echo e($order->status == 0 ? 'selected' : ''); ?>

                                            <?php echo e(!in_array(0, \App\Helpers\OrderHelper::getNextAllowedStatuses($order->status)) ? 'disabled' : ''); ?>>
                                            Chờ xử lý
                                        </option>
                                        <option value="1" <?php echo e($order->status == 1 ? 'selected' : ''); ?>

                                            <?php echo e(!in_array(1, \App\Helpers\OrderHelper::getNextAllowedStatuses($order->status)) ? 'disabled' : ''); ?>>
                                            Đã xử lý
                                        </option>
                                        <option value="2" <?php echo e($order->status == 2 ? 'selected' : ''); ?>

                                            <?php echo e(!in_array(2, \App\Helpers\OrderHelper::getNextAllowedStatuses($order->status)) ? 'disabled' : ''); ?>>
                                            Đang vận chuyển
                                        </option>
                                        <option value="3" <?php echo e($order->status == 3 ? 'selected' : ''); ?>

                                            <?php echo e(!in_array(3,           \App\Helpers\OrderHelper::getNextAllowedStatuses($order->status)) ? 'disabled' : ''); ?>>
                                            Giao hàng thành công
                                        </option>
                                        <option value="4" <?php echo e($order->status == 4 ? 'selected' : ''); ?>

                                            <?php echo e(!in_array(4, \App\Helpers\OrderHelper::getNextAllowedStatuses($order->status)) ? 'disabled' : ''); ?>>
                                            Đã hủy
                                        </option>
                                        
                                    </select>
                                </form>

                                <script>
                                    function confirmAndSubmit(selectElement, currentStatus) {
                                        const selectedStatus = parseInt(selectElement.value);

                                        // Định nghĩa quy tắc chuyển đổi trạng thái
                                        const allowedTransitions = {
                                            0: [1, 4], // Chờ xử lý -> Đã xử lý hoặc Hủy
                                            1: [2, 4], // Đã xử lý -> Đang vận chuyển hoặc Hủy
                                            2: [3], // Đang vận chuyển -> Giao hàng thành công hoặc Hủy
                                            3: [5],    // Giao hàng thành công -> Đã trả lại
                                            4: [],     // Đã hủy -> Không thể chuyển
                                            // 5: []      // Đã trả lại -> Không thể chuyển
                                        };

                                        // Kiểm tra xem có được phép chuyển không
                                        if (!allowedTransitions[currentStatus].includes(selectedStatus)) {
                                            const statusNames = {
                                                0: 'Chờ xử lý',
                                                1: 'Đã xử lý',
                                                2: 'Đang vận chuyển',
                                                3: 'Giao hàng thành công',
                                                4: 'Đã hủy',
                                                // 5: 'Đã trả lại'
                                            };

                                            const currentStatusName = statusNames[currentStatus] || 'Không xác định';
                                            const newStatusName = statusNames[selectedStatus] || 'Không xác định';

                                            alert(`Không thể chuyển từ trạng thái '${currentStatusName}' sang '${newStatusName}'.\n\nQuy tắc cập nhật:\n• Chỉ có thể cập nhật từng bước một\n• Quy trình: Chờ xử lý → Đã xử lý → Đang vận chuyển → Giao hàng thành công\n• Có thể hủy đơn ở bất kỳ bước nào trước khi giao hàng thành công`);

                                            // Đặt lại giá trị về trạng thái hiện tại
                                            selectElement.value = currentStatus;
                                            return;
                                        }

                                        // Xác nhận trước khi cập nhật
                                        const statusNames = {
                                            0: 'Chờ xử lý',
                                            1: 'Đã xử lý',
                                            2: 'Đang vận chuyển',
                                            3: 'Giao hàng thành công',
                                            4: 'Đã hủy',
                                            // 5: 'Đã trả lại'
                                        };

                                        const currentStatusName = statusNames[currentStatus] || 'Không xác định';
                                        const newStatusName = statusNames[selectedStatus] || 'Không xác định';

                                        if (confirm(`Xác nhận cập nhật trạng thái đơn hàng từ '${currentStatusName}' sang '${newStatusName}'?`)) {
                                            selectElement.form.submit();
                                        } else {
                                            // Đặt lại giá trị về trạng thái hiện tại nếu không xác nhận
                                            selectElement.value = currentStatus;
                                        }
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
            /* Đảm bảo bảng luôn hiển thị đầy đủ các cột, không bị ẩn */
            .table-responsive {
                overflow-x: auto;
            }
            table.table {
                min-width: 1200px;
            }
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

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\New folder (2)\backend\resources\views/order/index.blade.php ENDPATH**/ ?>