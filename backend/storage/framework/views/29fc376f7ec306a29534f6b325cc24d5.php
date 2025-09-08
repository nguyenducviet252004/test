<?php $__env->startSection('title'); ?>
    Quản lý biến thể - <?php echo e($product->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_admin'); ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success text-center mt-5">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger mt-5">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
        <div>
            <h1>Quản lý biến thể</h1>
            <h5 class="text-muted">Sản phẩm: <strong><?php echo e($product->name); ?></strong></h5>
        </div>
        <div>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Quay lại danh sách
            </a>
            <a href="<?php echo e(route('products.show', $product->id)); ?>" class="btn btn-info me-2">
                <i class="fas fa-eye"></i> Xem sản phẩm
            </a>
        </div>
    </div>

    <!-- Product Summary Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <?php if($product->img_thumb): ?>
                        <img src="<?php echo e(Storage::url($product->img_thumb)); ?>" alt="<?php echo e($product->name); ?>"
                             class="img-fluid rounded" style="max-height: 100px;">
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-1"><?php echo e($product->name); ?></h5>
                    <p class="text-muted mb-1">Danh mục: <?php echo e($product->categories->name ?? 'Không có'); ?></p>
                    <p class="text-muted mb-0">Slug: <code><?php echo e($product->slug); ?></code></p>
                </div>
                <div class="col-md-4">
                    <div class="row text-center">
                        <div class="col-4">
                            <strong class="d-block"><?php echo e($variants->total()); ?></strong>
                            <small class="text-muted">Biến thể</small>
                        </div>
                        <div class="col-4">
                            <strong class="d-block"><?php echo e($product->total_quantity ?? 0); ?></strong>
                            <small class="text-muted">Tổng tồn kho</small>
                        </div>
                        <div class="col-4">
                            <?php if($product->variants->count() > 0): ?>
                                <strong class="d-block"><?php echo e(number_format($product->min_price)); ?>đ - <?php echo e(number_format($product->max_price)); ?>đ</strong>
                                <small class="text-muted">Khoảng giá</small>
                            <?php else: ?>
                                <strong class="d-block text-warning">Chưa có giá</strong>
                                <small class="text-muted">Khoảng giá</small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mb-4">
        <div class="col-md-6">
            <a href="<?php echo e(route('product-variants.create', $product->id)); ?>" class="btn btn-primary btn-lg me-3">
                <i class="fas fa-plus"></i> Thêm biến thể mới
            </a>
        </div>
        <div class="col-md-6 text-end">
            <?php if($variants->total() == 0): ?>
                <button class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#bulkCreateModal">
                    <i class="fas fa-magic"></i> Tạo tất cả biến thể
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Variants Table -->
    <?php if($variants->count() > 0): ?>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Danh sách biến thể (<?php echo e($variants->total()); ?>)</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Kích thước</th>
                                <th>Màu sắc</th>
                                <th>Giá gốc</th>
                                <th>Giá sale</th>
                                <th>Giá hiệu lực</th>
                                <th>Số lượng</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($variant->id); ?></td>
                                    <td>
                                        <span class="badge bg-info"><?php echo e($variant->size->size ?? 'N/A'); ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary"><?php echo e($variant->color->name_color ?? 'N/A'); ?></span>
                                    </td>
                                    <td><?php echo e(number_format($variant->price)); ?>đ</td>
                                    <td>
                                        <?php if($variant->price_sale): ?>
                                            <span class="text-danger fw-bold"><?php echo e(number_format($variant->price_sale)); ?>đ</span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong class="text-success"><?php echo e(number_format($variant->effective_price)); ?>đ</strong>
                                    </td>
                                    <td>
                                        <?php if($variant->quantity > 0): ?>
                                            <span class="badge bg-success"><?php echo e($variant->quantity); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Hết hàng</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($variant->quantity > 0): ?>
                                            <span class="badge bg-success">Có sẵn</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Hết hàng</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('product-variants.edit', [$product->id, $variant->id])); ?>"
                                               class="btn btn-sm btn-warning" title="Sửa biến thể">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <form method="POST"
                                                  action="<?php echo e(route('product-variants.destroy', [$product->id, $variant->id])); ?>"
                                                  style="display: inline;"
                                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa biến thể này?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger" title="Xóa biến thể">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($variants->links()); ?>

        </div>
    <?php else: ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h5>Chưa có biến thể nào</h5>
                <p class="text-muted">Hãy thêm biến thể để khách hàng có thể chọn size và màu sắc.</p>
                <a href="<?php echo e(route('product-variants.create', $product->id)); ?>" class="btn btn-primary me-2">
                    <i class="fas fa-plus"></i> Thêm biến thể đầu tiên
                </a>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bulkCreateModal">
                    <i class="fas fa-magic"></i> Tạo tất cả biến thể
                </button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Bulk Create Modal -->
    <div class="modal fade" id="bulkCreateModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="<?php echo e(route('product-variants.bulk-create', $product->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Tạo tất cả biến thể</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted">Tạo biến thể cho tất cả combinations của size và màu có trong hệ thống với cùng giá và số lượng.</p>

                        <div class="mb-3">
                            <label for="bulk_price" class="form-label">Giá cơ bản <span class="text-danger">*</span></label>
                            <input type="number" name="price" id="bulk_price" class="form-control"
                                   min="0" step="1000" required placeholder="VD: 150000">
                        </div>

                        <div class="mb-3">
                            <label for="bulk_quantity" class="form-label">Số lượng <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" id="bulk_quantity" class="form-control"
                                   min="0" required placeholder="VD: 20">
                        </div>

                        <div class="mb-3">
                            <label for="bulk_price_sale" class="form-label">Giá sale (không bắt buộc)</label>
                            <input type="number" name="price_sale" id="bulk_price_sale" class="form-control"
                                   min="0" step="1000" placeholder="VD: 120000">
                        </div>

                        <div class="alert alert-info">
                            <small><i class="fas fa-info-circle"></i> Chỉ tạo các biến thể chưa tồn tại. Biến thể đã có sẽ không bị thay đổi.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-magic"></i> Tạo tất cả
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Validation for bulk create modal
    document.getElementById('bulk_price_sale').addEventListener('input', function() {
        const price = parseInt(document.getElementById('bulk_price').value) || 0;
        const priceSale = parseInt(this.value) || 0;

        if (priceSale > 0 && priceSale >= price) {
            this.setCustomValidity('Giá sale phải nhỏ hơn giá gốc');
        } else {
            this.setCustomValidity('');
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\New folder (2)\backend\resources\views/product-variants/index.blade.php ENDPATH**/ ?>