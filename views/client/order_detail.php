<style>
    /* Premium White Theme UI for Order Detail */
    body {
        background-color: #f8f9fa;
    }
    
    .premium-page-header {
        background: linear-gradient(135deg, #ffffff 0%, #f1f3f5 100%);
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 1rem 0;
    }

    .premium-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 5px 20px rgba(0,0,0,0.03);
        overflow: hidden;
    }

    .info-card {
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid rgba(0,0,0,0.03);
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        background: #ffffff;
        box-shadow: 0 8px 25px rgba(0,0,0,0.04);
        transform: translateY(-3px);
    }

    .info-icon-wrapper {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    /* Modern Timeline */
    .premium-timeline {
        position: relative;
        display: flex;
        justify-content: space-between;
        margin: 1rem 0;
    }
    
    .premium-timeline::before {
        content: '';
        position: absolute;
        top: 14px;
        left: 0;
        right: 0;
        height: 2px;
        background: #e9ecef;
        z-index: 1;
        border-radius: 2px;
    }

    .premium-timeline-step {
        position: relative;
        z-index: 2;
        text-align: center;
        flex: 1;
    }

    .premium-timeline-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #ffffff;
        border: 2px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 6px auto;
        color: #adb5bd;
        font-size: 0.8rem;
        transition: all 0.4s ease;
        box-shadow: 0 0 0 2px #ffffff;
    }

    .premium-timeline-step.active .premium-timeline-icon {
        background: #212529;
        border-color: #212529;
        color: #ffffff;
        box-shadow: 0 0 0 4px rgba(33, 37, 41, 0.1);
        animation: pulseIcon 2s infinite;
    }
    
    @keyframes pulseIcon {
        0% { box-shadow: 0 0 0 0 rgba(33, 37, 41, 0.2); }
        70% { box-shadow: 0 0 0 10px rgba(33, 37, 41, 0); }
        100% { box-shadow: 0 0 0 0 rgba(33, 37, 41, 0); }
    }

    .premium-timeline-step.active::after {
        content: '';
        position: absolute;
        top: 14px;
        left: 50%;
        width: 100%;
        height: 2px;
        background: #212529;
        z-index: -1;
    }
    .premium-timeline-step:last-child::after {
        display: none;
    }

    .premium-timeline-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .premium-timeline-step.active .premium-timeline-label {
        color: #212529;
    }

    /* Table Styles */
    .premium-table th {
        background-color: transparent;
        color: #6c757d;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 2px solid #f1f3f5;
        padding-bottom: 1rem;
    }
    .premium-table td {
        vertical-align: middle;
        border-bottom: 1px solid #f8f9fa;
        padding: 0.75rem 0;
    }
    .premium-table tr:last-child td {
        border-bottom: none;
    }

    .product-img-wrapper {
        width: 48px;
        height: 48px;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 0.5rem;
        border: 1px solid rgba(0,0,0,0.02);
    }
</style>

<div class="premium-page-header">
    <div class="container text-center">
        <h1 class="fw-bold mb-2" style="font-size: 1.5rem; letter-spacing: -0.5px; color: #1a1d20;">Chi Tiết Đơn Hàng</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0" style="font-size: 0.85rem;">
                <li class="breadcrumb-item"><a href="?action=/" class="text-decoration-none text-secondary">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="?action=order-history" class="text-decoration-none text-secondary">Lịch sử</a></li>
                <li class="breadcrumb-item active fw-medium text-dark" aria-current="page">#GENTECH-<?= $order['order_id'] ?></li>
            </ol>
        </nav>
    </div>
</div>

