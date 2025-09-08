<?php $__env->startSection('title'); ?>
    Thêm mới sản phẩm
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_admin'); ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <h1 class="text-center mt-5">Thêm mới sản phẩm</h1>
    <p class="text-center text-muted">Sau khi tạo sản phẩm, bạn sẽ có thể thêm các biến thể (variants) với giá và số lượng riêng biệt.</p>

    <form action="<?php echo e(route('products.store')); ?>" method="POST" enctype="multipart/form-data" novalidate>
        <?php echo csrf_field(); ?>

        <div class="mb-3">
            <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo e(old('name')); ?>" required>
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
            <label for="img_thumb" class="form-label">Ảnh đại diện <span class="text-danger">*</span></label>
            <input type="file" name="img_thumb" id="img_thumb" class="form-control" accept="image/*" required
                onchange="previewImage()">
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
        </div>

        <div id="imagePreviewContainer" style="display: none;">
            <label>Hình ảnh đã chọn:</label>
            <img id="imagePreview" src="" alt="Selected Image"
                style="width: 150px; height: 100px; margin-top: 10px;" class="rounded" />
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Chọn danh mục</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id') == $category->id ? 'selected' : ''); ?>>
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
            <textarea name="description" id="description" class="form-control" rows="5" placeholder="Mô tả sản phẩm..."><?php echo e(old('description')); ?></textarea>
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
            <label for="image_path" class="form-label">Ảnh chi tiết <span class="text-danger">*</span></label>
            <input type="file" id="image-input" class="form-control" name="image_path[]" multiple accept="image/*" required>
            <div id="image-preview-container" class="mt-2"></div>
            <p id="image-count" class="mt-1 text-muted">Bạn có thể chọn nhiều ảnh</p>
            <?php $__errorArgs = ['image_path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger mt-1"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <?php $__errorArgs = ['image_path.*'];
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
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
                       <?php echo e(old('is_active', true) ? 'checked' : ''); ?>>
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

        <div class="text-center mb-5 mt-4">
            <button type="submit" class="btn btn-primary btn-lg">Tạo sản phẩm</button>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary btn-lg ms-2">Quay lại</a>
        </div>
    </form>

    <script>
        // Preview main image
        function previewImage() {
            const fileInput = document.getElementById('img_thumb');
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreviewContainer.style.display = 'block';
                };
                reader.readAsDataURL(fileInput.files[0]);
            } else {
                imagePreviewContainer.style.display = 'none';
            }
        }

        // Preview multiple gallery images
        document.getElementById('image-input').addEventListener('change', function(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('image-preview-container');
        const imageCount = document.getElementById('image-count');

            previewContainer.innerHTML = '';

            if (files.length > 0) {
            imageCount.textContent = `Đã chọn ${files.length} ảnh`;

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                        img.style.width = '100px';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        img.style.margin = '5px';
                        img.className = 'rounded';
                        previewContainer.appendChild(img);
                };

                reader.readAsDataURL(file);
                }
            } else {
                imageCount.textContent = 'Bạn có thể chọn nhiều ảnh';
            }
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\New folder (2)\backend\resources\views/products/createproduct.blade.php ENDPATH**/ ?>