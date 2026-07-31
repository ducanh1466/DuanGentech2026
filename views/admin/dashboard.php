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
            <div class="stat-trend up">
                <i class="bi bi-arrow-up-short"></i> +12.5% so với tháng trước
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 animate-fade-in-up delay-200">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value"><?= number_format($revenue / 1000000, 1, ',', '.') ?>Tr</div>
                    <div class="stat-label">Doanh thu</div>
                </div>
                <div class="stat-icon bg-green icon-pulse"><i class="bi bi-currency-dollar"></i></div>
            </div>
            <div class="stat-trend up">
                <i class="bi bi-arrow-up-short"></i> +8.2% so với tháng trước
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 animate-fade-in-up delay-300">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value"><?= number_format($totalProducts) ?></div>
                    <div class="stat-label">Sản phẩm</div>
                </div>
                <div class="stat-icon bg-orange icon-pulse"><i class="bi bi-box-seam"></i></div>
            </div>
            <div class="stat-trend down">
                <i class="bi bi-arrow-down-short"></i> -2.4% so với tháng trước
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
            <div class="stat-trend up">
                <i class="bi bi-arrow-up-short"></i> +15.3% so với tháng trước
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
                                return (value / 1000000).toLocaleString('vi-VN') + 'Tr'; // Display in millions
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
    });
</script>