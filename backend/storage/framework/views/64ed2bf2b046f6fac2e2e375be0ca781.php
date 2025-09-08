<?php $__env->startSection('title'); ?>
    Cập nhật phiếu giảm giá
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

    <h1 class="text-center mt-5">Cập nhật voucher</h1>

    <form method="POST" action="<?php echo e(route('vouchers.update', $voucher->id)); ?>" enctype="multipart/form-data" class="container" novalidate>
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label for="code" class="col-2 col-form-label">Mã giảm giá</label>
            <input type="text" class="form-control" name="code" id="code"
                value="<?php echo e(old('code', $voucher->code)); ?>" required>
            <button type="button" class="btn btn-secondary mt-2" style="width: 300px" id="generateCodeBtn">Tạo mã ngẫu
                nhiên</button>
            <?php $__errorArgs = ['code'];
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
            <label for="discount_value" class="col-2 col-form-label">Giá trị giảm giá</label>
            <input type="text" placeholder="exam: 100.000 VND" class="form-control" name="discount_value"
                id="discount_value" value="<?php echo e(old('discount_value', $voucher->discount_value)); ?>" required />
            <?php $__errorArgs = ['discount_value'];
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
            <label for="total_min" class="col-2 col-form-label">Giá trị đơn hàng đạt tối thiểu</label>
            <input type="text" placeholder="exam: 100.000 VND" class="form-control" name="total_min" id="total_min"
                value="<?php echo e(old('total_min', $voucher->total_min)); ?>" required />
            <?php $__errorArgs = ['total_min'];
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
            <label for="total_max" class="col-2 col-form-label">Giá trị đơn hàng đạt tối đa</label>
            <input type="text" placeholder="exam: 100.000 VND" class="form-control" name="total_max" id="total_max"
                value="<?php echo e(old('total_max', $voucher->total_max)); ?>" required />
            <?php $__errorArgs = ['total_max'];
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
            <label for="description" class="col-2 col-form-label">Mô tả</label>
            <textarea class="form-control" name="description" id="description"><?php echo e(old('description', $voucher->description)); ?></textarea>
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
            <label for="quantity" class="col-2 col-form-label">Số lượng</label>
            <input type="number" class="form-control" name="quantity" id="quantity"
                value="<?php echo e(old('quantity', $voucher->quantity)); ?>" required>
            <?php $__errorArgs = ['quantity'];
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
            <input type="date" class="form-control" name="start_day" id="start_day" hidden
                value="<?php echo e(old('start_day', \Carbon\Carbon::parse($voucher->start_day)->format('Y-m-d'))); ?>">
            <?php $__errorArgs = ['start_day'];
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
            <label for="end_day" class="col-2 col-form-label">Ngày kết thúc</label>
            <input type="date" class="form-control" name="end_day" id="end_day"
                value="<?php echo e(old('end_day', \Carbon\Carbon::parse($voucher->end_day)->format('Y-m-d'))); ?>">
            <?php $__errorArgs = ['end_day'];
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

        <?php if(old('end_day') &&
                old('start_day') &&
                \Carbon\Carbon::parse(old('end_day'))->lt(\Carbon\Carbon::parse(old('start_day')))): ?>
            <div class="alert alert-danger">
                Ngày kết thúc không được nhỏ hơn ngày bắt đầu.
            </div>
        <?php endif; ?>



        <div class="mb-3">
            <label for="is_active" class="col-2 col-form-label">Trạng thái:</label>
            <select name="is_active" class="form-control mt-2" id="is_active" required>
                <option value="1" <?php echo e(old('is_active', $voucher->is_active) == 1 ? 'selected' : ''); ?>>Đang hoạt động
                </option>
                <option value="0" <?php echo e(old('is_active', $voucher->is_active) == 0 ? 'selected' : ''); ?>>Không hoạt động
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

        <div class="mt-3 mb-3 text-center">
            <button type="submit" class="btn btn-outline-success">
                Cập nhật Voucher
            </button>
            <a href="<?php echo e(route('vouchers.index')); ?>" class="btn btn-outline-secondary">Quay lại</a>
        </div>
    </form>

    <script>
        document.getElementById('generateCodeBtn').addEventListener('click', function() {
            const codeLength = 5;
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let randomCode = '';

            for (let i = 0; i < codeLength; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                randomCode += characters.charAt(randomIndex);
            }

            document.getElementById('code').value = randomCode;
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\New folder (2)\backend\resources\views/vouchers/edit.blade.php ENDPATH**/ ?>