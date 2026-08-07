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
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Sản phẩm</a>
                            <!-- Mega Menu -->
                            <div class="dropdown-menu mega-menu mt-0 border-0 shadow-sm rounded-4 p-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h6 class="fw-bold mb-3">Điện thoại & Tablet</h6>
                                        <ul class="list-unstyled">
                                            <li><a class="dropdown-item px-0" href="#">iPhone</a></li>
                                            <li><a class="dropdown-item px-0" href="#">Samsung Galaxy</a></li>
                                            <li><a class="dropdown-item px-0" href="#">Xiaomi</a></li>
                                            <li><a class="dropdown-item px-0" href="#">iPad</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="fw-bold mb-3">Laptop & Macbook</h6>
                                        <ul class="list-unstyled">
                                            <li><a class="dropdown-item px-0" href="#">Macbook Pro</a></li>
                                            <li><a class="dropdown-item px-0" href="#">Asus ROG</a></li>
                                            <li><a class="dropdown-item px-0" href="#">Dell XPS</a></li>
                                            <li><a class="dropdown-item px-0" href="#">HP Envy</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="fw-bold mb-3">Phụ Kiện & Âm Thanh</h6>
                                        <ul class="list-unstyled">
                                            <li><a class="dropdown-item px-0" href="#">Tai nghe Bluetooth</a></li>
                                            <li><a class="dropdown-item px-0" href="#">Loa di động</a></li>
                                            <li><a class="dropdown-item px-0" href="#">Chuột & Bàn phím</a></li>
                                            <li><a class="dropdown-item px-0" href="#">Cáp sạc & Pin dự phòng</a></li>
                                        </ul>
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
                        <a href="#" class="btn btn-light rounded-circle icon-btn position-relative">
                            <i class="bi bi-cart3 fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                3
                            </span>
                        </a>
                        <a href="#" class="btn btn-light rounded-circle icon-btn">
                            <i class="bi bi-person fs-5"></i>
                        </a>
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
