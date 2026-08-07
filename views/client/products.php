<!-- Page Header -->
<div class="bg-gray-100 py-4 border-bottom">
    <div class="container text-center">
        <h1 class="fw-bold mb-2">Tất Cả Sản Phẩm</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="?action=/" class="text-decoration-none text-muted hover-primary">Trang chủ</a></li>
                <li class="breadcrumb-item active text-dark fw-medium" aria-current="page">Sản phẩm</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Slider Banner Header -->
<div class="container mt-4" data-aos="fade-up">
    <div class="w-100 rounded-4 overflow-hidden shadow-float">
        <!-- SLIDER BANNER CHÍNH -->
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <!-- Chấm tròn chuyển slide -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            
            <!-- Khu vực chứa các ảnh -->
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="4000">
                    <img src="DUONG_DAN_ANH_BANNER_1.jpg" class="d-block w-100" alt="Banner 1" style="object-fit: cover; max-height: 400px; min-height: 250px;">
                </div>
                <div class="carousel-item" data-bs-interval="4000">
                    <img src="DUONG_DAN_ANH_BANNER_2.jpg" class="d-block w-100" alt="Banner 2" style="object-fit: cover; max-height: 400px; min-height: 250px;">
                </div>
                <div class="carousel-item" data-bs-interval="4000">
                    <img src="DUONG_DAN_ANH_BANNER_3.jpg" class="d-block w-100" alt="Banner 3" style="object-fit: cover; max-height: 400px; min-height: 250px;">
                </div>
            </div>
            
            <!-- Nút bấm trái phải -->
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Trước</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Sau</span>
            </button>
        </div>
    </div>
</div>

<!-- Shop Content -->
<div class="container py-5 my-3">
    <div class="row g-5">
        <!-- Sidebar Filter -->
        <div class="col-lg-3">
            <div class="bg-white rounded-4 shadow-sm border p-4 sticky-top" style="top: 100px;">
                <h5 class="fw-bold mb-4 border-bottom pb-3">Bộ Lọc Sản Phẩm</h5>
                
                <!-- Category Filter -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">Danh Mục</h6>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="cat1" checked>
                        <label class="form-check-label text-muted" for="cat1">Điện thoại (45)</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="cat2">
                        <label class="form-check-label text-muted" for="cat2">Laptop (32)</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="cat3">
                        <label class="form-check-label text-muted" for="cat3">Tablet (15)</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="cat4">
                        <label class="form-check-label text-muted" for="cat4">Phụ kiện (120)</label>
                    </div>
                </div>

                <!-- Brand Filter -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">Thương Hiệu</h6>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="brand1">
                        <label class="form-check-label text-muted" for="brand1">Apple</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="brand2">
                        <label class="form-check-label text-muted" for="brand2">Samsung</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="brand3">
                        <label class="form-check-label text-muted" for="brand3">Xiaomi</label>
                    </div>
                </div>

                <!-- Price Filter -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">Mức Giá</h6>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="price" id="price1">
                        <label class="form-check-label text-muted" for="price1">Dưới 5 triệu</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="price" id="price2">
                        <label class="form-check-label text-muted" for="price2">Từ 5 - 15 triệu</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="price" id="price3">
                        <label class="form-check-label text-muted" for="price3">Từ 15 - 25 triệu</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="price" id="price4">
                        <label class="form-check-label text-muted" for="price4">Trên 25 triệu</label>
                    </div>
                </div>
                
                <button class="btn btn-outline-dark w-100 rounded-pill fw-bold py-2 mt-2">Xóa bộ lọc</button>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="col-lg-9">
            <!-- Toolbar -->
            <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded-4 shadow-sm border">
                <p class="mb-0 text-muted">Hiển thị <span class="fw-bold text-dark">12</span> trên <span class="fw-bold text-dark">212</span> sản phẩm</p>
                <div class="d-flex align-items-center gap-3">
                    <label class="text-muted text-nowrap mb-0 d-none d-md-block">Sắp xếp theo:</label>
                    <select class="form-select border-0 bg-light rounded-pill px-4 fw-medium" style="width: auto; cursor: pointer;">
                        <option selected>Mới nhất</option>
                        <option value="1">Giá tăng dần</option>
                        <option value="2">Giá giảm dần</option>
                        <option value="3">Bán chạy nhất</option>
                    </select>
                </div>
            </div>

            <!-- Products -->
            <div class="row g-4">
                <?php for($i=1; $i<=9; $i++): ?>
                <div class="col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= ($i%3) * 100 ?>">
                    <div class="product-card h-100 p-0 text-start position-relative">
                        <!-- Thẻ trạng thái/Khuyến mãi -->
                        <?php if($i == 1 || $i == 4): ?>
                            <span class="badge bg-danger position-absolute top-0 start-0 m-3 z-1">-15%</span>
                        <?php elseif($i == 2): ?>
                            <span class="badge bg-dark position-absolute top-0 start-0 m-3 z-1">Mới</span>
                        <?php endif; ?>
                        
                        <div class="p-4 bg-light d-flex align-items-center justify-content-center cursor-pointer" style="height: 260px;" onclick="window.location.href='?action=product-detail'">
                            <!-- ĐIỀN ĐƯỜNG DẪN ẢNH SẢN PHẨM -->
                            <img src="DUONG_DAN_ANH_SP_<?= $i ?>.jpg" class="img-fluid mix-blend-multiply transition-transform hover-scale" alt="Product <?= $i ?>" style="max-height: 200px;">
                        </div>
                        <div class="p-4 bg-white">
                            <p class="text-muted small fw-bold mb-1">APPLE</p>
                            <h5 class="fw-bold mb-3 product-title text-truncate cursor-pointer hover-primary text-dark" onclick="window.location.href='?action=product-detail'">iPhone 15 Pro Max 256GB</h5>
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <span class="text-dark fw-bold fs-5 d-block">29.990.000đ</span>
                                    <?php if($i == 1 || $i == 4): ?>
                                    <span class="text-muted text-decoration-line-through small">34.990.000đ</span>
                                    <?php endif; ?>
                                </div>
                                <button class="btn btn-light rounded-circle text-primary hover-primary-bg transition-all" style="width: 40px; height: 40px;">
                                    <i class="bi bi-cart-plus fs-5"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>

            <!-- Pagination -->
            <div class="mt-5 pt-4 d-flex justify-content-center border-top">
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-lg gap-2">
                        <li class="page-item disabled">
                            <a class="page-link rounded-circle border-0 text-dark" href="#" tabindex="-1" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-chevron-left"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link rounded-circle border-0 shadow-sm" href="#" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; background-color: var(--primary-color);">1</a></li>
                        <li class="page-item"><a class="page-link rounded-circle border-0 text-dark" href="#" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">2</a></li>
                        <li class="page-item"><a class="page-link rounded-circle border-0 text-dark" href="#" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">3</a></li>
                        <li class="page-item">
                            <a class="page-link rounded-circle border-0 text-dark" href="#" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
