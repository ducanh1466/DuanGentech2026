<!-- Header & Date Filter -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Tổng Quan Thống Kê</h4>
    <div class="d-flex align-items-center">
        <label for="date_filter" class="me-2 fw-semibold text-muted">Lọc theo:</label>
        <?php $currentFilter = $_GET['date_filter'] ?? 'all'; ?>
        <select id="date_filter" class="form-select form-select-sm" style="width: auto; min-width: 150px; border: 1px solid var(--border-color); background: var(--bg-primary); color: var(--text-primary);" onchange="window.location.href='?action=admin&date_filter='+this.value">
            <option value="today" <?= $currentFilter == 'today' ? 'selected' : '' ?>>Hôm nay</option>
            <option value="this_week" <?= $currentFilter == 'this_week' ? 'selected' : '' ?>>Tuần này</option>
            <option value="this_month" <?= $currentFilter == 'this_month' ? 'selected' : '' ?>>Tháng này</option>
            <option value="this_year" <?= $currentFilter == 'this_year' ? 'selected' : '' ?>>Năm nay</option>
            <option value="all" <?= $currentFilter == 'all' ? 'selected' : '' ?>>Từ trước đến nay</option>
        </select>
    </div>
</div>

<!-- Alerts / To-Do -->
<?php if (($alerts['pending_orders'] ?? 0) > 0 || ($alerts['pending_contacts'] ?? 0) > 0): ?>
<div class="alert alert-warning d-flex align-items-center p-3 mb-4 shadow-sm animate-fade-in-up" role="alert" style="border-left: 5px solid #f39c12; background-color: #fff9e6;">
    <i class="bi bi-bell-fill fs-3 text-warning me-3"></i>
    <div class="flex-grow-1">
        <h6 class="alert-heading mb-1 fw-bold text-dark">Việc cần làm hôm nay:</h6>
        <div class="mb-0 text-dark" style="font-size: 0.95rem;">
            <?php if (($alerts['pending_orders'] ?? 0) > 0): ?>
                - Có <strong><?= $alerts['pending_orders'] ?> đơn hàng mới</strong> đang chờ xác nhận. <a href="?action=admin-orders" class="alert-link text-primary text-decoration-underline">Xử lý ngay</a><br>
            <?php endif; ?>
            <?php if (($alerts['pending_contacts'] ?? 0) > 0): ?>
                - Có <strong><?= $alerts['pending_contacts'] ?> liên hệ mới</strong> từ khách hàng chưa được phản hồi. <a href="?action=admin-contacts" class="alert-link text-primary text-decoration-underline">Xem chi tiết</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Stat Cards -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3 animate-fade-in-up delay-100">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value"><?= number_format($totalOrders) ?></div>
                    <div class="stat-label">Tổng đơn hàng</div>
                </div>
                <div class="stat-icon bg-blue icon-pulse"><i class="bi bi-receipt"></i></div>
            </div>
            <?php $t = $trendOrders ?? 0; ?>
            <div class="stat-trend <?= $t >= 0 ? 'up' : 'down' ?>">
                <i class="bi bi-arrow-<?= $t >= 0 ? 'up' : 'down' ?>-short"></i> <?= $t > 0 ? '+' : '' ?><?= number_format($t, 1) ?>% <?= $trendText ?? '' ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 animate-fade-in-up delay-200">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">
                        <?php
                            if ($revenue >= 1000000000) {
                                echo number_format($revenue / 1000000000, 2, ',', '.') . ' Tỷ';
                            } else {
                                echo number_format($revenue / 1000000, 1, ',', '.') . ' Tr';
                            }
                        ?>
                    </div>
                    <div class="stat-label">Doanh thu</div>
                </div>
                <div class="stat-icon bg-green icon-pulse"><i class="bi bi-currency-dollar"></i></div>
            </div>
            <?php $t = $trendRevenue ?? 0; ?>
            <div class="stat-trend <?= $t >= 0 ? 'up' : 'down' ?>">
                <i class="bi bi-arrow-<?= $t >= 0 ? 'up' : 'down' ?>-short"></i> <?= $t > 0 ? '+' : '' ?><?= number_format($t, 1) ?>% <?= $trendText ?? '' ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 animate-fade-in-up delay-300">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value"><?= number_format($totalProducts) ?></div>
                    <div class="stat-label">Sản phẩm mới</div>
                </div>
                <div class="stat-icon bg-orange icon-pulse"><i class="bi bi-box-seam"></i></div>
            </div>
            <?php $t = $trendProducts ?? 0; ?>
            <div class="stat-trend <?= $t >= 0 ? 'up' : 'down' ?>">
                <i class="bi bi-arrow-<?= $t >= 0 ? 'up' : 'down' ?>-short"></i> <?= $t > 0 ? '+' : '' ?><?= number_format($t, 1) ?>% <?= $trendText ?? '' ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 animate-fade-in-up delay-400">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value"><?= number_format($totalUsers) ?></div>
                    <div class="stat-label">Người dùng mới</div>
                </div>
                <div class="stat-icon bg-red icon-pulse"><i class="bi bi-people"></i></div>
            </div>
            <?php $t = $trendUsers ?? 0; ?>
            <div class="stat-trend <?= $t >= 0 ? 'up' : 'down' ?>">
                <i class="bi bi-arrow-<?= $t >= 0 ? 'up' : 'down' ?>-short"></i> <?= $t > 0 ? '+' : '' ?><?= number_format($t, 1) ?>% <?= $trendText ?? '' ?>
            </div>
        </div>
    </div>
