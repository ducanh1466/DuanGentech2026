<div class="bg-gray-100 py-4 border-bottom">
    <div class="container">
        <h2 class="fw-bold mb-2">Hồ Sơ Của Tôi</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="?action=/" class="text-decoration-none text-muted hover-primary">Trang chủ</a></li>
                <li class="breadcrumb-item active text-dark fw-medium" aria-current="page">Hồ sơ cá nhân</li>
            </ol>
        </nav>
    </div>
</div>

<section class="container my-5 pb-5">
    <div class="row g-5">
        <!-- Profile Info -->
        <div class="col-lg-5" data-aos="fade-right">
            <div class="bg-white rounded-4 shadow-sm border p-4 p-md-5 h-100">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-4 mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold fs-4 shadow-sm" style="width: 60px; height: 60px;">
                            <?= strtoupper(substr($_SESSION['user']['full_name'] ?? 'U', 0, 1)) ?>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1"><?= htmlspecialchars($_SESSION['user']['full_name'] ?? 'Thành viên') ?></h4>
                            <span class="badge bg-dark rounded-pill fw-normal px-3 py-2"><i class="bi bi-star-fill text-warning me-1"></i>Thành viên hạng Vàng</span>
                        </div>
                    </div>
                </div>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger border-0 bg-danger-subtle rounded-3"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success border-0 bg-success-subtle rounded-3"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
                <?php endif; ?>
                
                <form method="POST" action="<?= BASE_URL ?>?action=update-profile">
                    <div class="form-floating-custom mb-4">
                        <input type="email" class="form-control" value="<?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>" disabled placeholder="Email">
                        <label>Email (Tài khoản)</label>
                        <i class="bi bi-envelope-fill"></i>
                        <small class="form-text text-muted mt-2 d-block"><i class="bi bi-info-circle me-1"></i>Không thể thay đổi email đăng nhập.</small>
                    </div>
                    <div class="form-floating-custom mb-4">
                        <input type="text" class="form-control" name="full_name" value="<?= htmlspecialchars($_SESSION['user']['full_name'] ?? '') ?>" required placeholder="Họ và tên">
                        <label>Họ và tên <span class="text-danger">*</span></label>
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="form-floating-custom mb-4">
                        <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($_SESSION['user']['phone'] ?? '') ?>" required placeholder="Số điện thoại">
                        <label>Số điện thoại <span class="text-danger">*</span></label>
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold">Địa chỉ giao hàng mặc định</label>
                        <textarea class="form-control border-gray-300 rounded-3 shadow-none p-3" name="address" rows="3" placeholder="Nhập địa chỉ giao hàng..."><?= htmlspecialchars($_SESSION['user']['address'] ?? '') ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-premium-gradient w-100 rounded-pill hover-elevate">
                        Lưu Thay Đổi
                    </button>
                    
                    <div class="text-center mt-4">
                        <a href="<?= BASE_URL ?>?action=change-password" class="text-decoration-none fw-medium text-dark hover-primary"><i class="bi bi-shield-lock me-1"></i>Thay đổi mật khẩu an toàn</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Order Timeline -->
        <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
            <h4 class="fw-bold mb-4">Đơn Hàng Gần Đây</h4>
            <div class="bg-gray-100 rounded-4 shadow-sm border p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-center border-bottom border-gray-300 pb-3 mb-4">
                    <div>
                        <span class="badge bg-primary rounded-pill px-3 py-2 mb-2">Đang giao</span>
                        <h5 class="fw-bold mb-0">Đơn hàng #GENTECH-9924</h5>
                        <p class="text-muted small mb-0 mt-1">Đặt lúc: 14:30 - 05/08/2026</p>
                    </div>
                    <div class="text-end">
                        <h4 class="fw-bold text-danger mb-0">35.880.000đ</h4>
                        <a href="#" class="text-decoration-none small text-primary fw-medium d-block mt-2">Xem chi tiết đơn hàng</a>
                    </div>
                </div>

                <!-- Timeline UI -->
                <div class="timeline-premium px-md-4">
                    <div class="timeline-step active">
                        <div class="timeline-icon"><i class="bi bi-check-lg"></i></div>
                        <span class="timeline-label">Chờ xác nhận</span>
                    </div>
                    <div class="timeline-step active">
                        <div class="timeline-icon"><i class="bi bi-box-seam"></i></div>
                        <span class="timeline-label">Đang lấy hàng</span>
                    </div>
                    <div class="timeline-step active">
                        <div class="timeline-icon"><i class="bi bi-truck"></i></div>
                        <span class="timeline-label">Đang giao hàng</span>
                    </div>
                    <div class="timeline-step">
                        <div class="timeline-icon"><i class="bi bi-house-door"></i></div>
                        <span class="timeline-label">Đã giao</span>
                    </div>
                </div>

                <div class="bg-white rounded-3 p-4 border mt-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Địa chỉ nhận hàng</h6>
                    <p class="mb-1 text-dark fw-medium">Phạm Đức Anh - 0987654321</p>
                    <p class="text-muted small mb-0">Toà nhà Lotte, Số 54 Liễu Giai, Phường Cống Vị, Quận Ba Đình, Hà Nội</p>
                </div>
            </div>
            
            <div class="mt-4 text-end">
                <a href="#" class="btn btn-outline-dark rounded-pill px-4 fw-bold shadow-sm">Xem Lịch Sử Mua Hàng <i class="bi bi-arrow-right ms-2"></i></a>
            </div>
        </div>
    </div>
</section>
