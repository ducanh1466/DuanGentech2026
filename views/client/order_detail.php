<style>
    /* Premium White Theme UI for Order Detail */
    body {
        background-color: #f8f9fa;
    }
    
    .premium-page-header {
        background: linear-gradient(135deg, #ffffff 0%, #f1f3f5 100%);
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 3rem 0;
    }

    .premium-card {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 10px 40px rgba(0,0,0,0.03);
        overflow: hidden;
    }

    .info-card {
        background: #f8f9fa;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.03);
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        background: #ffffff;
        box-shadow: 0 8px 25px rgba(0,0,0,0.04);
        transform: translateY(-3px);
    }

    .info-icon-wrapper {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    /* Modern Timeline */
    .premium-timeline {
        position: relative;
        display: flex;
        justify-content: space-between;
        margin: 2rem 0;
    }
    
    .premium-timeline::before {
        content: '';
        position: absolute;
        top: 24px;
        left: 0;
        right: 0;
        height: 3px;
        background: #e9ecef;
        z-index: 1;
        border-radius: 3px;
    }

    .premium-timeline-step {
        position: relative;
        z-index: 2;
        text-align: center;
        flex: 1;
    }

    .premium-timeline-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #ffffff;
        border: 3px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px auto;
        color: #adb5bd;
        font-size: 1.2rem;
        transition: all 0.4s ease;
        box-shadow: 0 0 0 5px #ffffff;
    }

    .premium-timeline-step.active .premium-timeline-icon {
        background: #212529;
        border-color: #212529;
        color: #ffffff;
        box-shadow: 0 0 0 5px rgba(33, 37, 41, 0.1);
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
        top: 24px;
        left: 50%;
        width: 100%;
        height: 3px;
        background: #212529;
        z-index: -1;
    }
    .premium-timeline-step:last-child::after {
        display: none;
    }

    .premium-timeline-label {
        font-size: 0.85rem;
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
        padding: 1.5rem 0;
    }
    .premium-table tr:last-child td {
        border-bottom: none;
    }

    .product-img-wrapper {
        width: 80px;
        height: 80px;
        background: #f8f9fa;
        border-radius: 12px;
        padding: 0.5rem;
        border: 1px solid rgba(0,0,0,0.02);
    }
</style>

<div class="premium-page-header">
    <div class="container text-center">
        <h1 class="fw-bold mb-3" style="font-size: 2.5rem; letter-spacing: -1px; color: #1a1d20;">Chi Tiết Đơn Hàng</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="?action=/" class="text-decoration-none text-secondary">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="?action=order-history" class="text-decoration-none text-secondary">Lịch sử mua hàng</a></li>
                <li class="breadcrumb-item active fw-medium text-dark" aria-current="page">#GENTECH-<?= $order['order_id'] ?></li>
            </ol>
        </nav>
    </div>
</div>

<section class="container my-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="premium-card p-4 p-md-5 mb-5">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
                    <div>
                        <span class="text-secondary small fw-medium text-uppercase letter-spacing-1 d-block mb-1">Mã đơn hàng</span>
                        <h3 class="fw-bold mb-1 text-dark">#GENTECH-<?= $order['order_id'] ?></h3>
                        <p class="text-secondary fw-medium mb-0"><i class="bi bi-calendar3 me-2"></i><?= date('d/m/Y - H:i', strtotime($order['order_date'])) ?></p>
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
                <div class="px-md-5 mb-5 pb-4 border-bottom border-light">
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

                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="info-card p-4 h-100">
                            <div class="info-icon-wrapper bg-primary-subtle text-primary">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <h6 class="fw-bold mb-3 text-dark text-uppercase letter-spacing-1">Địa chỉ nhận hàng</h6>
                            <p class="mb-1 text-dark fw-bold fs-5"><?= htmlspecialchars($order['recipient_name']) ?></p>
                            <p class="mb-2 text-secondary"><i class="bi bi-telephone-fill me-2"></i><?= htmlspecialchars($order['recipient_phone']) ?></p>
                            <p class="text-secondary mb-0 mt-3 border-top pt-3 border-secondary border-opacity-10"><i class="bi bi-building me-2"></i><?= htmlspecialchars($order['shipping_address']) ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card p-4 h-100">
                            <div class="info-icon-wrapper bg-success-subtle text-success">
                                <i class="bi bi-credit-card-2-front-fill"></i>
                            </div>
                            <h6 class="fw-bold mb-3 text-dark text-uppercase letter-spacing-1">Phương thức thanh toán</h6>
                            <p class="mb-1 text-dark fw-bold fs-5">
                                <?php
                                    $pm = $order['payment_method'] ?? 'cod';
                                    if ($pm === 'vnpay') echo 'VNPAY / Thẻ ATM';
                                    elseif ($pm === 'momo') echo 'Ví MoMo';
                                    elseif ($pm === 'zalopay') echo 'ZaloPay';
                                    elseif ($pm === 'applepay') echo 'Apple Pay';
                                    else echo 'Thanh toán khi nhận hàng';
                                ?>
                            </p>
                            <div class="mt-3">
                                <?php if($order['payment_status'] == 'paid'): ?>
                                    <span class="badge bg-success-subtle text-success-emphasis rounded-pill px-3 py-2 fw-semibold fs-6"><i class="bi bi-check-circle-fill me-2"></i>Đã thanh toán</span>
                                <?php else: ?>
                                    <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-2 fw-semibold fs-6"><i class="bi bi-clock-fill me-2"></i>Chưa thanh toán</span>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($order['note'])): ?>
                                <p class="text-secondary mb-0 mt-3 border-top pt-3 border-secondary border-opacity-10"><i class="bi bi-card-text me-2"></i><strong>Ghi chú:</strong> <?= htmlspecialchars($order['note']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-bag-check-fill me-2 text-primary"></i>Sản phẩm đã đặt</h5>
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
                                                <div class="d-flex align-items-center gap-4">
                                                    <div class="product-img-wrapper shadow-sm">
                                                        <img src="<?= htmlspecialchars($detail['product_image']) ?>" alt="Product" class="img-fluid w-100 h-100" style="object-fit: contain;">
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1 text-dark fw-bold fs-6" style="max-width: 300px; line-height: 1.4;"><?= htmlspecialchars($detail['product_name']) ?></h6>
                                                        <?php if ($order['status'] == 'completed'): ?>
                                                            <a href="?action=product-detail&id=<?= $detail['product_id'] ?>#reviews" class="btn btn-sm btn-outline-primary mt-2 rounded-pill px-3">Đánh giá sản phẩm</a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center fw-medium text-secondary"><?= number_format($detail['unit_price'], 0, ',', '.') ?>đ</td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark border px-3 py-2 fw-bold fs-6">x<?= $detail['quantity'] ?></span>
                                            </td>
                                            <td class="text-end fw-bold text-dark fs-5 pe-0"><?= number_format($detail['unit_price'] * $detail['quantity'], 0, ',', '.') ?>đ</td>
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
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-secondary fw-medium">Tổng tiền hàng</span>
                            <span class="text-dark fw-bold"><?= number_format($subtotal, 0, ',', '.') ?>đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-secondary fw-medium">Phí vận chuyển</span>
                            <span class="text-success fw-bold">Miễn phí</span>
                        </div>
                        <?php if ($discountAmount > 0): ?>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-secondary fw-medium">
                                Mã giảm giá 
                                <?php if (!empty($order['discount_code'])): ?>
                                    <span class="badge bg-primary ms-1"><?= htmlspecialchars($order['discount_code']) ?></span>
                                <?php endif; ?>
                            </span>
                            <span class="text-danger fw-bold">-<?= number_format($discountAmount, 0, ',', '.') ?>đ</span>
                        </div>
                        <?php endif; ?>
                        <div class="d-flex justify-content-between align-items-center bg-gray-100 p-3 rounded-3 border">
                            <span class="fw-bold text-dark text-uppercase letter-spacing-1">Thành tiền</span>
                            <span class="fw-bold text-danger fs-3"><?= number_format($order['total_amount'], 0, ',', '.') ?>đ</span>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 text-center">
                    <a href="?action=order-history" class="btn btn-outline-dark rounded-pill px-5 py-3 fw-bold transition-all"><i class="bi bi-arrow-left me-2"></i>Trở về Lịch sử</a>
                </div>

            </div>
            
        </div>
    </div>
</section>
