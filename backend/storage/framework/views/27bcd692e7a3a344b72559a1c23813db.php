<div class="container">

    <!-- Thống kê khách hàng theo bộ lọc ngày -->
    <?php if($data['filtered_customers']->isNotEmpty()): ?>
        <h4>Khách hàng mua nhiều nhất theo bộ lọc ngày</h4>
        <table class="table table-striped table-bordered mb-5">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Avatar</th>
                    <th>Số đơn hàng</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data['filtered_customers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($customer->email); ?></td>
                        <td><img src="<?php echo e(asset('storage/' . $customer->avatar)); ?>" alt="Avatar" width="50"
                                height="50"></td>
                        <td><?php echo e($customer->order_count); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Không có dữ liệu khách hàng trong khoảng thời gian lọc.</p>
    <?php endif; ?>

    <!-- Thống kê khách hàng mua nhiều nhất tháng này -->
    <?php if($data['top_customers_this_month']->isNotEmpty()): ?>
        <h4>Khách hàng mua nhiều nhất tháng này</h4>
        <table class="table table-striped table-bordered mb-5">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Avatar</th>
                    <th>Số đơn hàng</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data['top_customers_this_month']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($customer->email); ?></td>
                        <td><img src="<?php echo e(asset('storage/' . $customer->avatar)); ?>" alt="Avatar" width="50"
                                height="50"></td>
                        <td><?php echo e($customer->order_count); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Không có dữ liệu khách hàng mua hàng trong tháng này.</p>
    <?php endif; ?>

    <!-- Thống kê khách hàng mua nhiều nhất toàn hệ thống -->
    <?php if($data['top_customers_all_time']->isNotEmpty()): ?>
        <h4>Khách hàng mua nhiều nhất toàn hệ thống</h4>
        <table class="table table-striped table-bordered mb-5">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Avatar</th>
                    <th>Số đơn hàng</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data['top_customers_all_time']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($customer->email); ?></td>
                        <td><img src="<?php echo e(asset('storage/' . $customer->avatar)); ?>" alt="Avatar" width="50"
                                height="50"></td>
                        <td><?php echo e($customer->order_count); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Không có dữ liệu khách hàng mua hàng toàn hệ thống.</p>
    <?php endif; ?>

</div>
<?php /**PATH C:\xampp\htdocs\datn-wd110-46\backend\resources\views/thongke/khachhang.blade.php ENDPATH**/ ?>