<form method="POST" action="">
    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
    <div class="row g-4">
    <!-- Order Info -->
    <div class="col-lg-4">
        <div class="order-info-card mb-4">
            <h6><i class="bi bi-info-circle me-2"></i>Thông tin đơn hàng</h6>
            <div class="info-row"><span class="label">Mã đơn</span><span class="value">#DH
                    <?= $order['order_id'] ?>
                </span></div>
            <div class="info-row"><span class="label">Ngày đặt</span><span class="value">
                    <?= date('d/m/Y H:i', strtotime($order['order_date'] ?? 'now')) ?>
                </span></div>
            <div class="info-row">
                <span class="label">Trạng thái</span>
                <?php
                $statusClass = 'pending';
                $statusText = 'Chờ xử lý';
                switch ($order['status']) {
                    case 'processing':
                        $statusClass = 'processing';
                        $statusText = 'Chờ lấy hàng';
                        break;
                    case 'confirmed':
                        $statusClass = 'completed';
                        $statusText = 'Đã xác nhận';
                        break;
                    case 'shipping':
                        $statusClass = 'shipping';
                        $statusText = 'Đang giao hàng';
                        break;
                    case 'completed':
                        $statusClass = 'completed';
                        $statusText = 'Hoàn thành';
                        break;
                    case 'cancelled':
                        $statusClass = 'cancelled';
                        $statusText = 'Hủy đơn';
                        break;
                }
                ?>
                <span class="status-badge <?= $statusClass ?>">
                    <?= $statusText ?>
                </span>
            </div>
            <div class="info-row"><span class="label">Thanh toán</span><span class="value">
                    <?php 
                    $payment = $order['payment_method'] ?? 'cod';
                    if ($payment === 'bank') echo 'Chuyển khoản';
                    elseif ($payment === 'vnpay') echo 'VNPay';
                    elseif ($payment === 'momo') echo 'MoMo';
                    elseif ($payment === 'zalopay') echo 'ZaloPay';
                    elseif ($payment === 'applepay') echo 'Apple Pay';
                    else echo 'COD';
                    ?>
                </span>
            </div>
        </div>

        <div class="order-info-card mb-4">
            <h6><i class="bi bi-person me-2"></i>Thông tin khách hàng</h6>
            <div class="info-row"><span class="label">Họ tên</span><span class="value">
                    <?= htmlspecialchars($order['recipient_name'] ?? '') ?>
                </span></div>
            <div class="info-row"><span class="label">SĐT</span><span class="value">
                    <?= htmlspecialchars($order['recipient_phone'] ?? '') ?>
                </span></div>
            <div class="info-row"><span class="label">Email</span><span class="value">
                    <?= htmlspecialchars($order['user_email'] ?? '') ?>
                </span></div>
        </div>

        <div class="order-info-card mb-4">
            <h6><i class="bi bi-geo-alt me-2"></i>Địa chỉ giao hàng</h6>
            <p class="mb-0" style="font-size:0.9rem;color:var(--text-secondary);">
                <?= htmlspecialchars($order['shipping_address'] ?? '') ?>
            </p>
            <?php if (!empty($order['note'])): ?>
                <hr>
                <h6 class="mt-2"><i class="bi bi-journal-text me-2"></i>Ghi chú</h6>
                <p class="mb-0 text-danger" style="font-size:0.9rem;">
                    <?= nl2br(htmlspecialchars($order['note'])) ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="order-info-card">
            <h6><i class="bi bi-arrow-repeat me-2"></i>Trạng thái đơn hàng</h6>
            <select class="form-select" name="status"
                style="border:2px solid var(--border-color);border-radius:var(--radius-md);padding:10px;background:var(--bg-primary);color:var(--text-primary);">
                <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
                <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Chờ lấy hàng</option>
                <option value="confirmed" <?= $order['status'] == 'confirmed' ? 'selected' : '' ?>>Đã xác nhận</option>
                <option value="shipping" <?= $order['status'] == 'shipping' ? 'selected' : '' ?>>Đang giao hàng
                </option>
                <option value="completed" <?= $order['status'] == 'completed' ? 'selected' : '' ?>>Hoàn thành</option>
                <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Hủy đơn</option>
            </select>
        </div>
    </div>

    <!-- Order Items -->
    <div class="col-lg-8">
        <div class="admin-table-card mb-4">
            <div class="card-header-custom">
                <h6>Sản phẩm trong đơn hàng</h6>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>SL</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderDetails as $item): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="<?= htmlspecialchars($item['product_image'] ?? 'https://placehold.co/50x50/4361ee/ffffff?text=IMG') ?>"
                                            class="product-thumb" alt="">
                                        <div>
                                            <div class="fw-semibold">
                                                <?= htmlspecialchars($item['product_name'] ?? 'Sản phẩm') ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?= number_format($item['unit_price'], 0, ',', '.') ?>₫
                                </td>
                                <td>
                                    <?= $item['quantity'] ?>
                                </td>
                                <td class="fw-bold">
                                    <?= number_format($item['unit_price'] * $item['quantity'], 0, ',', '.') ?>₫
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($orderDetails)): ?>
                            <tr>
                                <td colspan="4" class="text-center">Không có sản phẩm nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="order-info-card">
            <h6><i class="bi bi-calculator me-2"></i>Tổng kết đơn hàng</h6>
            <div class="info-row"><span class="label">Tạm tính</span><span class="value">
                    <?= number_format($order['total_amount'] ?? 0, 0, ',', '.') ?>₫
                </span></div>
            <div class="info-row"><span class="label">Phí vận chuyển</span><span class="value text-success">Miễn
                    phí</span></div>
            <div class="info-row"><span class="label">Giảm giá</span><span class="value">0₫</span></div>
            <hr>
            <div class="info-row" style="font-size:1.1rem;">
                <span class="label fw-bold">Tổng thanh toán</span>
                <span class="value fw-bold" style="color:var(--danger);">
                    <?= number_format($order['total_amount'] ?? 0, 0, ',', '.') ?>₫
                </span>
            </div>
        </div>

        </div>
    </div>
    
    <div class="form-actions mt-4">
        <a href="<?= BASE_URL ?>?action=admin-orders" class="btn-form-close text-decoration-none d-inline-flex align-items-center">
            <i class="bi bi-x-lg me-1"></i> Đóng
        </a>
        <button type="submit" class="btn-form-save d-inline-flex align-items-center">
            <i class="bi bi-save me-1"></i> Lưu trạng thái
        </button>
    </div>
</form>