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
                            <a class="nav-link" href="#">Khuyến mãi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Tin tức</a>
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

    <!-- Footer -->
    <footer class="gentech-footer bg-dark text-white pt-5 pb-4">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h3 class="fw-bold mb-3">GENTECH<span class="text-primary">.</span></h3>
                    <p class="text-secondary">Hệ thống bán lẻ các sản phẩm công nghệ, điện tử, laptop và điện thoại thông minh chính hãng với giá tốt nhất thị trường.</p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="#" class="text-white fs-4 hover-primary"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white fs-4 hover-primary"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white fs-4 hover-primary"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="text-white fs-4 hover-primary"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="fw-bold mb-4">Sản Phẩm</h5>
                    <ul class="list-unstyled text-secondary">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary hover-primary">Điện thoại</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary hover-primary">Laptop</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary hover-primary">Âm thanh</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary hover-primary">Phụ kiện</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="fw-bold mb-4">Hỗ Trợ</h5>
                    <ul class="list-unstyled text-secondary">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary hover-primary">Chính sách bảo hành</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary hover-primary">Chính sách đổi trả</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary hover-primary">Giao hàng & Thanh toán</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary hover-primary">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h5 class="fw-bold mb-4">Đăng Ký Nhận Tin</h5>
                    <p class="text-secondary">Đăng ký để nhận thông tin về các chương trình khuyến mãi mới nhất từ Gentech.</p>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control border-0 bg-secondary text-white" placeholder="Email của bạn..." aria-label="Email">
                        <button class="btn btn-primary px-4" type="button">Đăng ký</button>
                    </div>
                </div>
            </div>
            <div class="border-top border-secondary pt-4 text-center text-secondary">
                <p class="mb-0">&copy; 2026 Gentech. All rights reserved.</p>
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
