<h4 class="text-center mb-4">Top 10 Sản Phẩm Bán Chạy Nhất</h4>
<?php if($topProducts && count($topProducts) > 0): ?>
    <div class="list-group">
        <?php $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="list-group-item d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <?php
                        $img = !empty($product['image']) ? $product['image'] : null;
                    ?>
                    <img
                        src="<?php echo e($img ? asset('storage/' . $img) : asset('assets/images/no-image.png')); ?>"
                        alt="<?php echo e($product['product_name']); ?>"
                        class="rounded-circle"
                        style="width: 60px; height: 60px; margin-right: 15px;"
                        onerror="this.onerror=null;this.src='<?php echo e(asset('assets/images/no-image.png')); ?>';"
                    >
                    <div>
                        <h5 class="mb-1"><?php echo e($product['product_name']); ?></h5>
                        <div class="text-muted">
                            <span>Số đơn: <?php echo e($product['sales_count']); ?></span> |
                            <span>Số lượng bán: <?php echo e($product['total_quantity']); ?></span>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="badge bg-primary"><?php echo e($product['sales_count']); ?> đơn</span>
                    <span class="badge bg-success"><?php echo e($product['total_quantity']); ?> bán</span>
                    <span class="badge bg-info"><?php echo e(number_format($product['total_revenue'], 0, ',', '.')); ?> VNĐ</span>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php else: ?>
    <p class="text-center">Không có sản phẩm bán chạy nào trong khoảng thời gian này.</p>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\New folder (2)\backend\resources\views/thongke/topproduct.blade.php ENDPATH**/ ?>