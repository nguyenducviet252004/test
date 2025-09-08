<?php $__env->startSection('title'); ?>
    Trang chủ
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_admin'); ?>
    <div class="container text-center mt-5 mb-3">
        <h2>Trang chủ quản trị viên</h2>
    </div>

    <!-- Form chọn khoảng thời gian -->
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="mdi mdi-calendar-clock"></i>
                    Chọn khoảng thời gian thống kê
                </h5>
            </div>
            <div class="card-body">
                <form id="time-filter-form" method="GET" action="<?php echo e(route('admin.dashboard')); ?>" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label fw-bold">
                            <i class="mdi mdi-calendar-start"></i> Từ ngày:
                        </label>
                        <input type="date" id="start_date" name="start_date" class="form-control" 
                               value="<?php echo e($startDate ? $startDate->format('Y-m-d') : ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label fw-bold">
                            <i class="mdi mdi-calendar-end"></i> Đến ngày:
                        </label>
                        <input type="date" id="end_date" name="end_date" class="form-control" 
                               value="<?php echo e($endDate ? $endDate->format('Y-m-d') : ''); ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="mdi mdi-filter"></i> Lọc dữ liệu
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary w-100">
                            <i class="mdi mdi-refresh"></i> Làm mới
                        </a>
                    </div>
                </form>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="alert alert-info mb-0">
                            <i class="mdi mdi-information"></i>
                            <strong>Hướng dẫn:</strong> Chọn khoảng thời gian cụ thể để xem thống kê chi tiết. Dữ liệu sẽ được cập nhật tự động khi chuyển tab.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Thông tin thời gian đã chọn -->
    <div class="container mt-3">
        <div class="alert alert-info">
            <i class="mdi mdi-calendar-clock"></i>
            <strong>Khoảng thời gian đã chọn:</strong>
            <?php if(isset($formattedStartDate) && isset($formattedEndDate)): ?>
                Từ <?php echo e($formattedStartDate); ?> đến <?php echo e($formattedEndDate); ?>

            <?php else: ?>
                Tháng <?php echo e(now()->format('m/Y')); ?>

            <?php endif; ?>
        </div>
    </div>

    <!-- Thống kê tổng quan -->
    <div class="dashboard-stats mt-4">
        <div class="stat-item">
            <h2>Tổng Doanh Thu</h2>
            <p class="stat-value"><?php echo e(number_format($totalRevenue, 0, ',', '.')); ?> VND</p>
            <?php if(isset($revenueChange)): ?>
                <div class="stat-change <?php echo e($revenueChange >= 0 ? 'positive' : 'negative'); ?>">
                    <i class="mdi mdi-<?php echo e($revenueChange >= 0 ? 'trending-up' : 'trending-down'); ?>"></i>
                    <?php echo e(number_format(abs($revenueChange), 1)); ?>%
                </div>
            <?php endif; ?>
            <small class="text-muted">
                <?php if(isset($formattedStartDate) && isset($formattedEndDate)): ?>
                    <?php echo e($formattedStartDate); ?> - <?php echo e($formattedEndDate); ?>

                <?php else: ?>
                    Tháng <?php echo e(now()->format('m/Y')); ?>

                <?php endif; ?>
            </small>
        </div>
        <div class="stat-item">
            <h2>Tổng Thành Viên</h2>
            <p class="stat-value"><?php echo e($totalUsers); ?> Thành viên</p>
            <small class="text-muted">Tất cả thời gian</small>
        </div>
        <div class="stat-item">
            <h2>Đã Hoàn Thành</h2>
            <p class="stat-value"><?php echo e($completedOrders); ?> Đơn hàng</p>
            <?php if(isset($ordersChange)): ?>
                <div class="stat-change <?php echo e($ordersChange >= 0 ? 'positive' : 'negative'); ?>">
                    <i class="mdi mdi-<?php echo e($ordersChange >= 0 ? 'trending-up' : 'trending-down'); ?>"></i>
                    <?php echo e(number_format(abs($ordersChange), 1)); ?>%
                </div>
            <?php endif; ?>
            <small class="text-muted">
                <?php if(isset($formattedStartDate) && isset($formattedEndDate)): ?>
                    <?php echo e($formattedStartDate); ?> - <?php echo e($formattedEndDate); ?>

                <?php else: ?>
                    Tháng <?php echo e(now()->format('m/Y')); ?>

                <?php endif; ?>
            </small>
        </div>
        <div class="stat-item">
            <h2>Chưa Xử Lí </h2>
            <p class="stat-value"><?php echo e($pendingOrders); ?> Đơn hàng</p>
            <a class="btn btn-success mt-2" href="<?php echo e(route('orders.index')); ?>">
                <i class="mdi mdi-clipboard-check"></i> Xử lí ngay
            </a>
            <small class="text-muted">Tất cả thời gian</small>
        </div>
    </div>

    <!-- Menu -->
    <div class="container mt-4">
        <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="account-tab" data-bs-toggle="tab" data-bs-target="#account"
                    type="button" role="tab">
                    Tài khoản
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button"
                    role="tab">
                    Doanh thu - Dơn hàng
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="top-products-tab" data-bs-toggle="tab" data-bs-target="#top-products"
                    type="button" role="tab">
                    Sản phẩm bán chạy
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tonkho-tab" data-bs-toggle="tab" data-bs-target="#tonkho" type="button"
                    role="tab">
                    Tồn kho - Sắp hết
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="voucher-tab" data-bs-toggle="tab" data-bs-target="#voucher" type="button"
                    role="tab">
                    Voucher
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tiledon-tab" data-bs-toggle="tab" data-bs-target="#tiledon" type="button"
                    role="tab">
                    Tỉ lệ đơn
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="khachhang-tab" data-bs-toggle="tab" data-bs-target="#khachhang" type="button"
                    role="tab">
                    Khách hàng
                </button>
            </li>
        </ul>



        <!-- Nội dung của từng tab -->
        <div class="tab-content mt-4">
            <div class="tab-pane fade show active" id="account" role="tabpanel">
                <div id="account-content" data-url="<?php echo e(route('thongke.account')); ?>"></div>
            </div>
            <div class="tab-pane fade" id="orders" role="tabpanel">
                <div id="orders-content" data-url="<?php echo e(route('thongke.orders')); ?>"></div>
            </div>
            <div class="tab-pane fade" id="top-products" role="tabpanel">
                <div id="top-products-content" data-url="<?php echo e(route('thongke.topproduct')); ?>"></div>
            </div>
            <div class="tab-pane fade" id="tonkho" role="tabpanel">
                <div id="tonkho-content" data-url="<?php echo e(route('thongke.tonkho')); ?>"></div>
            </div>
            <div class="tab-pane fade" id="voucher" role="tabpanel">
                <div id="voucher-content" data-url="<?php echo e(route('thongke.voucher')); ?>"></div>
            </div>
            <div class="tab-pane fade" id="tiledon" role="tabpanel">
                <div id="tiledon-content" data-url="<?php echo e(route('thongke.tiledon')); ?>"></div>
            </div>
            <div class="tab-pane fade" id="khachhang" role="tabpanel">
                <div id="khachhang-content" data-url="<?php echo e(route('thongke.khachhang')); ?>"></div>
            </div>
        </div>
    </div>

    <style>
        .dashboard-stats {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .stat-item {
            flex: 1;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .stat-item h2 {
            margin-bottom: 10px;
            font-size: 18px;
            color: #333;
        }

        .stat-value {
            font-size: 24px;
            color: #555;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-change {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-change.positive {
            color: #28a745;
        }

        .stat-change.negative {
            color: #dc3545;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
            padding: 15px 20px;
        }

        .card-body {
            padding: 20px;
        }

        .text-muted {
            font-size: 12px;
        }
    </style>

    <script>
        // Hàm tải dữ liệu qua AJAX
        function loadTabContent(tabId, url) {
            const contentDiv = document.getElementById(`${tabId}-content`);
            if (!contentDiv || !url) return;

            // Lấy giá trị từ form chính
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            
            const params = new URLSearchParams();
            
            // Chỉ sử dụng ngày cụ thể
            if (startDateInput && startDateInput.value && endDateInput && endDateInput.value) {
                params.append('start_date', startDateInput.value);
                params.append('end_date', endDateInput.value);
            }

            contentDiv.innerHTML = '<div class="text-center">Đang tải dữ liệu...</div>';

            fetch(`${url}?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                })
                .then(response => response.text())
                .then(data => {
                    contentDiv.innerHTML = data;
                })
                .catch(error => {
                    contentDiv.innerHTML = '<div class="text-danger">Không thể tải dữ liệu. Vui lòng thử lại.</div>';
                    console.error('Error loading tab content:', error);
                });
        }

        // Lắng nghe sự kiện tab thay đổi
        document.querySelectorAll('.nav-link').forEach(tab => {
            tab.addEventListener('shown.bs.tab', function(event) {
                const tabId = event.target.dataset.bsTarget.replace('#', '');
                const url = document.getElementById(`${tabId}-content`).dataset.url;
                loadTabContent(tabId, url);
            });
        });

        // Tải dữ liệu của tab đầu tiên khi load trang
        document.addEventListener('DOMContentLoaded', () => {
            const activeTab = document.querySelector('.nav-link.active');
            const tabId = activeTab.dataset.bsTarget.replace('#', '');
            const url = document.getElementById(`${tabId}-content`).dataset.url;
            loadTabContent(tabId, url);

            // Tự động cập nhật tab khi form chính thay đổi
            document.getElementById('start_date')?.addEventListener('change', function() {
                const activeTab = document.querySelector('.nav-link.active');
                const tabId = activeTab.dataset.bsTarget.replace('#', '');
                const url = document.getElementById(`${tabId}-content`).dataset.url;
                loadTabContent(tabId, url);
            });

            document.getElementById('end_date')?.addEventListener('change', function() {
                const activeTab = document.querySelector('.nav-link.active');
                const tabId = activeTab.dataset.bsTarget.replace('#', '');
                const url = document.getElementById(`${tabId}-content`).dataset.url;
                loadTabContent(tabId, url);
            });
        });




    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\datn-wd110-46\backend\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>