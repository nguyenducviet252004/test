<?php $__env->startSection('title'); ?>
    Thêm mới phiếu giảm giá
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

    <h1 class="text-center mt-5">Thêm mới voucher</h1>

    <form method="POST" action="<?php echo e(route('vouchers.store')); ?>" enctype="multipart/form-data" class="container" novalidate>
        <?php echo csrf_field(); ?>

        <div class="mb-3">
            <label for="code" class="col-2 col-form-label">Mã giảm giá</label>

            <input type="text" class="form-control" name="code" id="code" value="<?php echo e(old('code')); ?>" required>
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
                id="discount_value" value="<?php echo e(old('discount_value')); ?>" required />
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
            <label for="total_min" class="col-2 col-form-label">Giá trị đơn hàng tối thiểu</label>

            <input type="text" placeholder="exam: 100.000 VND" class="form-control" name="total_min" id="discount_value"
                value="<?php echo e(old('total_min')); ?>" required />
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

            <input type="text" placeholder="exam: 100.000 VND" class="form-control" name="total_max" id="discount_value"
                value="<?php echo e(old('total_max')); ?>" required />
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

            <textarea class="form-control" name="description" id="description"s="5"><?php echo e(old('description')); ?></textarea>
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

            <input type="number" class="form-control" name="quantity" id="quantity" value="<?php echo e(old('quantity', 1)); ?>"
                required>
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
            <label for="used_times" class="col-2 col-form-label">Số lần sử dụng:</label>

            <input type="number" class="form-control" name="used_times" id="used_times" value="0" disabled>
            <input type="number" class="form-control" name="used_times" id="used_times" value="0" hidden>

        </div>

        <div class="mb-3">
            <label for="start_day" class="col-2 col-form-label">Ngày bắt đầu</label>

            <input type="date" class="form-control" name="start_day" id="start_day" value="<?php echo e(old('start_day')); ?>">
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

            <input type="date" class="form-control" name="end_day" id="end_day" value="<?php echo e(old('end_day')); ?>">
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

        <div class="mb-3">
            <label for="is_active" class="col-2 col-form-label">Trạng thái:</label>

            <select name="is_active" class="form-control mt-2" id="is_active" required>
                <option selected value="1">Đang hoạt động</option>
                <option value="0" >Không hoạt động</option>
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
                Tạo Voucher
            </button>
            <a href="<?php echo e(route('vouchers.index')); ?>" class="btn btn-outline-secondary">Quay lại</a>

        </div>
    </form>


    <script>
        // Hàm tạo mã ngẫu nhiên
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

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\datn-wd110-46\backend\resources\views/vouchers/create.blade.php ENDPATH**/ ?>