</div>

<!-- Chart + Recent Orders -->
<div class="row g-4 animate-fade-in-up delay-500">
    <!-- Chart -->
    <div class="col-lg-8">
        <div class="chart-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Đơn hàng theo tháng (<?= htmlspecialchars($selectedYear) ?>)</h6>
                <select class="form-select form-select-sm"
                    style="width:auto;border:1px solid var(--border-color);background:var(--bg-primary);color:var(--text-primary);"
                    onchange="window.location.href = '<?= BASE_URL ?>?action=admin&year=' + this.value">
                    <?php foreach ($availableYears as $year): ?>
                        <option value="<?= htmlspecialchars($year) ?>" <?= $year == $selectedYear ? 'selected' : '' ?>>
                            <?= htmlspecialchars($year) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="chart-container" style="position: relative; height:300px; width:100%">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="col-lg-4">
        <div class="admin-table-card h-100">
            <div class="card-header-custom">
                <h6>Đơn hàng gần đây</h6>
                <a href="<?= BASE_URL ?>?action=admin-orders" class="text-accent" style="font-size:0.85rem;">Xem tất
                    cả</a>
            </div>

            <div class="p-3">
                <?php if (empty($recentOrders)): ?>
                    <div class="text-center text-muted py-3">Chưa có đơn hàng nào</div>
                <?php else: ?>
                    <?php foreach ($recentOrders as $order): ?>
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom"
                            style="border-color:var(--border-light)!important">
                            <div>
                                <div class="fw-semibold" style="font-size:0.9rem;">#DH<?= $order['order_id'] ?></div>
                                <small class="text-muted"><?= htmlspecialchars($order['recipient_name']) ?></small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold" style="font-size:0.9rem;">
                                    <?= number_format($order['total_amount'], 0, ',', '.') ?>đ
                                </div>
                                <?php
                                $statusClass = '';
                                $statusText = '';
                                switch ($order['status']) {
                                    case 'pending':
                                        $statusClass = 'pending';
                                        $statusText = 'Chờ xử lý';
                                        break;
                                    case 'confirmed':
                                        $statusClass = 'confirmed';
                                        $statusText = 'Đã xác nhận';
                                        break;
                                    case 'shipping':
                                        $statusClass = 'shipping';
                                        $statusText = 'Đang giao';
                                        break;
                                    case 'completed':
                                        $statusClass = 'completed';
                                        $statusText = 'Hoàn thành';
                                        break;
                                    case 'cancelled':
                                        $statusClass = 'cancelled';
                                        $statusText = 'Đã hủy';
                                        break;
                                }
                                ?>
                                <span class="status-badge <?= $statusClass ?>"
                                    style="font-size:0.7rem;padding:2px 8px;"><?= $statusText ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Order Status Pie Chart + Top Selling + Low Stock -->
