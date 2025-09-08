<?php $__env->startSection('title'); ?>
    Quản lý tài khoản
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

    <h1 class="text-center mt-5 mb-3">Danh sách Người dùng</h1>

    <!-- Menu lọc trạng thái -->
    <div class="mb-3">
        <a href="<?php echo e(route('managers.index')); ?>" class="btn btn-info">Tất cả trạng thái</a>
        <a href="<?php echo e(route('managers.index', ['is_active' => 'locked'])); ?>" class="btn btn-warning">Đã khóa</a>
        <a href="<?php echo e(route('managers.index', ['is_active' => 'normal'])); ?>" class="btn btn-success">Bình thường</a>
    </div>

    <div class="table-responsive mt-5">
        <table class="table table-bordered table-hover text-center">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Avatar</th>
                    <th>Họ Tên</th>
                    <th>Ngày Sinh</th>
                    <th>Số Điện Thoại</th>
                    <th>Địa Chỉ</th>
                    <th>Email</th>
                    <th>Vai Trò</th>
                    <th>is_active</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($user->id); ?></td>
                        <td><img src="<?php echo e(asset('storage/' . $user->avatar)); ?>" class="rounded-circle" width="50px" height="50px"></td>
                        <td><?php echo e($user->fullname); ?></td>
                        <td><?php echo e($user->birth_day); ?></td>
                        <td><?php echo e($user->phone); ?></td>
                        <td><?php echo e($user->address); ?></td>
                        <td><?php echo e($user->email); ?></td>
                        <td class="text-center">
                            <?php if($user->role === 0): ?>
                                <span class="badge badge-primary">User</span>
                            <?php elseif($user->role === 1): ?>
                                <span class="badge badge-info">Manager</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if($user->is_active): ?>
                                <span class="badge bg-success">YES</span>
                            <?php else: ?>
                                <span class="badge bg-danger">NO</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <form action="<?php echo e(route('managers.update', $user->id)); ?>" method="POST" style="display: inline;" novalidate>
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <?php if($user->is_active): ?>
                                    <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Bạn có chắc chắn muốn khóa tài khoản này?')">Khóa tài khoản </button>
                                <?php else: ?>
                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Bạn có chắc chắn muốn mở khóa tài khoản này?')">Mở khóa tài khoản </button>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php echo e($data->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\New folder (2)\backend\resources\views/managers/index.blade.php ENDPATH**/ ?>