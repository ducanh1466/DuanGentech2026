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
                        $statusClass = 'confirmed';
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
                    case 'return_requested':
                        $statusClass = 'return_requested';
                        $statusText = 'Yêu cầu trả hàng';
                        break;
                    case 'return_processing':
                        $statusClass = 'return_processing';
                        $statusText = 'Đang xử lý trả hàng';
                        break;
                    case 'returned':
                        $statusClass = 'returned';
                        $statusText = 'Đã hoàn trả';
                        break;
                    case 'return_rejected':
                        $statusClass = 'return_rejected';
                        $statusText = 'Từ chối trả hàng';
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
            <div class="info-row"><span class="label">TT Thanh toán</span>
                <?php if ($order['payment_status'] == 'paid'): ?>
                    <span class="badge bg-success">Đã thanh toán</span>
                <?php elseif ($order['payment_status'] == 'refunded'): ?>
                    <span class="badge bg-warning text-dark">Đã hoàn tiền</span>
                <?php else: ?>
                    <span class="badge bg-secondary">Chưa thanh toán</span>
                <?php endif; ?>
            </div>
            
            <?php if ($order['status'] == 'cancelled' && $order['payment_status'] == 'paid'): ?>
            <div class="mt-3 text-center">
                <button type="submit" name="action_type" value="refund" class="btn btn-warning btn-sm fw-bold w-100" onclick="return confirm('Xác nhận hoàn tiền cho đơn hàng này?');">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Hoàn tiền
                </button>
            </div>
            <?php endif; ?>
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
            <select class="form-select" name="status" id="orderStatusSelect" onchange="toggleCancelReason()"
                style="border:2px solid var(--border-color);border-radius:var(--radius-md);padding:10px;background:var(--bg-primary);color:var(--text-primary);">
                <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
                <option value="confirmed" <?= $order['status'] == 'confirmed' ? 'selected' : '' ?>>Đã xác nhận</option>
                <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Chờ lấy hàng</option>
                <option value="shipping" <?= $order['status'] == 'shipping' ? 'selected' : '' ?>>Đang giao hàng</option>
                <option value="completed" <?= $order['status'] == 'completed' ? 'selected' : '' ?>>Hoàn thành</option>
                <option value="return_requested" <?= $order['status'] == 'return_requested' ? 'selected' : '' ?>>Yêu cầu trả hàng</option>
                <option value="return_processing" <?= $order['status'] == 'return_processing' ? 'selected' : '' ?>>Đang xử lý trả hàng</option>
                <option value="returned" <?= $order['status'] == 'returned' ? 'selected' : '' ?>>Đã hoàn trả</option>
                <option value="return_rejected" <?= $order['status'] == 'return_rejected' ? 'selected' : '' ?>>Từ chối trả hàng</option>
                <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Hủy đơn</option>
            </select>
            
            <div id="cancelReasonDiv" style="display: <?= in_array($order['status'], ['cancelled', 'return_requested', 'return_processing', 'return_rejected', 'returned']) ? 'block' : 'none' ?>; margin-top: 15px;">
                <label class="form-label fw-semibold text-danger">Lý do hủy / Hoàn trả *</label>
                <textarea class="form-control" name="cancel_reason" id="cancelReason" rows="3" placeholder="Nhập lý do hủy/trả đơn/từ chối..."><?= htmlspecialchars($order['cancel_reason'] ?? '') ?></textarea>
            </div>
            
            <?php if (!empty($order['cancel_reason']) && in_array($order['status'], ['cancelled', 'return_requested', 'return_processing', 'return_rejected', 'returned'])): ?>
                <div class="mt-3 p-3 bg-warning bg-opacity-10 rounded border border-warning">
                    <div class="text-warning fw-bold mb-1"><i class="bi bi-exclamation-triangle"></i> Ghi chú / Lý do (từ Khách/Admin):</div>
                    <div class="text-dark"><?= nl2br(htmlspecialchars($order['cancel_reason'])) ?></div>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($order['cancel_images'])): 
                $images = json_decode($order['cancel_images'], true);
                if (is_array($images) && count($images) > 0):
            ?>
                <div class="mt-3 p-3 bg-light rounded border">
                    <div class="fw-bold mb-2"><i class="bi bi-images"></i> Ảnh minh chứng hoàn trả:</div>
                    <div class="d-flex gap-2 flex-wrap">
                        <?php foreach($images as $img): ?>
                            <a href="<?= BASE_URL . $img ?>" target="_blank">
                                <img src="<?= BASE_URL . $img ?>" alt="Minh chứng" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php 
                endif;
            endif; ?>
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

        <?php
        // Tính lại tiền hàng gốc (chưa giảm)
        $subtotal = 0;
        if (!empty($orderDetails)) {
            foreach ($orderDetails as $detail) {
                $subtotal += $detail['unit_price'] * $detail['quantity'];
            }
        }
        $shippingFee = $order['shipping_fee'] ?? 0;
        $discountAmount = $subtotal + $shippingFee - ($order['total_amount'] ?? 0);
        if ($discountAmount < 0) $discountAmount = 0;
        ?>
        <!-- Order Summary -->
        <div class="order-info-card">
            <h6><i class="bi bi-calculator me-2"></i>Tổng kết đơn hàng</h6>
            <div class="info-row"><span class="label">Tạm tính</span><span class="value">
                    <?= number_format($subtotal, 0, ',', '.') ?>₫
                </span></div>
            <div class="info-row">
                <span class="label">Phí vận chuyển</span>
                <?php if ($shippingFee > 0): ?>
                    <span class="value"><?= number_format($shippingFee, 0, ',', '.') ?>₫</span>
                <?php else: ?>
                    <span class="value text-success">Miễn phí</span>
                <?php endif; ?>
            </div>
            <div class="info-row">
                <span class="label">
                    Giảm giá 
                    <?php if (!empty($order['discount_code'])): ?>
                        <span class="badge bg-primary ms-1"><?= htmlspecialchars($order['discount_code']) ?></span>
                    <?php endif; ?>
                </span>
                <span class="value text-danger">
                    <?= $discountAmount > 0 ? '-' . number_format($discountAmount, 0, ',', '.') . '₫' : '0₫' ?>
                </span>
            </div>
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
        <button type="submit" class="btn-form-save d-inline-flex align-items-center" id="btnSaveStatus">
            <i class="bi bi-save me-1"></i> Lưu trạng thái
        </button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentStatus = '<?= $order['status'] ?>';
        let select = document.getElementById('orderStatusSelect');
        let options = select.options;
        
        let allowed = [];
        if (currentStatus === 'pending') allowed = ['pending', 'confirmed', 'cancelled'];
        else if (currentStatus === 'confirmed') allowed = ['confirmed', 'processing', 'cancelled'];
        else if (currentStatus === 'processing') allowed = ['processing', 'shipping', 'cancelled'];
        else if (currentStatus === 'shipping') allowed = ['shipping', 'completed', 'cancelled', 'returned'];
        else if (currentStatus === 'return_requested') allowed = ['return_requested', 'return_processing', 'return_rejected', 'returned'];
        else if (currentStatus === 'return_processing') allowed = ['return_processing', 'returned', 'return_rejected'];
        else allowed = [currentStatus]; // completed, cancelled, returned, return_rejected -> locked
        
        for (let i = 0; i < options.length; i++) {
            if (allowed.includes(options[i].value)) {
                options[i].disabled = false;
                options[i].style.display = 'block';
            } else {
                options[i].disabled = true;
                options[i].style.display = 'none';
            }
        }
        
        if (['completed', 'cancelled', 'returned', 'return_rejected'].includes(currentStatus)) {
            document.getElementById('btnSaveStatus').disabled = true;
            document.getElementById('cancelReason').disabled = true;
        }
    });
    
    function toggleCancelReason() {
        let status = document.getElementById('orderStatusSelect').value;
        let reasonDiv = document.getElementById('cancelReasonDiv');
        let reasonInput = document.getElementById('cancelReason');
        let currentStatus = '<?= $order['status'] ?>';
        
        let returnOrCancelStatuses = ['cancelled', 'return_requested', 'return_processing', 'return_rejected', 'returned'];
        
        if (returnOrCancelStatuses.includes(status) && !returnOrCancelStatuses.includes(currentStatus)) {
            reasonDiv.style.display = 'block';
            reasonInput.required = true;
        } else if (!returnOrCancelStatuses.includes(currentStatus)) {
            reasonDiv.style.display = 'none';
            reasonInput.required = false;
        }
    }
</script>