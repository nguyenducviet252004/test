<?php $__env->startSection('title'); ?>
    Danh sách Logo - Banner
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_admin'); ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success text-center">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php
        $bannerCount = \App\Models\LogoBanner::count();
    ?>

    <h1 class="text-center mt-5 mb-3">Danh sách Logo - Banner</h1>

    <a href="<?php echo e(route('logo_banners.create')); ?>"
        class="btn btn-primary mb-3 <?php if($bannerCount >= 5): ?> disabled <?php endif; ?>">
        <?php if($bannerCount >= 5): ?>
            Đã đủ 5 bản ghi
        <?php else: ?>
            Thêm mới
        <?php endif; ?>
    </a>

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Loại</th>
                <th>Tiêu đề</th>
                <th>Mô tả</th>
                <th>Hình ảnh</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $logoBanners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($banner->id); ?></td>
                    <td><?php echo e($banner->type == 1 ? 'Banner' : 'Logo'); ?></td>
                    <td><?php echo e($banner->title); ?></td>
                    <td><?php echo e($banner->description); ?></td>
                    <td>
                        <img src="<?php echo e(asset('storage/' . $banner->image)); ?>" alt="Image" style="width: 50px;">
                    </td>
                    <td> <span hidden class="badge <?php echo e($banner->is_active ? 'badge-success' : 'badge-danger'); ?>">
                            <?php echo e($banner->is_active ? 'Active' : 'Inactive'); ?>

                        </span></td>
                    <td>
                        <a href="<?php echo e(route('logo_banners.edit', $banner->id)); ?>" class="btn btn-warning btn-sm">Cập nhật</a>
                        <form action="<?php echo e(route('logo_banners.destroy', $banner->id)); ?>" method="POST" style="display:inline-block;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa logo/banner này không?');">Xóa</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center">Không có Logo/Banners.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\datn-wd110-46\backend\resources\views/logo_banners/index.blade.php ENDPATH**/ ?>