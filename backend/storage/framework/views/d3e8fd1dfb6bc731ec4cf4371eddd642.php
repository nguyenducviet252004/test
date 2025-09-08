<?php $__env->startSection('title'); ?>
    Danh sách màu sắc
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

    <h1 class="text-center mt-5 mb-3"> Danh sách màu sắc</h1>
    <a class="btn btn-outline-success mb-3" href="<?php echo e(route('colors.create')); ?>">Thêm mới</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên màu sắc</th>
                    <th scope="col">Sản phẩm liên quan</th> <!-- Thêm cột này để hiển thị số lượng sản phẩm -->
                    <th scope="col">Tạo</th>
                    <th scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($color->id); ?></td>
                        <td><?php echo e($color->name_color); ?></td>
    
                        <!-- Hiển thị số lượng sản phẩm liên quan -->
                        <td>
                            <?php echo e($color->product_count); ?> sản phẩm
                        </td>
    
                        <td><?php echo e($color->created_at ? $color->created_at->format('d/m/Y H:i') : 'N/A'); ?></td>
    
                        <td>
                            
                            <a class="btn btn-outline-warning mb-3" href="<?php echo e(route('colors.edit', $color->id)); ?>">Cập nhật</a>
                            <form action="<?php echo e(route('colors.destroy', $color->id)); ?>" method="POST" style="display:inline-block;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')" class="btn btn-outline-danger mb-3">
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

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\datn-wd110-46\backend\resources\views/bienthe/colors/index.blade.php ENDPATH**/ ?>