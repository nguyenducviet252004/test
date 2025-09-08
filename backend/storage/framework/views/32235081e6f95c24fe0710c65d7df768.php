<?php $__env->startSection('title'); ?>
    Danh sách sản phẩm
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_admin'); ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success text-center mt-5">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger mt-5 ">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <h1 class="text-center mt-5 mb-3">Danh sách sản phẩm</h1>

    <a href="<?php echo e(route('products.create')); ?>" class="btn btn-outline-success mb-4"
        style="font-size: 1.1em; padding: 10px 20px;">Thêm mới sản phẩm</a>

    <div class="d-flex gap-3 mb-4">
        <!-- Price Order Filter -->
        <form style="width: 200px;" method="GET" action="<?php echo e(route('products.index')); ?>">
            <select style="padding: 10px;" name="price_order" class="form-control" onchange="this.form.submit()">
                <option value="">Sắp xếp giá</option>
                <option value="asc" <?php echo e(request('price_order') == 'asc' ? 'selected' : ''); ?>>Giá tăng dần</option>
                <option value="desc" <?php echo e(request('price_order') == 'desc' ? 'selected' : ''); ?>>Giá giảm dần</option>
            </select>
        </form>

        <!-- Status Filter -->
        <form style="width: 200px;" method="GET" action="<?php echo e(route('products.index')); ?>">
            <select style="padding: 10px;" name="is_active" class="form-control" onchange="this.form.submit()">
                <option value="">Tất cả trạng thái</option>
                <option value="1" <?php echo e(request('is_active') == '1' ? 'selected' : ''); ?>>Hiển thị</option>
                <option value="0" <?php echo e(request('is_active') == '0' ? 'selected' : ''); ?>>Ẩn</option>
            </select>
        </form>

        <!-- Price Range Filter -->
        <form style="width: 200px;" method="GET" action="<?php echo e(route('products.index')); ?>">
            <select style="padding: 10px;" name="price_range" class="form-control" onchange="this.form.submit()">
                <option value="">Chọn mức giá</option>
                <option value="under_200k" <?php echo e(request('price_range') == 'under_200k' ? 'selected' : ''); ?>>Dưới 200k</option>
                <option value="200k_500k" <?php echo e(request('price_range') == '200k_500k' ? 'selected' : ''); ?>>200k - 500k</option>
                <option value="over_500k" <?php echo e(request('price_range') == 'over_500k' ? 'selected' : ''); ?>>Trên 500k</option>
            </select>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
        <style>
            .table-responsive table.table {
                min-width: 1200px;
            }
        </style>
            <thead class="table-dark">
                <tr>
                    <th style="min-width: 50px;">ID</th>
                    <th style="min-width: 80px;">Hình ảnh</th>
                    <th style="min-width: 100px;">Tên sản phẩm</th>
                    <th style="min-width: 140px;">Slug</th>
                    <th style="min-width: 120px;">Danh mục</th>
                    
                    <th style="min-width: 110px;">Tổng tồn kho</th>
                    
                    <th style="min-width: 100px;">Trạng thái</th>
                    
                    <th style="min-width: 140px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($product->id); ?></td>
                        <td>
                            <?php if($product->img_thumb): ?>
                                <img src="<?php echo e(Storage::url($product->img_thumb)); ?>" alt="<?php echo e($product->name); ?>"
                                     style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                            <?php else: ?>
                                <span class="text-muted">Chưa có ảnh</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?php echo e($product->name); ?></strong>
                        </td>
                        <td>
                            <code><?php echo e($product->slug ?? 'Chưa có slug'); ?></code>
                        </td>
                        <td><?php echo e($product->categories->name ?? 'Không có'); ?></td>
                        
                        <td>
                            <span class="badge bg-info">
                                <?php echo e($product->total_quantity ?? 0); ?>

                            </span>
                        </td>
                        
                        <td>
                            <?php if($product->is_active): ?>
                                <span class="badge bg-success">Hiển thị</span>
                                
                            <?php else: ?>
                                <span class="badge bg-danger">Ẩn</span>
                                
                            <?php endif; ?>
                        </td>
                        
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                <!-- Xem chi tiết -->
                                <a href="<?php echo e(route('products.show', $product->id)); ?>"
                                   class="btn btn-info btn-sm"
                                   data-bs-toggle="tooltip"
                                   title="Xem chi tiết sản phẩm">
                                    <i class="fas fa-eye"></i> Chi tiết
                                </a>

                                <!-- Toggle trạng thái -->
                                <form method="POST" action="<?php echo e(route('products.toggle-status', $product->id)); ?>" style="display: inline;">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit"
                                            class="btn btn-secondary btn-sm"
                                            data-bs-toggle="tooltip"
                                            title="<?php echo e($product->is_active ? 'Ẩn sản phẩm' : 'Hiển thị sản phẩm'); ?>">
                                        <?php if($product->is_active): ?>
                                            <i class="fas fa-eye-slash"></i> Ẩn
                                        <?php else: ?>
                                            <i class="fas fa-eye"></i> Hiện
                                        <?php endif; ?>
                                    </button>
                                </form>

                                <!-- Xóa sản phẩm -->
                                <form method="POST" action="<?php echo e(route('products.destroy', $product->id)); ?>"
                                      style="display: inline;"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này? Tất cả biến thể cũng sẽ bị xóa!')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            data-bs-toggle="tooltip"
                                            title="Xóa sản phẩm vĩnh viễn">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </div>
                                <style>
                                    /* Đảm bảo các nút thao tác luôn nằm cùng một hàng, không bị lệch khi không có ảnh */
                                    td:last-child .d-flex {
                                        flex-wrap: nowrap !important;
                                        gap: 6px;
                                        justify-content: center;
                                        align-items: center;
                                    }
                                    td:last-child .btn {
                                        min-width: 70px;
                                    }
                                </style>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="11" class="text-center">Không có sản phẩm nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        <?php echo e($products->appends(request()->query())->links()); ?>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Auto-submit forms when select changes
    document.querySelectorAll('select[onchange]').forEach(function(select) {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });

    // Initialize Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\New folder (2)\backend\resources\views/products/index.blade.php ENDPATH**/ ?>