<?php $__env->startSection('title'); ?>
    Trang chủ
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_admin'); ?>
    <div class="container text-center mt-5 mb-3">
        <h2>Trang chủ quản trị viên</h2>
    </div>
    <div class="dashboard-stats mt-3">
        <div class="stat-item">
            <h2>Tổng Doanh Thu</h2>
            <p><?php echo e(number_format($totalRevenue, 0, ',', '.')); ?> VND</p>
        </div>
        <div class="stat-item">
            <h2>Tổng Thành Viên</h2>
            <p><?php echo e($totalUsers); ?> Thành viên</p>
        </div>
        <div class="stat-item">
            <h2>Đã Hoàn Thành</h2>
            <p><?php echo e($completedOrders); ?> Đơn hàng</p>
        </div>
        <div class="stat-item">
            <h2>Chưa Xử Lí </h2>
            <p><?php echo e($pendingOrders); ?> Đơn hàng</p>
            <a class="btn btn-success" href="<?php echo e(route('orders.index')); ?>">Xử lí ngay</a>
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

        <div class="mt-5 mb-5">
            <form id="filter-stats-form" action="" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="year" class="form-label fw-bold">Năm:</label>
                    <select id="year" name="year" class="form-control">
                        <?php
                            $currentYear = now()->year;
                            $selectedYear = request('year', $currentYear);
                        ?>
                        <?php for($y = $currentYear; $y >= $currentYear - 4; $y--): ?>
                            <option value="<?php echo e($y); ?>" <?php if($selectedYear == $y): ?> selected <?php endif; ?>><?php echo e($y); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="month" class="form-label fw-bold">Tháng:</label>
                    <select id="month" name="month" class="form-control">
                        <option value="all" <?php if(request('month','all')=='all'): ?> selected <?php endif; ?>>Tất cả</option>
                        <?php for($m = 1; $m <= 12; $m++): ?>
                            <option value="<?php echo e($m); ?>" <?php if(request('month')==$m): ?> selected <?php endif; ?>>Tháng <?php echo e($m); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-3 align-self-end">
                    <button type="submit" class="btn btn-primary">Lọc</button>
                </div>
                <!-- Input ẩn để lưu URL hiện tại -->
                <input type="hidden" id="current-url" name="current_url" value="">
            </form>
        </div>

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
        }

        .stat-item h2 {
            margin-bottom: 10px;
            font-size: 20px;
            color: #333;
        }

        .stat-item p {
            font-size: 18px;
            color: #555;
            font-weight: bold;
        }
    </style>

    <script>
        // Hàm tải dữ liệu qua AJAX
        function loadTabContent(tabId, url) {
            const contentDiv = document.getElementById(`${tabId}-content`);
            if (!contentDiv || !url) return;

            // Lấy giá trị tháng từ input
            const monthInput = document.getElementById('month');
            let month = monthInput ? monthInput.value : (new Date()).toISOString().slice(0,7);

            // Gửi request với tham số month
            const params = new URLSearchParams({
                month: month
            });

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
        });

        // Cập nhật giá trị `current_url` khi tải trang ban đầu
        document.addEventListener('DOMContentLoaded', () => {
            updateCurrentUrl();

            document.querySelectorAll('.nav-link').forEach(tab => {
                tab.addEventListener('shown.bs.tab', function(event) {
                    updateCurrentUrl();
                });
            });

            function updateCurrentUrl() {
                const activeTab = document.querySelector('.nav-link.active');
                const tabId = activeTab.dataset.bsTarget.replace('#', '');
                const url = document.getElementById(`${tabId}-content`).dataset.url;
                document.getElementById('current-url').value = url;
            }

            const startDateInput = document.getElementById('start-date');
            const endDateInput = document.getElementById('end-date');

            const firstDayOfMonth = new Date();
            firstDayOfMonth.setDate(1);
            const formattedStartDate = firstDayOfMonth.toISOString().split('T')[0];

            const today = new Date();
            const formattedEndDate = today.toISOString().split('T')[0];

            startDateInput.value = formattedStartDate;
            endDateInput.value = formattedEndDate;
        });

        // Lọc dữ liệu khi submit form
        document.getElementById('filter-stats-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const url = document.getElementById('current-url').value;
            const month = document.getElementById('month').value;
            fetch(url + '?month=' + month, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(response => response.text())
            .then(data => {
                const activeTab = document.querySelector('.nav-link.active');
                const tabId = activeTab.dataset.bsTarget.replace('#', '');
                const contentDiv = document.getElementById(`${tabId}-content`);
                contentDiv.innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layout.Layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\datn-wd110-46\backend\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>