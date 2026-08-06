<!-- Hero Section -->
<div class="container mt-4">
    <div class="hero-section text-center text-md-start d-flex align-items-center">
        <div class="row w-100 align-items-center">
            <div class="col-md-6 ps-md-5">
                <span class="badge bg-primary rounded-pill px-3 py-2 mb-3 fs-6">Siêu Phẩm 2026</span>
                <h1 class="hero-title mb-4">Gentech<br>Pro Max <span class="text-primary">M3</span></h1>
                <p class="text-muted fs-5 mb-5">Trải nghiệm sức mạnh vô song với chip xử lý thế hệ mới. Mỏng hơn, nhẹ hơn, mạnh mẽ hơn bao giờ hết.</p>
                <div class="d-flex gap-3 justify-content-center justify-content-md-start">
                    <button class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-lg shadow-hover">Mua Ngay</button>
                    <button class="btn btn-outline-dark rounded-pill px-5 py-3 fw-bold">Tìm Hiểu Thêm</button>
                </div>
            </div>
            <div class="col-md-6 mt-5 mt-md-0 text-center">
                <!-- Giả lập hình ảnh 3D đẹp mắt -->
                <div class="rounded-circle bg-white shadow-lg mx-auto d-flex align-items-center justify-content-center" style="width: 400px; height: 400px; border: 15px solid #f8f9fa;">
                    <i class="bi bi-laptop text-primary" style="font-size: 150px;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Categories -->
<div class="container mt-5 pt-5">
    <h3 class="fw-bold mb-4 text-center">Khám Phá Danh Mục</h3>
    <div class="row justify-content-center">
        <!-- Category 1 -->
        <div class="col-6 col-md-3 col-lg-2 mb-4">
            <a href="#" class="text-decoration-none text-dark category-item d-block">
                <div class="category-circle">
                    <i class="bi bi-phone fs-1 text-primary"></i>
                </div>
                <h6 class="fw-bold">Điện Thoại</h6>
            </a>
        </div>
        <!-- Category 2 -->
        <div class="col-6 col-md-3 col-lg-2 mb-4">
            <a href="#" class="text-decoration-none text-dark category-item d-block">
                <div class="category-circle">
                    <i class="bi bi-laptop fs-1 text-primary"></i>
                </div>
                <h6 class="fw-bold">Laptop</h6>
            </a>
        </div>
        <!-- Category 3 -->
        <div class="col-6 col-md-3 col-lg-2 mb-4">
            <a href="#" class="text-decoration-none text-dark category-item d-block">
                <div class="category-circle">
                    <i class="bi bi-smartwatch fs-1 text-primary"></i>
                </div>
                <h6 class="fw-bold">Smartwatch</h6>
            </a>
        </div>
        <!-- Category 4 -->
        <div class="col-6 col-md-3 col-lg-2 mb-4">
            <a href="#" class="text-decoration-none text-dark category-item d-block">
                <div class="category-circle">
                    <i class="bi bi-headphones fs-1 text-primary"></i>
                </div>
                <h6 class="fw-bold">Âm Thanh</h6>
            </a>
        </div>
        <!-- Category 5 -->
        <div class="col-6 col-md-3 col-lg-2 mb-4">
            <a href="#" class="text-decoration-none text-dark category-item d-block">
                <div class="category-circle">
                    <i class="bi bi-mouse fs-1 text-primary"></i>
                </div>
                <h6 class="fw-bold">Phụ Kiện</h6>
            </a>
        </div>
    </div>
</div>

