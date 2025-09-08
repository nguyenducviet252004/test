<?php $__env->startSection('title'); ?>
    Thêm mới
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_admin'); ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <h1 class="text-center mt-5">Thêm mới Logo - Banner</h1>

    <form action="<?php echo e(isset($logoBanner) ? route('logo_banners.update', $logoBanner->id) : route('logo_banners.store')); ?>"
        method="POST" enctype="multipart/form-data" novalidate>
        <?php echo csrf_field(); ?>
        <?php if(isset($logoBanner)): ?>
            <?php echo method_field('PUT'); ?>
        <?php endif; ?>

        <div class="form-group">
            <label for="type">Loại</label>
            <select name="type" id="type" class="form-control" required>
                <option value="1" <?php echo e(isset($logoBanner) && $logoBanner->type == 1 ? 'selected' : ''); ?>>Banner</option>
                <option value="2" <?php echo e(isset($logoBanner) && $logoBanner->type == 2 ? 'selected' : ''); ?>>Logo</option>
            </select>
            <?php $__errorArgs = ['type'];
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

        <div class="form-group">
            <label for="title">Tiêu đề</label>
            <input type="text" name="title" id="title" class="form-control"
                value="<?php echo e($logoBanner->title ?? old('title')); ?>" required>
            <?php $__errorArgs = ['title'];
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

        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea name="description" id="description" class="form-control"><?php echo e($logoBanner->description ?? old('description')); ?></textarea>
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

        <div class="form-group">
            <label for="image">Hình ảnh</label>
            <input type="file" name="image" id="image" class="form-control"
                value="<?php echo e($logoBanner->image ?? old('image')); ?>" required>
            <?php $__errorArgs = ['image'];
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

        <div class="form-group" hidden>
            <label for="is_active">Trạng thái</label>
            <select name="is_active" id="is_active" class="form-control">
                <option value="1" <?php echo e(isset($logoBanner) && $logoBanner->is_active ? 'selected' : ''); ?>>Hoạt động
                </option>
                <option value="0" <?php echo e(isset($logoBanner) && !$logoBanner->is_active ? 'selected' : ''); ?>>Không hoạt động
                </option>
            </select>
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

        <button type="submit" class="btn btn-success"><?php echo e(isset($logoBanner) ? 'Cập nhật' : 'Thêm mới'); ?></button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\datn-wd110-46\backend\resources\views/logo_banners/create.blade.php ENDPATH**/ ?>