<div class="row g-4 mt-1 animate-fade-in-up delay-600">
    
    <!-- Top Selling Products -->
    <div class="col-lg-5">
        <div class="admin-table-card h-100">
            <div class="card-header-custom">
                <h6><i class="bi bi-star-fill text-warning me-2"></i>Top 5 Bán Chạy</h6>
            </div>
            <div class="p-3">
                <?php if (empty($topSellingProducts)): ?>
                    <div class="text-center text-muted py-3">Chưa có dữ liệu</div>
                <?php else: ?>
                    <?php foreach ($topSellingProducts as $item): ?>
                        <div class="d-flex align-items-center py-2 border-bottom" style="border-color:var(--border-light)!important">
                            <img src="<?= htmlspecialchars($item['image'] ?? 'assets/images/no-image.png') ?>" alt="" class="rounded border" style="width: 40px; height: 40px; object-fit: contain; background: #fff;">
                            <div class="ms-3 flex-grow-1">
                                <div class="fw-semibold text-truncate" style="font-size:0.9rem; max-width: 200px;" title="<?= htmlspecialchars($item['product_name']) ?>">
                                    <?= htmlspecialchars($item['product_name']) ?>
                                </div>
                            </div>
                            <div class="text-end ms-2">
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    Đã bán: <?= number_format($item['total_sold']) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Low Stock -->
    <div class="col-lg-4">
        <div class="admin-table-card h-100">
            <div class="card-header-custom">
                <h6><i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>Sắp Hết Hàng</h6>
            </div>
            <div class="p-3">
                <?php if (empty($lowStockProducts)): ?>
                    <div class="text-center text-muted py-3">Không có sản phẩm nào sắp hết</div>
                <?php else: ?>
                    <?php foreach ($lowStockProducts as $item): ?>
                        <div class="d-flex flex-column py-2 border-bottom" style="border-color:var(--border-light)!important">
                            <div class="fw-semibold text-truncate" style="font-size:0.9rem; max-width: 250px;" title="<?= htmlspecialchars($item['product_name']) ?>">
                                <?= htmlspecialchars($item['product_name']) ?>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <small class="text-muted"><?= htmlspecialchars($item['attributes'] ?? 'Mặc định') ?></small>
                                <span class="badge bg-danger">Còn: <?= number_format($item['stock']) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Order Status Chart -->
    <div class="col-lg-3">
        <div class="chart-card h-100">
            <div class="card-header-custom border-0 pb-0">
                <h6 class="mb-0">Trạng Thái Đơn</h6>
            </div>
            <div class="chart-container d-flex justify-content-center align-items-center" style="position: relative; height:250px; width:100%">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

</div>

