<h3 class="mb-5 text-center">Bộ lọc không được áp dụng tại đây</h3>

<?php if($data['total_stock']->isEmpty() && $data['nearly_sold_out']->isEmpty()): ?>
    <p class="text-muted text-center">Không có sản phẩm nào thỏa mãn điều kiện.</p>
<?php else: ?>
    <div class="row mt-3 mb-5">
        <!-- Cột bên trái: Tồn kho trên 3 tháng -->
        <div class="col-md-6">
            <p class="text-center">Danh sách sản phẩm tồn kho trên 3 tháng kể từ thời điểm thêm vào hệ thống</p>
            <?php if($data['total_stock']->isEmpty()): ?>
                <p class="text-muted text-center">Không có sản phẩm tồn kho thỏa mãn điều kiện.</p>
            <?php else: ?>
                <table class="table table-bordered mt-4 text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Hình ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Tổng số lượng</th>
                            <th>Đã bán</th>
                            <th>Tồn kho</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $data['total_stock']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td>
                                    <img src="<?php echo e(asset('storage/' . $product->img_thumb)); ?>"
                                         alt="<?php echo e($product->name); ?>"
                                         width="50"
                                         height="50">
                                </td>
                                <td><?php echo e($product->name); ?></td>
                                <td><?php echo e($product->variants->sum('quantity')); ?></td>
                                <td>
                                    <?php
                                        $sold = $product->variants->sum(function($variant) {
                                            return $variant->sold_quantity ?? 0;
                                        });
                                    ?>
                                    <?php echo e($sold); ?>

                                </td>
                                <td><?php echo e($product->variants->sum('quantity')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <!-- Cột bên phải: Sản phẩm sắp bán hết -->
        <div class="col-md-6">
            <p class="text-center">Danh sách sản phẩm sắp bán hết (dưới 3 tháng từ thời điểm thêm vào hệ thống)</p>
            <?php if($data['nearly_sold_out']->isEmpty()): ?>
                <p class="text-muted text-center">Không có sản phẩm nào sắp bán hết thỏa mãn điều kiện.</p>
            <?php else: ?>
                <table class="table table-bordered mt-4 text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Hình ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Tổng số lượng</th>
                            <th>Đã bán</th>
                            <th>Tồn kho</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $data['nearly_sold_out']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td>
                                    <img src="<?php echo e(asset('storage/' . $product->img_thumb)); ?>"
                                         alt="<?php echo e($product->name); ?>"
                                         width="50"
                                         height="50">
                                </td>
                                <td><?php echo e($product->name); ?></td>
                                <td><?php echo e($product->variants->sum('quantity')); ?></td>
                                <td>
                                    <?php
                                        $sold = $product->variants->sum(function($variant) {
                                            return $variant->sold_quantity ?? 0;
                                        });
                                    ?>
                                    <?php echo e($sold); ?>

                                </td>
                                <td><?php echo e($product->variants->sum('quantity')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\New folder (2)\backend\resources\views/thongke/tonkho.blade.php ENDPATH**/ ?>