<?php $__env->startSection('title'); ?>
    Thêm mới danh mục
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_admin'); ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <h1 class="text-center mt-5">Thêm danh mục</h1>

    <form action="<?php echo e(route('categories.store')); ?>" method="POST" class="mt-3" novalidate>
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label for="name" class="form-label">Tên danh mục</label>
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

        <input type="text" name="is_active" id="name" class="form-control" value="1" hidden>

        <div class="text-center">
            <button type="submit" class="btn btn-success">Thêm mới</button>
            <a href="<?php echo e(route('categories.index')); ?>" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\datn-wd110-46\backend\resources\views/categories/create.blade.php ENDPATH**/ ?>