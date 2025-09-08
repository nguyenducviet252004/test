<!-- Bộ lọc -->
<div class="card text-white bg-info h-100 mt-4">
    <div class="card-body">
        <?php if(isset($data['filtered_revenue']) && $data['filtered_revenue'] > 0): ?>
            <h5 class="card-title">Doanh Thu Theo Bộ Lọc</h5>
            <p class="card-text"><?php echo e(number_format($data['filtered_revenue'], 0, ',', '.')); ?> VNĐ</p>
        <?php else: ?>
            <p class="card-text">Không có dữ liệu doanh thu trong khoảng thời gian lọc.</p>
        <?php endif; ?>
        <?php if(isset($data['filtered_order_count']) && $data['filtered_order_count'] > 0): ?>
            <p class="card-text">Số lượng đơn: <?php echo e($data['filtered_order_count']); ?> đơn</p>
        <?php else: ?>
            <p class="card-text">Không có dữ liệu đơn trong khoảng thời gian lọc.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Doanh Thu và Đơn Hàng - Chia Màn Hình Thành 2 Phần -->
<div class="row mt-4 mb-4">
    <!-- Doanh Thu -->
    <div class="col-md-6">
        <div class="card text-white bg-success h-100">
            <div class="card-body">
                <h5 class="card-title">Doanh Thu Tháng Này</h5>
                <?php if(isset($data['current_revenue']) && $data['current_revenue'] > 0): ?>
                    <p class="card-text"><?php echo e(number_format($data['current_revenue'], 0, ',', '.')); ?> VNĐ</p>
                <?php else: ?>
                    <p class="card-text">Không có dữ liệu doanh thu tháng này.</p>
                <?php endif; ?>

                <h5 class="card-title">Doanh Thu Tháng Trước</h5>
                <?php if(isset($data['last_revenue']) && $data['last_revenue'] > 0): ?>
                    <p class="card-text"><?php echo e(number_format($data['last_revenue'], 0, ',', '.')); ?> VNĐ</p>
                <?php else: ?>
                    <p class="card-text">Không có dữ liệu doanh thu tháng trước.</p>
                <?php endif; ?>

                <h5 class="card-title">Sự Thay Đổi Doanh Thu</h5>
                <p class="card-text">
                    <span class="font-weight-bold"><?php echo e(number_format($data['change_revenue'], 0, ',', '.')); ?> VNĐ</span>
                    <?php if($data['change_revenue'] > 0): ?>
                        <i class="fas fa-arrow-up text-success"></i>
                    <?php elseif($data['change_revenue'] < 0): ?>
                        <i class="fas fa-arrow-down text-danger"></i>
                    <?php else: ?>
                        <i class="fas fa-arrow-right text-muted"></i>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Đơn Hàng -->
    <div class="col-md-6">
        <div class="card text-white bg-info h-100">
            <div class="card-body">
                <h5 class="card-title">Số Lượng Đơn Hoàn Thành Tháng Này</h5>
                <?php if(isset($data['current_order_count']) && $data['current_order_count'] > 0): ?>
                    <p class="card-text"><?php echo e($data['current_order_count']); ?> đơn</p>
                <?php else: ?>
                    <p class="card-text">Không có dữ liệu đơn hoàn thành tháng này.</p>
                <?php endif; ?>

                <h5 class="card-title">Số Lượng Đơn Hoàn Thành Tháng Trước</h5>
                <?php if(isset($data['last_order_count']) && $data['last_order_count'] > 0): ?>
                    <p class="card-text"><?php echo e($data['last_order_count']); ?> đơn</p>
                <?php else: ?>
                    <p class="card-text">Không có dữ liệu đơn hoàn thành tháng trước.</p>
                <?php endif; ?>

                <h5 class="card-title">Sự Thay Đổi Số Lượng Đơn</h5>
                <p class="card-text">
                    <span class="font-weight-bold"><?php echo e($data['order_count_change']); ?> đơn</span>
                    <?php if($data['order_count_change'] > 0): ?>
                        <i class="fas fa-arrow-up text-success"></i>
                    <?php elseif($data['order_count_change'] < 0): ?>
                        <i class="fas fa-arrow-down text-danger"></i>
                    <?php else: ?>
                        <i class="fas fa-arrow-right text-muted"></i>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\datn-wd110-46\backend\resources\views/thongke/orders.blade.php ENDPATH**/ ?>