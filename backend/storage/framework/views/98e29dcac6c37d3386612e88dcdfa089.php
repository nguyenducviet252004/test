<?php $__env->startSection('title'); ?>
    Danh sách phiếu giảm giá
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

    <h1 class="text-center mt-5">Danh sách phiếu giảm giá</h1>

    <a class="btn btn-outline-success mb-3 mt-3" href="<?php echo e(route('vouchers.create')); ?>">Thêm mới voucher</a>

    <form method="GET" action="<?php echo e(route('vouchers.index')); ?>" id="filterForm" class="mb-3 p-3">
        <div class="row">
            <!-- Status Filter (Active/Inactive) -->
            <div class="col-md-2">
                <select name="status" id="status" class="form-select"
                    onchange="document.getElementById('filterForm').submit()">
                    <option value="" class="text-dark">Tất cả rạng thái</option>
                    <option value="1" class="text-dark" <?php echo e(request('status') == '1' ? 'selected' : ''); ?>>Đang hoạt động
                    </option>
                    <option value="0" class="text-dark" <?php echo e(request('status') == '0' ? 'selected' : ''); ?>>Không hoạt
                        động</option>
                </select>
            </div>

            <!-- Expiry Status Filter (Valid/Expired) -->
            <div class="col-md-2">
                <select name="expiry_status" id="expiry_status" class="form-select"
                    onchange="document.getElementById('filterForm').submit()">
                    <option value="" class="text-dark">Tất cả thời hạn</option>
                    <option value="valid" class="text-dark" <?php echo e(request('expiry_status') == 'valid' ? 'selected' : ''); ?>>Còn
                        hạn</option>
                    <option value="expired" class="text-dark" <?php echo e(request('expiry_status') == 'expired' ? 'selected' : ''); ?>>
                        Đã hết hạn</option>
                </select>
            </div>

            <!-- Sort Filter (Discount Value Asc/Desc) -->
            <div class="col-md-2">
                <select name="sort_by" id="sort_by" class="form-select"
                    onchange="document.getElementById('filterForm').submit()">
                    <option value="" class="text-dark">Giá mặc định</option>
                    <option value="asc" class="text-dark" <?php echo e(request('sort_by') == 'asc' ? 'selected' : ''); ?>>Giảm dần
                    </option>
                    <option value="desc" class="text-dark" <?php echo e(request('sort_by') == 'desc' ? 'selected' : ''); ?>>Tăng dần
                    </option>
                </select>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Mã giảm giá</th>
                    <th scope="col">Giá trị</th>
                    <th scope="col">Đơn đạt tối thiểu</th>
                    <th scope="col">Đơn đạt tối đa</th>
                    <th scope="col">Mô tả</th>
                    <th scope="col">Bắt đầu</th>
                    <th scope="col">Kết thúc</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $voucher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($voucher->id); ?></td>
                        <td><?php echo e($voucher->code); ?></td>
                        <td><?php echo e($voucher->discount_value ?? 'N/A'); ?> VND</td>
                        <td><?php echo e($voucher->total_min ?? 'N/A'); ?> VND</td>
                        <td><?php echo e($voucher->total_max ?? 'N/A'); ?> VND</td>
                        <td><?php echo e($voucher->description ?? 'N/A'); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($voucher->start_day)->format('d-m-Y')); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($voucher->end_day)->format('d-m-Y')); ?></td>
                        <td>
                            <?php if($voucher->is_active): ?>
                                <span class="badge bg-success">Hoạt động</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Không hoạt động</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <a class="btn btn-outline-warning mb-3" href="<?php echo e(route('vouchers.edit', $voucher->id)); ?>">
                                Cập nhật</a>
                            <a onclick="return confirm('Bạn có chắc muốn cập nhật trạng thái?')"
                                href="<?php echo e(route('vouchers.index', ['toggle_active' => $voucher->id])); ?>"
                                class="btn <?php echo e($voucher->is_active ? 'btn-outline-secondary' : 'btn-outline-success'); ?> mb-3">
                                <?php echo e($voucher->is_active ? 'Ẩn' : 'Hiện'); ?>

                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        
        <div class="pagination justify-content-center">
            <?php echo e($vouchers->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\New folder (2)\backend\resources\views/vouchers/index.blade.php ENDPATH**/ ?>