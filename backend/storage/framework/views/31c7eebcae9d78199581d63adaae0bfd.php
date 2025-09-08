<?php $__env->startSection('title'); ?>
    Quản lý đánh giá
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

    <h1 class="text-center mb-3 mt-5">Quản Lý Đánh Giá</h1>

    <div class="card">
        <div class="card-body">
            <?php if($reviews->isEmpty()): ?>
                <div class="alert alert-warning text-center">
                    Không có đánh giá nào!
                </div>
            <?php else: ?>
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Người dùng</th>
                            <th>Sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th>Đánh giá</th>
                            <th>Bình luận</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($review->id); ?></td>
                                <td><?php echo e($review->user->email ?? 'N/A'); ?></td> <!-- Hiển thị email của người dùng -->
                                <td><?php echo e($review->product->name ?? 'N/A'); ?></td>
                                <td>
                                    <?php if($review->image_path): ?>
                                        <img src="<?php echo e(asset('storage/' . $review->image_path)); ?>" alt="Review Image"
                                            class="img-thumbnail" width="80">
                                    <?php else: ?>
                                        Không có ảnh
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge badge-success"><?php echo e($review->rating); ?>/5</span>
                                </td>
                                <td><?php echo e($review->comment ?? 'Không có bình luận'); ?></td>
                                <td>
                                    <span class="badge <?php echo e($review->is_reviews ? 'badge-primary' : 'badge-secondary'); ?>">
                                        <?php echo e($review->is_reviews ? 'Hiển thị' : 'Ẩn'); ?>

                                    </span>
                                </td>
                                <td><?php echo e($review->created_at->format('d/m/Y H:i')); ?></td>
                                <td>
                                    <form method="POST" action="<?php echo e(route('review.update', $review->id)); ?>" novalidate>
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        
                                        <?php if($review->product_id !== null): ?> <!-- Kiểm tra xem product_id có phải là null hay không -->
                                            <button type="submit" 
                                                    class="btn <?php echo e($review->is_reviews ? 'btn-warning' : 'btn-success'); ?> btn-sm"
                                                    onclick="return confirm('Chắc chắn muốn thay đổi trạng thái')">
                                                <?php echo e($review->is_reviews ? 'Ẩn' : 'Hiển thị'); ?>

                                            </button>
                                        <?php else: ?>
                                            <!-- Nếu product_id là null, không cho phép thay đổi trạng thái -->
                                            <button type="button" class="btn btn-secondary btn-sm" disabled>
                                                Sản phẩm đã bị xóa khỏi hệ thống 
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                </td>
                                
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\New folder (2)\backend\resources\views/review/index.blade.php ENDPATH**/ ?>