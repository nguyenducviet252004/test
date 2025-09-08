<?php $__env->startSection('title'); ?>
    Sửa biến thể - <?php echo e($product->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_admin'); ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger mt-5">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
        <div>
            <h1>Sửa biến thể</h1>
            <h5 class="text-muted">Sản phẩm: <strong><?php echo e($product->name); ?></strong></h5>
        </div>
        <div>
            <a href="<?php echo e(route('product-variants.index', $product->id)); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <!-- Product Info Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <?php if($product->img_thumb): ?>
                        <img src="<?php echo e(Storage::url($product->img_thumb)); ?>" alt="<?php echo e($product->name); ?>"
                             class="img-fluid rounded" style="max-height: 80px;">
                    <?php endif; ?>
                </div>
                <div class="col-md-10">
                    <h6 class="mb-1"><?php echo e($product->name); ?></h6>
                    <p class="text-muted mb-0">
                        Danh mục: <?php echo e($product->categories->name ?? 'Không có'); ?> |
                        Biến thể ID: <?php echo e($variant->id); ?>

                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Form -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin biến thể</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('product-variants.update', [$product->id, $variant->id])); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="size_id" class="form-label">Kích thước <span class="text-danger">*</span></label>
                                    <select name="size_id" id="size_id" class="form-control" required>
                                        <option value="">Chọn kích thước</option>
                                        <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($size->id); ?>"
                                                <?php echo e((old('size_id', $variant->size_id) == $size->id) ? 'selected' : ''); ?>>
                                                <?php echo e($size->size); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['size_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="color_id" class="form-label">Màu sắc <span class="text-danger">*</span></label>
                                    <select name="color_id" id="color_id" class="form-control" required>
                                        <option value="">Chọn màu sắc</option>
                                        <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($color->id); ?>"
                                                <?php echo e((old('color_id', $variant->color_id) == $color->id) ? 'selected' : ''); ?>>
                                                <?php echo e($color->name_color); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['color_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Giá gốc <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" name="price" id="price" class="form-control"
                                               min="0" step="1000" required
                                               value="<?php echo e(old('price', $variant->price)); ?>"
                                               placeholder="VD: 150000">
                                        <span class="input-group-text">đ</span>
                                    </div>
                                    <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price_sale" class="form-label">Giá sale (không bắt buộc)</label>
                                    <div class="input-group">
                                        <input type="number" name="price_sale" id="price_sale" class="form-control"
                                               min="0" step="1000"
                                               value="<?php echo e(old('price_sale', $variant->price_sale)); ?>"
                                               placeholder="VD: 120000">
                                        <span class="input-group-text">đ</span>
                                    </div>
                                    <?php $__errorArgs = ['price_sale'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="text-muted">Để trống nếu không có giá khuyến mãi</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Số lượng <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" id="quantity" class="form-control"
                                   min="0" required value="<?php echo e(old('quantity', $variant->quantity)); ?>"
                                   placeholder="VD: 20">
                            <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?php echo e(route('product-variants.index', $product->id)); ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Hủy
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật biến thể
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Current Variant Info & Preview -->
        <div class="col-md-4">
            <!-- Current Variant Info -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Thông tin hiện tại</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <i class="fas fa-tshirt fa-2x text-primary mb-2"></i>
                        <div class="mb-2">
                            <span class="badge bg-info me-1"><?php echo e($variant->size->size ?? 'N/A'); ?></span>
                            <span class="badge bg-secondary"><?php echo e($variant->color->name_color ?? 'N/A'); ?></span>
                        </div>
                        <div class="mb-2">
                            <?php if($variant->price_sale): ?>
                                <span class="text-decoration-line-through text-muted"><?php echo e(number_format($variant->price)); ?>đ</span>
                                <br><strong class="text-danger"><?php echo e(number_format($variant->price_sale)); ?>đ</strong>
                            <?php else: ?>
                                <strong><?php echo e(number_format($variant->price)); ?>đ</strong>
                            <?php endif; ?>
                        </div>
                        <div>
                            <?php if($variant->quantity > 0): ?>
                                <span class="badge bg-success"><?php echo e($variant->quantity); ?> sản phẩm</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Hết hàng</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preview Changes -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Xem trước thay đổi</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <i class="fas fa-eye fa-2x text-muted mb-2"></i>
                        <div id="preview-combination">
                            <span class="text-muted">Thông tin sẽ hiển thị khi bạn thay đổi</span>
                        </div>
                        <div id="preview-price" class="mt-2"></div>
                    </div>
                </div>
            </div>

            <!-- Other Variants -->
            <?php if($product->variants->where('id', '!=', $variant->id)->count() > 0): ?>
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Biến thể khác (<?php echo e($product->variants->where('id', '!=', $variant->id)->count()); ?>)</h6>
                    </div>
                    <div class="card-body">
                        <div class="small">
                            <?php $__currentLoopData = $product->variants->where('id', '!=', $variant->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $otherVariant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="d-flex justify-content-between mb-1">
                                    <span><?php echo e($otherVariant->size->size ?? 'N/A'); ?> - <?php echo e($otherVariant->color->name_color ?? 'N/A'); ?></span>
                                    <span class="text-success"><?php echo e(number_format($otherVariant->effective_price)); ?>đ</span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="alert alert-info mt-2 mb-0">
                            <small><i class="fas fa-info-circle"></i> Không thể trùng với biến thể khác</small>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sizeSelect = document.getElementById('size_id');
        const colorSelect = document.getElementById('color_id');
        const priceInput = document.getElementById('price');
        const priceSaleInput = document.getElementById('price_sale');
        const quantityInput = document.getElementById('quantity');
        const previewCombination = document.getElementById('preview-combination');
        const previewPrice = document.getElementById('preview-price');

        // Current variant data
        const currentVariant = {
            size_id: <?php echo e($variant->size_id); ?>,
            color_id: <?php echo e($variant->color_id); ?>,
            price: <?php echo e($variant->price); ?>,
            price_sale: <?php echo e($variant->price_sale ?? 0); ?>,
            quantity: <?php echo e($variant->quantity); ?>

        };

        // Other variants for duplicate check
        const otherVariants = <?php echo json_encode($product->variants->where('id', '!=', $variant->id)->map(function($v) {
            return $v->size_id . '-' . $v->color_id;
        })->values()) ?>;

        function updatePreview() {
            const sizeText = sizeSelect.options[sizeSelect.selectedIndex]?.text || '';
            const colorText = colorSelect.options[colorSelect.selectedIndex]?.text || '';
            const price = parseInt(priceInput.value) || 0;
            const priceSale = parseInt(priceSaleInput.value) || 0;
            const quantity = parseInt(quantityInput.value) || 0;

            // Check if anything changed
            const hasChanges = (
                sizeSelect.value != currentVariant.size_id ||
                colorSelect.value != currentVariant.color_id ||
                price != currentVariant.price ||
                priceSale != currentVariant.price_sale ||
                quantity != currentVariant.quantity
            );

            if (!hasChanges) {
                previewCombination.innerHTML = '<span class="text-muted">Chưa có thay đổi</span>';
                previewPrice.innerHTML = '';
                return;
            }

            if (sizeText && colorText && sizeText !== 'Chọn kích thước' && colorText !== 'Chọn màu sắc') {
                const combination = sizeSelect.value + '-' + colorSelect.value;

                // Check for duplicates (excluding current variant)
                if (otherVariants.includes(combination)) {
                    previewCombination.innerHTML = `
                        <span class="text-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            ${sizeText} - ${colorText}
                            <br><small>Trùng với biến thể khác!</small>
                        </span>
                    `;
                    previewPrice.innerHTML = '';
                } else {
                    previewCombination.innerHTML = `
                        <span class="text-warning">
                            <i class="fas fa-edit"></i>
                            ${sizeText} - ${colorText}
                            <br><small>Thay đổi mới</small>
                        </span>
                    `;

                    if (price > 0) {
                        let priceDisplay = `<strong>${price.toLocaleString()}đ</strong>`;
                        if (priceSale > 0) {
                            priceDisplay = `
                                <span class="text-decoration-line-through text-muted">${price.toLocaleString()}đ</span>
                                <br><strong class="text-danger">${priceSale.toLocaleString()}đ</strong>
                            `;
                        }
                        priceDisplay += `<br><small class="text-muted">${quantity} sản phẩm</small>`;
                        previewPrice.innerHTML = priceDisplay;
                    } else {
                        previewPrice.innerHTML = '';
                    }
                }
            } else {
                previewCombination.innerHTML = '<span class="text-muted">Chọn size và màu để xem trước</span>';
                previewPrice.innerHTML = '';
            }
        }

        // Validate price sale
        function validatePriceSale() {
            const price = parseInt(priceInput.value) || 0;
            const priceSale = parseInt(priceSaleInput.value) || 0;

            if (priceSale > 0 && priceSale >= price) {
                priceSaleInput.setCustomValidity('Giá sale phải nhỏ hơn giá gốc');
            } else {
                priceSaleInput.setCustomValidity('');
            }
        }

        // Event listeners
        sizeSelect.addEventListener('change', updatePreview);
        colorSelect.addEventListener('change', updatePreview);
        priceInput.addEventListener('input', function() {
            updatePreview();
            validatePriceSale();
        });
        priceSaleInput.addEventListener('input', function() {
            updatePreview();
            validatePriceSale();
        });
        quantityInput.addEventListener('input', updatePreview);

        // Initial preview
        updatePreview();
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\datn-wd110-46\backend\resources\views/product-variants/edit.blade.php ENDPATH**/ ?>