<section class="container my-4 pb-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="premium-card p-3 mb-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
                    <div>
                        <span class="text-secondary small fw-medium text-uppercase letter-spacing-1 d-block mb-0" style="font-size: 0.75rem;">Mã đơn hàng</span>
                        <h5 class="fw-bold mb-0 text-dark">#GENTECH-<?= $order['order_id'] ?></h5>
                        <p class="text-secondary fw-medium mb-0" style="font-size: 0.85rem;"><i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y - H:i', strtotime($order['order_date'])) ?></p>
                    </div>
                    <div class="text-md-end">
                        <?php
                        $statusLabel = 'Chờ xác nhận';
                        $statusClass = 'bg-warning-subtle text-warning-emphasis';
                        $step = 1;
                        
                        if ($order['status'] == 'processing') {
                            $statusLabel = 'Chờ lấy hàng';
                            $statusClass = 'bg-info-subtle text-info-emphasis';
                            $step = 2;
                        } elseif ($order['status'] == 'shipping') {
                            $statusLabel = 'Đang giao hàng';
                            $statusClass = 'bg-primary-subtle text-primary-emphasis';
                            $step = 3;
                        } elseif ($order['status'] == 'completed') {
                            $statusLabel = 'Đã giao thành công';
                            $statusClass = 'bg-success-subtle text-success-emphasis';
                            $step = 4;
                        } elseif ($order['status'] == 'canceled') {
                            $statusLabel = 'Đã hủy';
                            $statusClass = 'bg-danger-subtle text-danger-emphasis';
                            $step = 0;
                        }
                        ?>
                        <div class="d-flex align-items-center gap-2 justify-content-md-end mb-2">
                            <span class="badge <?= $statusClass ?> rounded-pill px-4 py-2 fs-6 fw-semibold"><?= $statusLabel ?></span>
                        </div>
                    </div>
                </div>

                <!-- Timeline UI -->
                <?php if ($order['status'] != 'canceled'): ?>
                <div class="px-md-2 mb-3 pb-3 border-bottom border-light">
                    <div class="premium-timeline">
                        <div class="premium-timeline-step <?= $step >= 1 ? 'active' : '' ?>">
                            <div class="premium-timeline-icon"><i class="bi bi-card-checklist"></i></div>
                            <span class="premium-timeline-label">Chờ xác nhận</span>
                        </div>
                        <div class="premium-timeline-step <?= $step >= 2 ? 'active' : '' ?>">
                            <div class="premium-timeline-icon"><i class="bi bi-box-seam"></i></div>
                            <span class="premium-timeline-label">Chờ lấy hàng</span>
                        </div>
                        <div class="premium-timeline-step <?= $step >= 3 ? 'active' : '' ?>">
                            <div class="premium-timeline-icon"><i class="bi bi-truck"></i></div>
                            <span class="premium-timeline-label">Đang giao hàng</span>
                        </div>
                        <div class="premium-timeline-step <?= $step >= 4 ? 'active' : '' ?>">
                            <div class="premium-timeline-icon"><i class="bi bi-house-check"></i></div>
                            <span class="premium-timeline-label">Đã giao</span>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                    <div class="alert alert-danger mb-5 border-0 bg-danger-subtle text-danger-emphasis rounded-4 p-4 d-flex align-items-center">
                        <i class="bi bi-x-octagon-fill fs-2 me-4"></i>
                        <div>
                            <h5 class="mb-1 fw-bold">Đơn hàng đã bị hủy</h5>
                            <p class="mb-0">Đơn hàng này không còn hiệu lực. Vui lòng đặt đơn hàng mới nếu bạn vẫn có nhu cầu mua sắm tại Gentech.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="info-card p-3 h-100">
                            <div class="info-icon-wrapper bg-primary-subtle text-primary">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <h6 class="fw-bold mb-1 text-dark text-uppercase letter-spacing-1" style="font-size: 0.8rem;">Địa chỉ nhận hàng</h6>
                            <p class="mb-0 text-dark fw-bold" style="font-size: 0.9rem;"><?= htmlspecialchars($order['recipient_name']) ?></p>
                            <p class="mb-1 text-secondary" style="font-size: 0.85rem;"><i class="bi bi-telephone-fill me-1"></i><?= htmlspecialchars($order['recipient_phone']) ?></p>
                            <p class="text-secondary mb-0 mt-2 border-top pt-2 border-secondary border-opacity-10" style="font-size: 0.85rem;"><i class="bi bi-building me-1"></i><?= htmlspecialchars($order['shipping_address']) ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card p-3 h-100">
                            <div class="info-icon-wrapper bg-success-subtle text-success">
                                <i class="bi bi-credit-card-2-front-fill"></i>
                            </div>
                            <h6 class="fw-bold mb-1 text-dark text-uppercase letter-spacing-1" style="font-size: 0.8rem;">Phương thức thanh toán</h6>
                            <p class="mb-0 text-dark fw-bold" style="font-size: 0.9rem;">
                                <?php
                                    $pm = $order['payment_method'] ?? 'cod';
                                    if ($pm === 'vnpay') echo 'VNPAY / Thẻ ATM';
                                    elseif ($pm === 'momo') echo 'Ví MoMo';
                                    elseif ($pm === 'zalopay') echo 'ZaloPay';
                                    elseif ($pm === 'applepay') echo 'Apple Pay';
                                    else echo 'Thanh toán khi nhận hàng';
                                ?>
                            </p>
                            <div class="mt-2">
                                <?php if($order['payment_status'] == 'paid'): ?>
                                    <span class="badge bg-success-subtle text-success-emphasis rounded-pill px-2 py-1 fw-semibold" style="font-size: 0.75rem;"><i class="bi bi-check-circle-fill me-1"></i>Đã thanh toán</span>
                                <?php else: ?>
                                    <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-2 py-1 fw-semibold" style="font-size: 0.75rem;"><i class="bi bi-clock-fill me-1"></i>Chưa thanh toán</span>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($order['note'])): ?>
                                <p class="text-secondary mb-0 mt-2 border-top pt-2 border-secondary border-opacity-10" style="font-size: 0.85rem;"><i class="bi bi-card-text me-1"></i><strong>Ghi chú:</strong> <?= htmlspecialchars($order['note']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-bag-check-fill me-2 text-primary"></i>Sản phẩm đã đặt</h6>
                    <div class="table-responsive">
                        <table class="table table-borderless premium-table mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th scope="col" class="ps-0">Sản phẩm</th>
                                    <th scope="col" class="text-center">Đơn giá</th>
                                    <th scope="col" class="text-center">Số lượng</th>
                                    <th scope="col" class="text-end pe-0">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($orderDetails)): ?>
                                    <?php foreach ($orderDetails as $detail): ?>
                                        <tr>
                                            <td class="ps-0">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="product-img-wrapper shadow-sm">
                                                        <img src="<?= htmlspecialchars($detail['product_image']) ?>" alt="Product" class="img-fluid w-100 h-100" style="object-fit: contain;">
                                                    </div>
                                                    <div>
                                                        <p class="mb-1 text-dark fw-bold" style="max-width: 250px; line-height: 1.3; font-size: 0.85rem;"><?= htmlspecialchars($detail['product_name']) ?></p>
                                                        <?php if ($order['status'] == 'completed'): ?>
                                                            <a href="?action=product-detail&id=<?= $detail['product_id'] ?>#reviews" class="btn btn-sm btn-outline-primary mt-1 rounded-pill px-2 py-0" style="font-size: 0.75rem;">Đánh giá</a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center fw-medium text-secondary" style="font-size: 0.85rem;"><?= number_format($detail['unit_price'], 0, ',', '.') ?>đ</td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark border px-2 py-1 fw-bold" style="font-size: 0.8rem;">x<?= $detail['quantity'] ?></span>
                                            </td>
                                            <td class="text-end fw-bold text-dark pe-0" style="font-size: 0.9rem;"><?= number_format($detail['unit_price'] * $detail['quantity'], 0, ',', '.') ?>đ</td>
                                        </tr>
                                    <?php endforeach; ?>
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
                $discountAmount = $subtotal - $order['total_amount'];
                if ($discountAmount < 0) $discountAmount = 0;
                ?>
                <div class="row justify-content-end mt-4 pt-4 border-top">
                    <div class="col-md-5 col-lg-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary fw-medium" style="font-size: 0.85rem;">Tổng tiền hàng</span>
                            <span class="text-dark fw-bold" style="font-size: 0.85rem;"><?= number_format($subtotal, 0, ',', '.') ?>đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary fw-medium" style="font-size: 0.85rem;">Phí vận chuyển</span>
                            <span class="text-success fw-bold" style="font-size: 0.85rem;">Miễn phí</span>
                        </div>
                        <?php if ($discountAmount > 0): ?>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-secondary fw-medium" style="font-size: 0.85rem;">
                                Mã giảm giá 
                                <?php if (!empty($order['discount_code'])): ?>
                                    <span class="badge bg-primary ms-1"><?= htmlspecialchars($order['discount_code']) ?></span>
                                <?php endif; ?>
                            </span>
                            <span class="text-danger fw-bold" style="font-size: 0.85rem;">-<?= number_format($discountAmount, 0, ',', '.') ?>đ</span>
                        </div>
                        <?php endif; ?>
                        <div class="d-flex justify-content-between align-items-center bg-gray-100 p-2 rounded-3 border">
                            <span class="fw-bold text-dark text-uppercase letter-spacing-1" style="font-size: 0.85rem;">Thành tiền</span>
                            <span class="fw-bold text-danger" style="font-size: 1.1rem;"><?= number_format($order['total_amount'], 0, ',', '.') ?>đ</span>
                        </div>
                    </div>
                </div>

                <div class="mt-3 text-center">
                    <a href="?action=order-history" class="btn btn-outline-dark rounded-pill px-4 py-1 fw-bold transition-all" style="font-size: 0.85rem;"><i class="bi bi-arrow-left me-1"></i>Trở về</a>
                </div>

            </div>
            
        </div>
    </div>
</section>
