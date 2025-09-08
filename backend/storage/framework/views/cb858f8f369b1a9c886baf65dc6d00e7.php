<?php $__env->startSection('title'); ?>
    Danh sách danh mục
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

    <h1 class="text-center mt-5">Danh sách danh mục</h1>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-outline-success mb-3">Thêm mới</a>
    </div>

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th scope="col">Số lượng sản phẩm</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Tạo</th>
                <th scope="col">Sửa</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($category->id); ?></td>
                    <td><?php echo e($category->name); ?></td>
                    <td><?php echo e($category->products()->count()); ?></td>
                    <td>
                        <?php if($category->is_active): ?>
                            <span class="badge bg-success">Hoạt động</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Không hoạt động</span>
                        <?php endif; ?>
                    </td>

                    <td><?php echo e($category->created_at ? $category->created_at->format('d/m/Y H:i') : 'N/A'); ?></td>
                    <td><?php echo e($category->updated_at ? $category->updated_at->format('d/m/Y H:i') : 'N/A'); ?></td>
                    <td>
                        <a onclick="return confirm('Bạn có chắc muốn cập nhật trạng thái?')"
                            href="<?php echo e(route('categories.index', ['toggle_active' => $category->id])); ?>"
                            class="btn <?php echo e($category->is_active ? 'btn-outline-secondary' : 'btn-outline-success'); ?> mb-3">
                            <?php echo e($category->is_active ? 'Ẩn' : 'Hiện'); ?>

                        </a>
                        <a href="<?php echo e(route('categories.edit', $category->id)); ?>" class="btn btn-outline-warning mb-3">Cập
                            nhật</a>
                        <form action="<?php echo e(route('categories.destroy', $category->id)); ?>" method="POST"
                            style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-outline-danger mb-3"
                                onclick="return confirm('Bạn có chắc muốn xóa không?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        <?php echo e($categories->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\New folder (2)\backend\resources\views/categories/index.blade.php ENDPATH**/ ?>