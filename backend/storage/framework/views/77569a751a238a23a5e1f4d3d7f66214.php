<?php $__env->startSection('title'); ?>
    Chi tiết sản phẩm - <?php echo e($product->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_admin'); ?>

    <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
        <div>
            <h1>Chi tiết sản phẩm</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('products.index')); ?>">Sản phẩm</a></li>
                    <li class="breadcrumb-item active"><?php echo e($product->name); ?></li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <a href="<?php echo e(route('product-variants.index', $product->id)); ?>" class="btn btn-primary me-2">
                <i class="fas fa-list"></i> Quản lý biến thể
            </a>
            <a href="<?php echo e(route('products.edit', $product->id)); ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> Sửa sản phẩm
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Product Basic Info -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin cơ bản</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?php if($product->img_thumb): ?>
                                <img src="<?php echo e(Storage::url($product->img_thumb)); ?>" alt="<?php echo e($product->name); ?>"
                                     class="img-fluid rounded shadow">
                            <?php else: ?>
                                <div class="text-center py-5 bg-light rounded">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                    <p class="text-muted mt-2">Chưa có ảnh</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8">
                            <h3 class="mb-3"><?php echo e($product->name); ?></h3>

                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>ID:</strong>
                                </div>
                                <div class="col-sm-8">
                                    <code><?php echo e($product->id); ?></code>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>Slug:</strong>
                                </div>
                                <div class="col-sm-8">
                                    <code><?php echo e($product->slug ?? 'Chưa có slug'); ?></code>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>Danh mục:</strong>
                                </div>
                                <div class="col-sm-8">
                                    <span class="badge bg-info"><?php echo e($product->categories->name ?? 'Không có'); ?></span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>Trạng thái:</strong>
                                </div>
                                <div class="col-sm-8">
                                    <?php if($product->is_active): ?>
                                        <span class="badge bg-success">Đang hiển thị</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Đã ẩn</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>Lượt xem:</strong>
                                </div>
                                <div class="col-sm-8">
                                    <?php echo e(number_format($product->view ?? 0)); ?>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>Ngày tạo:</strong>
                                </div>
                                <div class="col-sm-8">
                                    <?php echo e($product->created_at ? $product->created_at->format('d/m/Y H:i') : 'N/A'); ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if($product->description): ?>
                        <div class="mt-4">
                            <h6>Mô tả:</h6>
                            <div class="border p-3 rounded bg-light">
                                <?php echo nl2br(e($product->description)); ?>

                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Stats & Quick Actions -->
        <div class="col-md-4">
            <!-- Product Stats -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Thống kê biến thể</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="mb-3">
                                <h4 class="text-primary mb-1"><?php echo e($product->variants->count()); ?></h4>
                                <small class="text-muted">Biến thể</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <h4 class="text-success mb-1"><?php echo e($product->total_quantity ?? 0); ?></h4>
                                <small class="text-muted">Tổng tồn kho</small>
                            </div>
                        </div>
                    </div>

                    <?php if($product->variants->count() > 0): ?>
                        <div class="row text-center">
                            <div class="col-12">
                                <div class="mb-2">
                                    <h5 class="text-info mb-1"><?php echo e(number_format($product->min_price)); ?>đ - <?php echo e(number_format($product->max_price)); ?>đ</h5>
                                    <small class="text-muted">Khoảng giá</small>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning text-center mb-0">
                            <i class="fas fa-exclamation-triangle"></i><br>
                            <small>Chưa có biến thể nào</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Thao tác nhanh</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?php echo e(route('product-variants.index', $product->id)); ?>" class="btn btn-primary">
                            <i class="fas fa-list"></i> Quản lý biến thể
                        </a>
                        <a href="<?php echo e(route('product-variants.create', $product->id)); ?>" class="btn btn-success">
                            <i class="fas fa-plus"></i> Thêm biến thể mới
                        </a>
                        <a href="<?php echo e(route('products.edit', $product->id)); ?>" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Sửa thông tin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Images -->
    <?php if($product->galleries->count() > 0): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Thư viện ảnh (<?php echo e($product->galleries->count()); ?>)</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php $__currentLoopData = $product->galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-2 col-sm-3 col-4 mb-3">
                            <div class="position-relative">
                                <?php
                                    // Check if image_path already contains full URL
                                    $imageSrc = str_starts_with($gallery->image_path, 'http')
                                        ? $gallery->image_path
                                        : Storage::url($gallery->image_path);
                                ?>
                                <img src="<?php echo e($imageSrc); ?>" alt="Gallery Image"
                                     class="img-fluid rounded shadow-sm"
                                     style="width: 100%; height: 120px; object-fit: cover;"
                                     data-bs-toggle="modal" data-bs-target="#imageModal<?php echo e($gallery->id); ?>">
                            </div>

                            <!-- Image Modal -->
                            <div class="modal fade" id="imageModal<?php echo e($gallery->id); ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ảnh chi tiết</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="<?php echo e($imageSrc); ?>" alt="Gallery Image"
                                                 class="img-fluid rounded">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Product Variants -->
    <?php if($product->variants->count() > 0): ?>
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Biến thể sản phẩm (<?php echo e($product->variants->count()); ?>)</h5>
                    <a href="<?php echo e(route('product-variants.index', $product->id)); ?>" class="btn btn-sm btn-primary">
                        Xem tất cả
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Size</th>
                                <th>Màu</th>
                                <th>Giá gốc</th>
                                <th>Giá sale</th>
                                <th>Số lượng</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $product->variants->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
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
                                        <?php if($variant->quantity > 0): ?>
                                            <span class="badge bg-success"><?php echo e($variant->quantity); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">0</span>
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
                                        <a href="<?php echo e(route('product-variants.edit', [$product->id, $variant->id])); ?>"
                                           class="btn btn-sm btn-warning" title="Sửa biến thể">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <?php if($product->variants->count() > 10): ?>
                    <div class="card-footer text-center">
                        <small class="text-muted">Hiển thị 10/<?php echo e($product->variants->count()); ?> biến thể</small>
                        <a href="<?php echo e(route('product-variants.index', $product->id)); ?>" class="ms-2">Xem tất cả →</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h5>Chưa có biến thể nào</h5>
                <p class="text-muted">Sản phẩm này chưa có biến thể. Hãy thêm các biến thể để khách hàng có thể lựa chọn size và màu sắc.</p>
                <a href="<?php echo e(route('product-variants.create', $product->id)); ?>" class="btn btn-primary me-2">
                    <i class="fas fa-plus"></i> Thêm biến thể đầu tiên
                </a>
                <a href="<?php echo e(route('product-variants.index', $product->id)); ?>" class="btn btn-success">
                    <i class="fas fa-magic"></i> Tạo tất cả biến thể
                </a>
            </div>
        </div>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Add click handlers for gallery images
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function(element) {
        element.style.cursor = 'pointer';
        element.addEventListener('click', function() {
            // Optional: Add any additional functionality when clicking gallery images
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\New folder (2)\backend\resources\views/products/show.blade.php ENDPATH**/ ?>