<!-- Latest Products -->
<div class="container mt-5 pt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Sản Phẩm Mới Nhất</h3>
        <a href="#" class="text-decoration-none text-primary fw-medium">Xem tất cả <i class="bi bi-arrow-right"></i></a>
    </div>
    
    <div class="row">
        <?php for($i=1; $i<=4; $i++): ?>
        <div class="col-sm-6 col-lg-3 mb-4">
            <div class="product-card">
                <div class="product-badge bg-danger text-white"><i class="bi bi-stars"></i> Mới</div>
                <div class="product-image-wrap">
                    <i class="bi bi-laptop text-secondary" style="font-size: 80px;"></i>
                </div>
                <div class="product-info mt-3">
                    <div class="d-flex text-warning mb-2 fs-6">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star"></i>
                        <span class="text-muted ms-2 small">(24)</span>
                    </div>
                    <h5 class="fw-bold mb-1 text-truncate">Gentech Ultrabook <?= $i ?></h5>
                    <p class="text-muted small mb-2">Intel Core Ultra / 16GB RAM</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <span class="fs-5 fw-bold text-primary">28.990.000đ</span>
                        </div>
                        <button class="btn btn-primary rounded-circle icon-btn shadow-sm add-to-cart-btn">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endfor; ?>
    </div>
</div>

<!-- Banner Khuyến Mãi -->
<div class="container mt-5 pt-4">
    <div class="row">
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="rounded-4 p-5 text-white position-relative overflow-hidden" style="background: linear-gradient(45deg, #1f2937, #111827);">
                <div class="position-relative z-1">
                    <h3 class="fw-bold mb-3">Âm thanh<br>Đỉnh cao</h3>
                    <p class="mb-4 text-gray-300">Giảm ngay 30% cho các dòng tai nghe chống ồn.</p>
                    <button class="btn btn-light rounded-pill px-4 fw-bold">Khám phá</button>
                </div>
                <i class="bi bi-headphones position-absolute text-white opacity-25" style="font-size: 250px; right: -20px; bottom: -50px; transform: rotate(-15deg);"></i>
            </div>
        </div>
        <div class="col-md-6">
            <div class="rounded-4 p-5 text-white position-relative overflow-hidden" style="background: linear-gradient(45deg, #0d6efd, #0dcaf0);">
                <div class="position-relative z-1">
                    <h3 class="fw-bold mb-3">Trở lại<br>Trường học</h3>
                    <p class="mb-4 text-white-50">Tặng kèm balo và chuột không dây khi mua Laptop.</p>
                    <button class="btn btn-light rounded-pill px-4 fw-bold">Mua ngay</button>
                </div>
                <i class="bi bi-backpack position-absolute text-white opacity-25" style="font-size: 250px; right: 0; bottom: -50px; transform: rotate(10deg);"></i>
            </div>
        </div>
    </div>
</div>

<!-- Best Sellers -->
<div class="container mt-5 pt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Sản Phẩm Bán Chạy Nhất</h3>
        <a href="#" class="text-decoration-none text-primary fw-medium">Xem tất cả <i class="bi bi-arrow-right"></i></a>
    </div>
    
    <div class="row">
        <?php for($i=1; $i<=4; $i++): ?>
        <div class="col-sm-6 col-lg-3 mb-4">
            <div class="product-card">
                <div class="product-badge bg-warning text-dark"><i class="bi bi-fire text-danger"></i> Bán Chạy</div>
                <div class="product-image-wrap">
                    <i class="bi bi-phone text-secondary" style="font-size: 80px;"></i>
                </div>
                <div class="product-info mt-3">
                    <div class="d-flex text-warning mb-2 fs-6">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <span class="text-muted ms-2 small">(892)</span>
                    </div>
                    <h5 class="fw-bold mb-1 text-truncate">Gentech Phone Pro <?= $i ?></h5>
                    <p class="text-muted small mb-2">256GB / Xám titan</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <span class="fs-5 fw-bold text-danger">24.990.000đ</span>
                            <br>
                            <span class="text-muted text-decoration-line-through small">29.990.000đ</span>
                        </div>
                        <button class="btn btn-primary rounded-circle icon-btn shadow-sm add-to-cart-btn">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endfor; ?>
    </div>
</div>