<!-- Khách hàng VIP & Biểu đồ danh mục -->
<div class="row g-4 mb-4 mt-0">
    <!-- VIP Customers -->
    <div class="col-lg-7">
        <div class="admin-table-card h-100">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="bi bi-star-fill text-warning me-2"></i>Top Khách Hàng VIP</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Khách hàng</th>
                            <th class="text-center">Số đơn</th>
                            <th class="text-end">Tổng chi tiêu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($topVIPCustomers)): ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">Chưa có dữ liệu</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($topVIPCustomers as $vip): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center fw-bold" style="width: 35px; height: 35px; font-size: 1.1rem;">
                                            <?= mb_substr(htmlspecialchars($vip['full_name']), 0, 1, 'UTF-8') ?>
                                        </div>
                                        <div class="ms-3">
                                            <div class="fw-semibold text-dark" style="font-size: 0.95rem;"><?= htmlspecialchars($vip['full_name']) ?></div>
                                            <div class="text-muted" style="font-size: 0.85rem;"><?= htmlspecialchars($vip['email']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary"><?= number_format($vip['total_orders']) ?></span>
                                </td>
                                <td class="text-end fw-bold text-success">
                                    <?= number_format($vip['total_spent'], 0, ',', '.') ?>đ
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Category Sales Chart -->
    <div class="col-lg-5">
        <div class="chart-card h-100">
            <div class="card-header-custom border-0 pb-0">
                <h6 class="mb-0"><i class="bi bi-pie-chart-fill text-info me-2"></i>Doanh Thu Từng Danh Mục</h6>
            </div>
            <div class="chart-container d-flex justify-content-center align-items-center" style="position: relative; height:280px; width:100%; padding: 15px;">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const rawChartData = <?= $chartData ?>;

        // Tạo Gradient cho Background (Fill dưới biểu đồ)
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(67, 97, 238, 0.5)'); 
        gradient.addColorStop(1, 'rgba(67, 97, 238, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Th 1', 'Th 2', 'Th 3', 'Th 4', 'Th 5', 'Th 6', 'Th 7', 'Th 8', 'Th 9', 'Th 10', 'Th 11', 'Th 12'],
                datasets: [{
                    label: 'Doanh thu',
                    data: rawChartData.revenue || Array(12).fill(0),
                    borderColor: '#4361ee',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#4361ee',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: 5000000, // Gợi ý mốc tối đa là 5 triệu để tránh scale quá nhỏ khi dữ liệu = 0
                        grid: {
                            color: 'rgba(200, 200, 200, 0.1)',
                            borderDash: [5, 5]
                        },
                        ticks: {
                            callback: function (value, index, values) {
                                if (value === 0) return '0';
                                if (value >= 1000000000) {
                                    return (value / 1000000000).toLocaleString('vi-VN') + ' Tỷ';
                                }
                                return (value / 1000000).toLocaleString('vi-VN') + ' Tr';
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // ----------------- PIE CHART TRẠNG THÁI ĐƠN HÀNG -----------------
        const statusCtx = document.getElementById('statusChart');
        if (statusCtx) {
            const orderStatusData = <?= $orderStatusData ?? '[]' ?>;
            
            let pieLabels = [];
            let dataCounts = [];
            let backgroundColors = [];
            
            const statusMap = {
                'pending': { label: 'Chờ xử lý', color: '#f39c12' },
                'confirmed': { label: 'Đã xác nhận', color: '#3498db' },
                'shipping': { label: 'Đang giao', color: '#9b59b6' },
                'completed': { label: 'Hoàn thành', color: '#2ecc71' },
                'cancelled': { label: 'Đã hủy', color: '#e74c3c' },
                'unpaid': { label: 'Chưa T.Toán', color: '#7f8c8d' },
                'paid': { label: 'Đã T.Toán', color: '#1abc9c' }
            };

            orderStatusData.forEach(item => {
                let config = statusMap[item.status] || { label: item.status, color: '#95a5a6' };
                pieLabels.push(config.label);
                dataCounts.push(item.count);
                backgroundColors.push(config.color);
            });

            new Chart(statusCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: pieLabels,
                    datasets: [{
                        data: dataCounts,
                        backgroundColor: backgroundColors,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 12, font: {size: 11} }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const value = context.parsed;
                                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) + '%' : '0%';
                                        label += value + ' đơn (' + percentage + ')';
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }

        // ----------------- PIE CHART DOANH THU THEO DANH MỤC -----------------
        const catCtx = document.getElementById('categoryChart');
        if (catCtx) {
            const categoryData = <?= $salesByCategoryData ?? '[]' ?>;
            
            let catLabels = [];
            let catRevenues = [];
            
            // Generate some nice colors
            const palette = ['#4361ee', '#3a0ca3', '#7209b7', '#f72585', '#4cc9f0', '#2ecc71', '#f39c12', '#e74c3c'];
            let catColors = [];

            categoryData.forEach((item, index) => {
                catLabels.push(item.category_name);
                catRevenues.push(item.total_revenue);
                catColors.push(palette[index % palette.length]);
            });

            if (categoryData.length === 0) {
                // Dummy data if empty so chart doesn't break
                catLabels.push('Chưa có');
                catRevenues.push(1);
                catColors.push('#ecf0f1');
            }

            new Chart(catCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: catLabels,
                    datasets: [{
                        data: catRevenues,
                        backgroundColor: catColors,
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: { boxWidth: 12, font: {size: 12} }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let label = context.label || '';
                                    if (label) label += ': ';
                                    if (context.parsed !== null) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const value = context.parsed;
                                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) + '%' : '0%';
                                        label += new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
                                        label += ' (' + percentage + ')';
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>