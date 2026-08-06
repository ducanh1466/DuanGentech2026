<div class="container mt-4 mb-5 pb-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>" class="text-decoration-none text-muted">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tất cả sản phẩm</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar Filter (Advanced) -->
        <div class="col-lg-3 mb-4 mb-lg-0">
            <div class="bg-white p-4 rounded-4 shadow-sm border border-light">
                <h5 class="fw-bold mb-4">Bộ Lọc Tìm Kiếm</h5>
                
                <!-- Category Filter -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">Danh Mục</h6>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="" id="cat1" checked>
                        <label class="form-check-label text-secondary" for="cat1">Điện thoại di động (120)</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="" id="cat2">
                        <label class="form-check-label text-secondary" for="cat2">Laptop & Macbook (85)</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="" id="cat3">
                        <label class="form-check-label text-secondary" for="cat3">Tai nghe & Loa (45)</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="" id="cat4">
                        <label class="form-check-label text-secondary" for="cat4">Phụ kiện (210)</label>
                    </div>
                </div>

                <!-- Price Filter (Toggle style) -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">Mức Giá</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <input type="radio" class="btn-check" name="price" id="p1" autocomplete="off" checked>
                        <label class="btn btn-outline-secondary rounded-pill btn-sm" for="p1">Tất cả</label>

                        <input type="radio" class="btn-check" name="price" id="p2" autocomplete="off">
                        <label class="btn btn-outline-secondary rounded-pill btn-sm" for="p2">Dưới 5 triệu</label>

                        <input type="radio" class="btn-check" name="price" id="p3" autocomplete="off">
                        <label class="btn btn-outline-secondary rounded-pill btn-sm" for="p3">5 - 15 triệu</label>

                        <input type="radio" class="btn-check" name="price" id="p4" autocomplete="off">
                        <label class="btn btn-outline-secondary rounded-pill btn-sm" for="p4">Trên 15 triệu</label>
                    </div>
                </div>

                <!-- Brand Filter (Toggle switch style) -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">Thương Hiệu</h6>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="b1" checked>
                        <label class="form-check-label text-secondary" for="b1">Apple</label>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="b2">
                        <label class="form-check-label text-secondary" for="b2">Samsung</label>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="b3">
                        <label class="form-check-label text-secondary" for="b3">Sony</label>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="b4">
                        <label class="form-check-label text-secondary" for="b4">Xiaomi</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="col-lg-9">
            <!-- Toolbar -->
            <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded-4 shadow-sm border border-light">
                <span class="text-muted">Hiển thị <b>1-9</b> trên tổng số <b>120</b> sản phẩm</span>
                <div class="d-flex align-items-center gap-2">
                    <label class="text-nowrap text-muted">Sắp xếp:</label>
                    <select class="form-select border-0 bg-light rounded-pill px-3 shadow-none">
                        <option>Mới nhất</option>
                        <option>Giá tăng dần</option>
                        <option>Giá giảm dần</option>
                        <option>Bán chạy nhất</option>
                    </select>
                </div>
            </div>

            <!-- Grid -->
            <div class="row">
                <?php for($i=1; $i<=9; $i++): ?>
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="product-card h-100">
                        <div class="product-badge bg-danger">Mới</div>
                        <div class="product-image-wrap bg-light rounded-4">
                            <i class="bi bi-laptop text-secondary" style="font-size: 80px;"></i>
                        </div>
                        <div class="product-info mt-3">
                            <div class="d-flex text-warning mb-2 fs-6">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                                <span class="text-muted ms-2 small">(42)</span>
                            </div>
                            <h5 class="fw-bold mb-1 text-truncate">Laptop Gentech Ultra <?= $i ?></h5>
                            <p class="text-muted small mb-2">Intel Core i7 / 16GB RAM / 512GB SSD</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <span class="fs-5 fw-bold text-primary">18.500.000đ</span>
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

            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link border-0 shadow-sm rounded-circle me-2 icon-btn text-muted" href="#" tabindex="-1" aria-disabled="true"><i class="bi bi-chevron-left"></i></a>
                    </li>
                    <li class="page-item"><a class="page-link border-0 shadow-sm rounded-circle me-2 icon-btn text-dark fw-bold bg-white" href="#">1</a></li>
                    <li class="page-item active" aria-current="page">
                        <a class="page-link border-0 shadow-md rounded-circle me-2 icon-btn bg-primary text-white fw-bold" href="#">2</a>
                    </li>
                    <li class="page-item"><a class="page-link border-0 shadow-sm rounded-circle me-2 icon-btn text-dark fw-bold bg-white" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link border-0 shadow-sm rounded-circle icon-btn text-dark bg-white" href="#"><i class="bi bi-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
