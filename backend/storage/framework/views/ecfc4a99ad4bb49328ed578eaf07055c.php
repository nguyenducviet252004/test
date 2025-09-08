<?php $__env->startSection('title'); ?>
    Cập nhật sản phẩm - <?php echo e($product->name); ?>

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
            <h1>Cập nhật sản phẩm</h1>
            <h5 class="text-muted"><?php echo e($product->name); ?></h5>
        </div>
        <div>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <a href="<?php echo e(route('product-variants.index', $product->id)); ?>" class="btn btn-primary">
                <i class="fas fa-list"></i> Quản lý biến thể
            </a>
        </div>
    </div>

    <!-- Alert about variants -->
    <div class="alert alert-info mb-4">
        <i class="fas fa-info-circle"></i>
        <strong>Lưu ý:</strong> Để thay đổi giá và số lượng, hãy sử dụng
        <a href="<?php echo e(route('product-variants.index', $product->id)); ?>" class="alert-link">quản lý biến thể</a>.
    </div>

    <div class="row">
        <!-- Form -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin cơ bản</h5>
                </div>
                <div class="card-body">
    <form action="<?php echo e(route('products.update', $product->id)); ?>" method="POST" enctype="multipart/form-data" novalidate>
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control"
                                   value="<?php echo e(old('name', $product->name)); ?>" required>
                            <?php $__errorArgs = ['name'];
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

        <div class="mb-3">
                            <label for="img_thumb" class="form-label">Ảnh đại diện</label>
                            <input type="file" name="img_thumb" id="img_thumb" class="form-control"
                                   accept="image/*" onchange="previewImage()">
                            <?php $__errorArgs = ['img_thumb'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <?php if($product->img_thumb): ?>
                                <div class="mt-2" id="currentImageContainer">
                                    <label class="form-label">Ảnh hiện tại:</label>
                                    <div>
                                        <img src="<?php echo e(Storage::url($product->img_thumb)); ?>" alt="Current Image"
                                             id="currentImage" class="rounded"
                                             style="width: 150px; height: 100px; object-fit: cover;">
                                    </div>
                </div>
            <?php endif; ?>

                            <div id="imagePreviewContainer" style="display: none;">
                                <label class="form-label mt-2">Ảnh mới được chọn:</label>
                                <div>
                                    <img id="imagePreview" src="" alt="Selected Image"
                                         class="rounded" style="width: 150px; height: 100px; object-fit: cover;">
                                </div>
                            </div>
        </div>

        <div class="mb-3">
                            <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">Chọn danh mục</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"
                                        <?php echo e(old('category_id', $product->category_id) == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['category_id'];
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

        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea name="description" id="description" class="form-control" rows="5"
                                      placeholder="Mô tả sản phẩm..."><?php echo e(old('description', $product->description)); ?></textarea>
                            <?php $__errorArgs = ['description'];
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

        <div class="mb-3">
                            <label for="images" class="form-label">Thêm ảnh gallery mới</label>
                            <input type="file" id="image-input" name="images[]" multiple class="form-control" accept="image/*">
                            <div id="image-preview-container" class="mt-2"></div>
                            <small class="text-muted">Chọn nhiều ảnh để thêm vào gallery</small>
                            <?php $__errorArgs = ['images.*'];
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

        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                       value="1" <?php echo e(old('is_active', $product->is_active) ? 'checked' : ''); ?>>
                                <label for="is_active" class="form-check-label">Hiển thị sản phẩm</label>
                            </div>
                            <?php $__errorArgs = ['is_active'];
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
                            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Hủy
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật sản phẩm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Current Info & Gallery -->
        <div class="col-md-4">
            <!-- Product Stats -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Thống kê sản phẩm</h6>
                </div>
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="text-primary mb-1"><?php echo e($product->variants->count()); ?></h5>
                            <small class="text-muted">Biến thể</small>
                        </div>
                        <div class="col-6">
                            <h5 class="text-success mb-1"><?php echo e($product->total_quantity ?? 0); ?></h5>
                            <small class="text-muted">Tổng tồn kho</small>
                        </div>
                    </div>
                    <?php if($product->variants->count() > 0): ?>
                        <div class="mt-2">
                            <span class="badge bg-info"><?php echo e(number_format($product->min_price)); ?>đ - <?php echo e(number_format($product->max_price)); ?>đ</span>
                            <br><small class="text-muted">Khoảng giá</small>
                        </div>
                    <?php endif; ?>
                </div>
        </div>

            <!-- Gallery Management -->
            <?php if($product->galleries->count() > 0): ?>
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Gallery hiện tại (<?php echo e($product->galleries->count()); ?>)</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php $__currentLoopData = $product->galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-6 mb-3">
                                    <div class="position-relative">
                                        <img src="<?php echo e($gallery->image_path); ?>" alt="Gallery Image"
                                             class="img-fluid rounded"
                                             style="width: 100%; height: 80px; object-fit: cover;">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute delete-gallery-btn"
                                                style="top: 5px; right: 5px; font-size: 10px; padding: 2px 5px;"
                                                data-gallery-id="<?php echo e($gallery->id); ?>"
                                                data-product-id="<?php echo e($product->id); ?>">
                                            Xóa
                                        </button>
                                    </div>
                                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i>
                            Chọn "Xóa" trên ảnh để xóa khỏi gallery
                        </small>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        </div>

    <script>
        // Preview main image
        function previewImage() {
            const fileInput = document.getElementById('img_thumb');
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const currentImageContainer = document.getElementById('currentImageContainer');

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreviewContainer.style.display = 'block';
                    if (currentImageContainer) {
                        currentImageContainer.style.opacity = '0.5';
                    }
                };
                reader.readAsDataURL(fileInput.files[0]);
            } else {
                imagePreviewContainer.style.display = 'none';
                if (currentImageContainer) {
                    currentImageContainer.style.opacity = '1';
                }
            }
        }

        // Preview multiple gallery images
        document.getElementById('image-input').addEventListener('change', function(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('image-preview-container');

            previewContainer.innerHTML = '';

            if (files.length > 0) {
                const title = document.createElement('div');
                title.innerHTML = `<strong>Ảnh mới sẽ thêm (${files.length}):</strong>`;
                title.className = 'mb-2';
                previewContainer.appendChild(title);

                const imageContainer = document.createElement('div');
                imageContainer.className = 'row';

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-6 mb-2';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                        img.className = 'img-fluid rounded';
                        img.style.width = '100%';
                        img.style.height = '60px';
                        img.style.objectFit = 'cover';

                        col.appendChild(img);
                        imageContainer.appendChild(col);
                };

                reader.readAsDataURL(file);
                }

                previewContainer.appendChild(imageContainer);
            }
        });

        // Handle delete gallery image
        document.querySelectorAll('.delete-gallery-btn').forEach(button => {
            button.addEventListener('click', function() {
                const galleryId = this.dataset.galleryId;
                const productId = this.dataset.productId;

                if (confirm('Bạn có chắc chắn muốn xóa ảnh này không?')) {
                    fetch(`/products/${productId}/galleries/${galleryId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.closest('.col-6').remove(); // Remove the image from DOM
                            alert(data.message);
                        } else {
                            alert('Lỗi: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Đã xảy ra lỗi khi xóa ảnh.');
                    });
                }
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\datn-wd110-46\backend\resources\views/products/editproduct.blade.php ENDPATH**/ ?>