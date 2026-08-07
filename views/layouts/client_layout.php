<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Gentech - Ultra Premium Electronics' ?></title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?= BASE_CSS ?? 'assets/css/' ?>client.css?v=<?= time() ?>" rel="stylesheet">
    <link href="<?= BASE_CSS ?? 'assets/css/' ?>style.css?v=<?= time() ?>" rel="stylesheet">
</head>
<body>

    <!-- Sticky Glassmorphism Header -->
    <header class="gentech-header fixed-top transition-all duration-300">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand fw-bold fs-3 text-dark" href="<?= BASE_URL ?? '/' ?>">
                    GENTECH<span class="text-primary">.</span>
                </a>

                <!-- Mobile Toggle -->
                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                    <i class="bi bi-list fs-1"></i>
                </button>

                <!-- Nav Links & Search -->
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-5 gap-3 fw-medium">
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= BASE_URL ?? '/' ?>">Trang chủ</a>
                        </li>
                        <li class="nav-item dropdown mega-dropdown">
                            <a class="nav-link dropdown-toggle" href="<?= BASE_URL ?? '/' ?>?action=products" data-bs-toggle="dropdown">Sản phẩm</a>
                            <!-- Mega Menu -->
                            <div class="dropdown-menu mega-menu mt-0 border-0 shadow-sm rounded-4 p-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h6 class="fw-bold mb-3">Điện thoại & Tablet</h6>
                                        <ul class="list-unstyled">
                                            <li><a class="dropdown-item px-0" href="?action=products">iPhone</a></li>
                                            <li><a class="dropdown-item px-0" href="?action=products">Samsung Galaxy</a></li>
                                            <li><a class="dropdown-item px-0" href="?action=products">Xiaomi</a></li>
                                            <li><a class="dropdown-item px-0" href="?action=products">iPad</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="fw-bold mb-3">Laptop & Macbook</h6>
                                        <ul class="list-unstyled">
                                            <li><a class="dropdown-item px-0" href="?action=products">Macbook Pro</a></li>
                                            <li><a class="dropdown-item px-0" href="?action=products">Asus ROG</a></li>
                                            <li><a class="dropdown-item px-0" href="?action=products">Dell XPS</a></li>
                                            <li><a class="dropdown-item px-0" href="?action=products">HP Envy</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="fw-bold mb-3">Phụ Kiện & Âm Thanh</h6>
                                        <ul class="list-unstyled">
                                            <li><a class="dropdown-item px-0" href="?action=products">Tai nghe Bluetooth</a></li>
                                            <li><a class="dropdown-item px-0" href="?action=products">Loa di động</a></li>
                                            <li><a class="dropdown-item px-0" href="?action=products">Chuột & Bàn phím</a></li>
                                            <li><a class="dropdown-item px-0" href="?action=products">Cáp sạc & Pin dự phòng</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-12 mt-3 pt-3 border-top text-center">
                                        <a href="?action=products" class="text-primary fw-bold text-decoration-none hover-primary">Xem tất cả sản phẩm <i class="bi bi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?? '/' ?>?action=about">Về chúng tôi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?? '/' ?>?action=news">Tin tức</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?? '/' ?>?action=support">Hỗ trợ</a>
                        </li>
                    </ul>

                    <!-- Search & Actions -->
                    <div class="d-flex align-items-center gap-3">
                        <div class="search-box position-relative d-none d-lg-block">
                            <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                            <input type="text" class="form-control rounded-pill ps-5 bg-light border-0" placeholder="Tìm kiếm...">
                        </div>
                        <button class="btn btn-light rounded-circle icon-btn position-relative hover-primary-bg transition-all border-0" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart">
                            <i class="bi bi-cart3 fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger shadow-sm">
                                3
                            </span>
                        </button>
                        <?php if (isset($_SESSION['user'])): ?>
                            <div class="dropdown d-inline-block">
                                <a href="#" class="btn btn-light rounded-circle icon-btn" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-check-fill fs-5 text-primary"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-2 rounded-3">
                                    <li><h6 class="dropdown-header">Xin chào, <?= htmlspecialchars($_SESSION['user']['full_name'] ?? 'User') ?></h6></li>
                                    <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 1): ?>
                                        <li><a class="dropdown-item" href="<?= BASE_URL ?? '/' ?>?action=admin">Trang quản trị</a></li>
                                    <?php endif; ?>
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?? '/' ?>?action=profile"><i class="bi bi-person me-2"></i>Hồ sơ cá nhân</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?? '/' ?>?action=logout"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?? '/' ?>?action=login" class="btn btn-light rounded-circle icon-btn position-relative hover-primary-bg transition-all">
                                <i class="bi bi-person fs-5"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="gentech-main pt-5 mt-4">
        <?php
        if (isset($view) && !empty($view)) {
            require_once PATH_VIEW . $view . '.php';
        } else {
            echo '<div class="container mt-5 pt-5"><div class="alert alert-warning">View không được tìm thấy.</div></div>';
        }
        ?>
    </main>

    <!-- Policy/Trust Badges -->
    <div class="trust-badges-section py-5 mt-5">
        <div class="container">
            <div class="row text-center gy-4">
                <div class="col-6 col-md-3 trust-item">
                    <div class="trust-icon-wrap">
                        <i class="bi bi-shield-check fs-2"></i>
                    </div>
                    <h6 class="trust-title">Thương hiệu đảm bảo</h6>
                    <p class="trust-desc">Nhập khẩu, bảo hành chính hãng</p>
                </div>
                <div class="col-6 col-md-3 trust-item">
                    <div class="trust-icon-wrap">
                        <i class="bi bi-arrow-repeat fs-2"></i>
                    </div>
                    <h6 class="trust-title">Đổi trả dễ dàng</h6>
                    <p class="trust-desc">Theo chính sách đổi trả tại Gentech</p>
                </div>
                <div class="col-6 col-md-3 trust-item">
                    <div class="trust-icon-wrap">
                        <i class="bi bi-truck fs-2"></i>
                    </div>
                    <h6 class="trust-title">Giao hàng tận nơi</h6>
                    <p class="trust-desc">Trên toàn quốc</p>
                </div>
                <div class="col-6 col-md-3 trust-item">
                    <div class="trust-icon-wrap">
                        <i class="bi bi-shield-shaded fs-2"></i>
                    </div>
                    <h6 class="trust-title">Sản phẩm chất lượng</h6>
                    <p class="trust-desc">Đảm bảo tương thích và độ bền cao</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Premium -->
    <footer class="gentech-footer bg-dark pt-5 pb-3" style="color: #a1a1aa; border-top: 5px solid var(--primary-color);">
        <div class="container pt-4">
            <div class="row g-5 mb-5">
                <!-- Cột 1: Thông tin công ty -->
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h3 class="fw-bold mb-4 text-white" style="letter-spacing: 2px;">GENTECH<span class="text-primary">.</span></h3>
                    <p class="mb-4 pe-lg-4 text-gray-300" style="line-height: 1.8;">Tiên phong định hình phong cách sống công nghệ. Chúng tôi tự hào mang đến trải nghiệm mua sắm thiết bị điện tử thông minh, đẳng cấp và khác biệt nhất tại Việt Nam.</p>
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-telephone-fill fs-5"></i>
                        </div>
                        <div>
                            <p class="mb-0 small text-gray-400">Hotline 24/7</p>
                            <h5 class="fw-bold text-white mb-0">1900 1234</h5>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mt-4">
                        <a href="#" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center border-gray-600 hover-white transition-all" style="width: 40px; height: 40px;"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center border-gray-600 hover-white transition-all" style="width: 40px; height: 40px;"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center border-gray-600 hover-white transition-all" style="width: 40px; height: 40px;"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center border-gray-600 hover-white transition-all" style="width: 40px; height: 40px;"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
                
                <!-- Cột 2: Sản phẩm -->
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="fw-bold mb-4 text-white">Sản Phẩm</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3"><a href="#" class="text-decoration-none text-gray-400 hover-primary transition-all d-inline-block" style="transform: translateX(0);"><i class="bi bi-chevron-right small me-2 text-primary"></i>Điện thoại Apple</a></li>
                        <li class="mb-3"><a href="#" class="text-decoration-none text-gray-400 hover-primary transition-all d-inline-block" style="transform: translateX(0);"><i class="bi bi-chevron-right small me-2 text-primary"></i>Laptop cao cấp</a></li>
                        <li class="mb-3"><a href="#" class="text-decoration-none text-gray-400 hover-primary transition-all d-inline-block" style="transform: translateX(0);"><i class="bi bi-chevron-right small me-2 text-primary"></i>Âm thanh & Audio</a></li>
                        <li class="mb-3"><a href="#" class="text-decoration-none text-gray-400 hover-primary transition-all d-inline-block" style="transform: translateX(0);"><i class="bi bi-chevron-right small me-2 text-primary"></i>Phụ kiện thông minh</a></li>
                        <li class="mb-3"><a href="#" class="text-decoration-none text-gray-400 hover-primary transition-all d-inline-block" style="transform: translateX(0);"><i class="bi bi-chevron-right small me-2 text-primary"></i>Hàng cũ (CPO)</a></li>
                    </ul>
                </div>
                
                <!-- Cột 3: Hỗ trợ -->
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="fw-bold mb-4 text-white">Chính Sách</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3"><a href="#" class="text-decoration-none text-gray-400 hover-primary transition-all d-inline-block"><i class="bi bi-chevron-right small me-2 text-primary"></i>Chính sách bảo hành</a></li>
                        <li class="mb-3"><a href="#" class="text-decoration-none text-gray-400 hover-primary transition-all d-inline-block"><i class="bi bi-chevron-right small me-2 text-primary"></i>Chính sách đổi trả 30 ngày</a></li>
                        <li class="mb-3"><a href="#" class="text-decoration-none text-gray-400 hover-primary transition-all d-inline-block"><i class="bi bi-chevron-right small me-2 text-primary"></i>Giao hàng hỏa tốc</a></li>
                        <li class="mb-3"><a href="#" class="text-decoration-none text-gray-400 hover-primary transition-all d-inline-block"><i class="bi bi-chevron-right small me-2 text-primary"></i>Chính sách bảo mật</a></li>
                        <li class="mb-3"><a href="<?= BASE_URL ?? '/' ?>?action=support" class="text-decoration-none text-gray-400 hover-primary transition-all d-inline-block"><i class="bi bi-chevron-right small me-2 text-primary"></i>Trung tâm hỗ trợ</a></li>
                    </ul>
                </div>
                
                <!-- Cột 4: Đăng ký & Chứng nhận -->
                <div class="col-lg-4 col-md-4">
                    <h5 class="fw-bold mb-4 text-white">Đăng Ký Nhận Bản Tin</h5>
                    <p class="mb-4 text-gray-400">Trở thành người đầu tiên sở hữu các siêu phẩm mới nhất và nhận ưu đãi độc quyền.</p>
                    <div class="input-group mb-4 rounded-pill overflow-hidden p-1 bg-gray-800 border border-gray-700">
                        <input type="text" class="form-control border-0 bg-transparent text-white px-4 shadow-none" placeholder="Email của bạn..." aria-label="Email">
                        <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" type="button">Đăng ký ngay</button>
                    </div>
                    
                    <h6 class="fw-bold mb-3 mt-5 text-white">Phương Thức Thanh Toán</h6>
                    <div class="d-flex gap-2 flex-wrap">
                        <!-- Giả lập các logo thanh toán -->
                        <div class="bg-white rounded px-2 py-1"><span class="text-dark fw-bold small">VISA</span></div>
                        <div class="bg-white rounded px-2 py-1"><span class="text-dark fw-bold small">MasterCard</span></div>
                        <div class="bg-white rounded px-2 py-1"><span class="text-primary fw-bold small">VNPAY</span></div>
                        <div class="bg-white rounded px-2 py-1"><span class="text-danger fw-bold small">MOMO</span></div>
                    </div>
                </div>
            </div>
            
            <!-- Bottom Footer -->
            <div class="row pt-4 mt-4 border-top border-gray-700 align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-0 text-gray-400 small">&copy; 2026 Gentech. Bản quyền thuộc về Công ty TNHH Gentech Việt Nam.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <!-- Giả lập logo BCT -->
                    <span class="badge border border-gray-600 text-gray-400 rounded-pill px-3 py-2 fw-normal hover-white cursor-pointer"><i class="bi bi-check-circle-fill text-success me-2"></i>Đã thông báo Bộ Công Thương</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Off-Canvas Cart (Premium) -->
    <div class="offcanvas offcanvas-end offcanvas-cart" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
        <div class="offcanvas-header border-bottom py-3">
            <h5 class="offcanvas-title fw-bold" id="offcanvasCartLabel"><i class="bi bi-cart3 me-2"></i>Giỏ hàng (3)</h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0 custom-scrollbar">
            <!-- Cart Items -->
            <div class="d-flex flex-column h-100">
                <div class="flex-grow-1 overflow-auto p-3">
                    <?php for($i=1; $i<=3; $i++): ?>
                    <div class="cart-item d-flex gap-3 mb-3 pb-3 border-bottom position-relative">
                        <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=100&auto=format&fit=crop" class="rounded-3 border" width="80" height="80" style="object-fit:cover;" alt="Product">
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1 text-truncate" style="max-width: 220px;">iPhone 15 Pro Max</h6>
                            <p class="text-muted small mb-2">Titan Tự Nhiên, 256GB</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-danger">29.990.000đ</span>
                                <div class="input-group input-group-sm" style="width: 90px;">
                                    <button class="btn btn-outline-secondary px-2" type="button">-</button>
                                    <input type="text" class="form-control text-center px-1" value="1">
                                    <button class="btn btn-outline-secondary px-2" type="button">+</button>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-link text-danger position-absolute top-0 end-0 p-0 shadow-none"><i class="bi bi-trash3"></i></button>
                    </div>
                    <?php endfor; ?>
                </div>
                
                <!-- Cart Footer -->
                <div class="p-4 bg-light border-top mt-auto">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tạm tính:</span>
                        <span class="fw-bold fs-6">89.970.000đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="text-muted">Giảm giá:</span>
                        <span class="text-success fw-bold">-0đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4 pb-3 border-bottom border-gray-300">
                        <span class="fw-bold fs-5 text-dark">Tổng cộng:</span>
                        <span class="fw-bold fs-4 text-danger">89.970.000đ</span>
                    </div>
                    <a href="<?= BASE_URL ?? '/' ?>?action=cart" class="btn btn-outline-dark w-100 rounded-pill py-2 mb-2 fw-bold">Xem chi tiết giỏ hàng</a>
                    <a href="<?= BASE_URL ?? '/' ?>?action=checkout" class="btn btn-premium-gradient w-100 rounded-pill py-3 fw-bold fs-6">Thanh Toán Ngay <i class="bi bi-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="<?= BASE_JS ?? 'assets/js/' ?>client.js?v=<?= time() ?>"></script>
    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 50,
            easing: 'ease-out-cubic'
        });
    </script>
</body>
</html>
