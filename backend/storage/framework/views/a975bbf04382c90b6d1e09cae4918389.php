<?php $__env->startSection('title'); ?>
    Thêm biến thể mới - <?php echo e($product->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_admin'); ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger mt-5">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
        <div>
            <h1>Thêm biến thể mới</h1>
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
                        Đã có: <?php echo e($product->variants->count()); ?> biến thể
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
                    <form action="<?php echo e(route('product-variants.store', $product->id)); ?>" method="POST" novalidate>
                        <?php echo csrf_field(); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="size_id" class="form-label">Kích thước <span class="text-danger">*</span></label>
                                    <select name="size_id" id="size_id" class="form-control" required>
                                        <option value="">Chọn kích thước</option>
                                        <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($size->id); ?>" <?php echo e(old('size_id') == $size->id ? 'selected' : ''); ?>>
                                                <?php echo e($size->size); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['size_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><?php echo e($message); ?></div>
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
                                            <option value="<?php echo e($color->id); ?>" <?php echo e(old('color_id') == $color->id ? 'selected' : ''); ?>>
                                                <?php echo e($color->name_color); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['color_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><?php echo e($message); ?></div>
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
                                               min="0" step="1000" required value="<?php echo e(old('price')); ?>"
                                               placeholder="VD: 150000">
                                        <span class="input-group-text">đ</span>
                                    </div>
                                    <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><?php echo e($message); ?></div>
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
                                               min="0" step="1000" value="<?php echo e(old('price_sale')); ?>"
                                               placeholder="VD: 120000">
                                        <span class="input-group-text">đ</span>
                                    </div>
                                    <?php $__errorArgs = ['price_sale'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><?php echo e($message); ?></div>
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
                                   min="0" required value="<?php echo e(old('quantity')); ?>" placeholder="VD: 20">
                            <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1"><?php echo e($message); ?></div>
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
                                <i class="fas fa-save"></i> Lưu biến thể
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview & Existing Variants -->
        <div class="col-md-4">
            

            <!-- Existing Variants Warning -->
            <?php if($product->variants->count() > 0): ?>
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Biến thể đã có (<?php echo e($product->variants->count()); ?>)</h6>
                    </div>
                    <div class="card-body">
                        <div class="small">
                            <?php $__currentLoopData = $product->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="d-flex justify-content-between mb-1">
                                    <span><?php echo e($variant->size->size ?? 'N/A'); ?> - <?php echo e($variant->color->name_color ?? 'N/A'); ?></span>
                                    <span class="text-success"><?php echo e(number_format($variant->effective_price)); ?>đ</span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="alert alert-info mt-2 mb-0">
                            <small><i class="fas fa-info-circle"></i> Không thể tạo biến thể trùng lặp</small>
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
        // Validate price sale
        function validatePriceSale() {
            const priceInput = document.getElementById('price');
            const priceSaleInput = document.getElementById('price_sale');
            const price = parseInt(priceInput.value) || 0;
            const priceSale = parseInt(priceSaleInput.value) || 0;

            if (priceSale > 0 && priceSale >= price) {
                priceSaleInput.setCustomValidity('Giá sale phải nhỏ hơn giá gốc');
            } else {
                priceSaleInput.setCustomValidity('');
            }
        }

        const priceInput = document.getElementById('price');
        const priceSaleInput = document.getElementById('price_sale');

        if (priceInput && priceSaleInput) {
            priceInput.addEventListener('input', validatePriceSale);
            priceSaleInput.addEventListener('input', validatePriceSale);
        }

        // Initial validation
        if (priceInput && priceSaleInput) {
            validatePriceSale();
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\datn-wd110-46\backend\resources\views/product-variants/create.blade.php ENDPATH**/ ?>