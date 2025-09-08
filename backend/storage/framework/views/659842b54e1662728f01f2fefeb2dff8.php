<?php $__env->startSection('title'); ?>
    Danh sách kích cỡ
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_admin'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success text-center">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <h1 class="text-center mt-5">Danh sách kích cỡ</h1>
    <a class="btn btn-outline-success mb-3 mt-3" href="<?php echo e(route('sizes.create')); ?>">Thêm mới</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kích cỡ</th>
                    <th>Sản phẩm liên quan</th> <!-- Thêm cột này để hiển thị số lượng sản phẩm -->
                    <th>Tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($size->id); ?></td>
                        <td><?php echo e($size->size); ?></td>

                        <!-- Hiển thị số lượng sản phẩm liên quan -->
                        <td>
                            <?php echo e($size->product_count); ?> sản phẩm
                        </td>

                        <td><?php echo e($size->created_at ? $size->created_at->format('d/m/Y H:i') : 'N/A'); ?></td>

                        <td>
                            
                            <a class="btn btn-outline-warning mb-3" href="<?php echo e(route('sizes.edit', $size->id)); ?>">Cập nhật</a>
                            <form action="<?php echo e(route('sizes.destroy', $size->id)); ?>" method="POST"
                                style="display:inline-block;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')"
                                    class="btn btn-outline-danger mb-3">
                                    Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php echo e($data->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\New folder (2)\backend\resources\views/bienthe/sizes/index.blade.php ENDPATH**/ ?>