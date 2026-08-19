<style>
    /* Premium White Theme UI for Order History */
    body {
        background-color: #f8f9fa;
    }
    
    .premium-page-header {
        background: linear-gradient(135deg, #ffffff 0%, #f1f3f5 100%);
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 2rem 0;
    }

    .premium-filter-nav {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.9);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.04);
        border-radius: 50px;
        padding: 0.5rem;
    }

    .premium-filter-nav .nav-link {
        color: #495057;
        font-weight: 600;
        border-radius: 50px;
        padding: 0.6rem 1.5rem;
        transition: all 0.3s ease;
        margin: 0 0.2rem;
    }

    .premium-filter-nav .nav-link:hover {
        background-color: #f1f3f5;
        color: #212529;
    }

    .premium-filter-nav .nav-link.active {
        background-color: #212529;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(33, 37, 41, 0.2);
    }

    .premium-order-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        overflow: hidden;
    }

    .premium-order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.06);
        border-color: rgba(0,0,0,0.08);
    }

    /* Subltle edge glow on hover */
    .premium-order-card::before {
        content: "";
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(120deg, transparent, rgba(255,255,255,0.8), transparent);
        transform: translateX(-100%);
        transition: 0.6s;
    }
    .premium-order-card:hover::before {
        transform: translateX(100%);
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
        top: 18px; /* Center of icon */
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
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #ffffff;
        border: 2px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px auto;
        color: #adb5bd;
        font-size: 1rem;
        transition: all 0.4s ease;
        box-shadow: 0 0 0 3px #ffffff;
    }

    .premium-timeline-step.active .premium-timeline-icon {
        background: #212529;
        border-color: #212529;
        color: #ffffff;
        box-shadow: 0 0 0 4px rgba(33, 37, 41, 0.1);
    }
    
    .premium-timeline-step.active ~ .premium-timeline-step::after {
         /* Hide progress line for inactive steps */
    }

    /* Create the progress line filling up */
    .premium-timeline-step.active::after {
        content: '';
        position: absolute;
        top: 18px;
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
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .premium-timeline-step.active .premium-timeline-label {
        color: #212529;
    }

    .btn-premium-outline {
        border: 2px solid #212529;
        color: #212529;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-premium-outline:hover {
        background: #212529;
        color: #ffffff;
    }
</style>

<div class="premium-page-header">
    <div class="container text-center">
        <h1 class="fw-bold mb-3" style="font-size: 2.5rem; letter-spacing: -1px; color: #1a1d20;">Lịch Sử Mua Hàng</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="?action=/" class="text-decoration-none text-secondary">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="?action=profile" class="text-decoration-none text-secondary">Hồ sơ cá nhân</a></li>
                <li class="breadcrumb-item active fw-medium text-dark" aria-current="page">Lịch sử mua hàng</li>
            </ol>
        </nav>
    </div>
</div>

<section class="container my-5 pb-5">
    
    <!-- Premium Filter Tabs -->
    <div class="d-flex justify-content-center mb-5 sticky-top" style="top: 80px; z-index: 1000;">
        <div class="premium-filter-nav">
            <?php $currentStatus = $_GET['status'] ?? 'all'; ?>
            <ul class="nav nav-pills flex-nowrap" style="white-space: nowrap;">
                <li class="nav-item">
                    <a class="nav-link <?= $currentStatus == 'all' ? 'active' : '' ?>" href="?action=order-history&status=all">Tất cả</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentStatus == 'pending' ? 'active' : '' ?>" href="?action=order-history&status=pending">Chờ xác nhận</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentStatus == 'processing' ? 'active' : '' ?>" href="?action=order-history&status=processing">Chờ lấy hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentStatus == 'shipping' ? 'active' : '' ?>" href="?action=order-history&status=shipping">Đang giao hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentStatus == 'completed' ? 'active' : '' ?>" href="?action=order-history&status=completed">Đã giao</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentStatus == 'returned_all' ? 'active' : '' ?>" href="?action=order-history&status=returned_all">Trả hàng/Hoàn tiền</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentStatus == 'cancelled' ? 'active' : '' ?>" href="?action=order-history&status=cancelled">Đã hủy</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <?php if (empty($orders)): ?>
                <div class="premium-order-card p-5 text-center my-5">
                    <div style="width: 100px; height: 100px; background: #f8f9fa; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto;">
                        <i class="bi bi-cart-x text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-2">Chưa có đơn hàng nào</h3>
                    <p class="text-secondary mb-4">Bạn chưa có đơn hàng nào trong trạng thái này. Khám phá các sản phẩm nổi bật của chúng tôi ngay!</p>
                    <a href="?action=products" class="btn btn-dark rounded-pill px-5 py-3 shadow-sm fw-bold">Mua Sắm Ngay</a>
                </div>
            <?php else: ?>
                
                <?php foreach ($orders as $order): ?>
                <div class="premium-order-card p-4 mb-4" data-aos="fade-up">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start mb-3 gap-3">
                        <div>
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
                            } elseif ($order['status'] == 'return_requested') {
                                $statusLabel = 'Đang yêu cầu trả hàng';
                                $statusClass = 'bg-warning-subtle text-warning-emphasis';
                                $step = 4;
                            } elseif ($order['status'] == 'return_processing') {
                                $statusLabel = 'Đang xử lý trả hàng';
                                $statusClass = 'bg-info-subtle text-info-emphasis';
                                $step = 4;
                            } elseif ($order['status'] == 'returned') {
                                $statusLabel = 'Đã hoàn trả';
                                $statusClass = 'bg-secondary text-white';
                                $step = 4;
                            } elseif ($order['status'] == 'return_rejected') {
                                $statusLabel = 'Từ chối trả hàng';
                                $statusClass = 'bg-dark text-white';
                                $step = 4;
                            } elseif ($order['status'] == 'cancelled' || $order['status'] == 'canceled') {
                                $statusLabel = 'Đã hủy';
                                $statusClass = 'bg-danger-subtle text-danger-emphasis';
                                $step = 0;
                            }
                            ?>
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="badge <?= $statusClass ?> rounded-pill px-3 py-2 fw-semibold border border-light"><?= $statusLabel ?></span>
                                <?php if($order['payment_status'] == 'paid'): ?>
                                    <span class="badge bg-success-subtle text-success-emphasis rounded-pill px-3 py-2 fw-semibold"><i class="bi bi-check-circle-fill me-1"></i>Đã thanh toán</span>
                                <?php elseif($order['payment_status'] == 'refunded'): ?>
                                    <span class="badge bg-info-subtle text-info-emphasis rounded-pill px-3 py-2 fw-semibold"><i class="bi bi-arrow-counterclockwise me-1"></i>Đã hoàn tiền</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill px-3 py-2 fw-semibold"><i class="bi bi-clock me-1"></i>Chưa thanh toán</span>
                                <?php endif; ?>
                            </div>
                            
                            <h5 class="fw-bold mb-1" style="color: #1a1d20;">Đơn hàng #GENTECH-<?= $order['order_id'] ?></h5>
                            <p class="text-secondary small fw-medium mb-0"><i class="bi bi-calendar3 me-2"></i><?= date('H:i - d/m/Y', strtotime($order['order_date'])) ?></p>
                        </div>
                        <div class="text-md-end">
                            <span class="text-secondary fw-medium small text-uppercase letter-spacing-1 d-block mb-1">Tổng cộng</span>
                            <h4 class="fw-bold text-dark mb-0"><?= number_format($order['total_amount'], 0, ',', '.') ?>đ</h4>
                        </div>
                    </div>

                    <!-- Timeline UI -->
                    <?php if ($order['status'] != 'cancelled' && $order['status'] != 'canceled'): ?>
                    <div class="premium-timeline px-md-4">
                        <div class="premium-timeline-step <?= $step >= 1 ? 'active' : '' ?>">
                            <div class="premium-timeline-icon"><i class="bi bi-card-checklist"></i></div>
                            <div class="premium-timeline-label">Chờ xác nhận</div>
                        </div>
                        <div class="premium-timeline-step <?= $step >= 2 ? 'active' : '' ?>">
                            <div class="premium-timeline-icon"><i class="bi bi-box-seam"></i></div>
                            <div class="premium-timeline-label">Chờ lấy hàng</div>
                        </div>
                        <div class="premium-timeline-step <?= $step >= 3 ? 'active' : '' ?>">
                            <div class="premium-timeline-icon"><i class="bi bi-truck"></i></div>
                            <div class="premium-timeline-label">Đang giao</div>
                        </div>
                        <div class="premium-timeline-step <?= $step >= 4 ? 'active' : '' ?>">
                            <div class="premium-timeline-icon"><i class="bi bi-house-check"></i></div>
                            <div class="premium-timeline-label">Hoàn tất</div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <hr class="my-4 border-black border-opacity-10">

                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-gray-100 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-geo-alt-fill text-secondary"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.95rem;"><?= htmlspecialchars($order['recipient_name']) ?> <span class="text-muted fw-normal mx-1">•</span> <?= htmlspecialchars($order['recipient_phone']) ?></h6>
                                <p class="text-secondary small mb-0" style="max-width: 400px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= htmlspecialchars($order['shipping_address']) ?></p>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <?php if ($order['status'] == 'completed'): ?>
                                <a href="?action=order-detail&id=<?= $order['order_id'] ?>" class="btn btn-dark btn-sm px-4 py-2 flex-grow-1 text-nowrap">Đánh Giá</a>
                            <?php endif; ?>
                            <a href="?action=order-detail&id=<?= $order['order_id'] ?>" class="btn btn-premium-outline btn-sm px-4 py-2 flex-grow-1 text-nowrap">Chi Tiết</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                
            <?php endif; ?>
        </div>
    </div>
</section>
