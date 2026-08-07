<!-- Breadcrumb -->
<div class="container mt-4 pt-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="?action=/" class="text-decoration-none text-muted hover-primary">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="?action=products" class="text-decoration-none text-muted hover-primary">Điện thoại</a></li>
            <li class="breadcrumb-item"><a href="?action=products" class="text-decoration-none text-muted hover-primary">Apple</a></li>
            <li class="breadcrumb-item active text-dark fw-medium" aria-current="page">Gentech Pro Max M3</li>
        </ol>
    </nav>
</div>

<!-- Product Detail Core -->
<div class="container mt-4 mb-5 pb-5">
    <div class="row g-5">
        <!-- Image Gallery (Trái) -->
        <div class="col-lg-7" data-aos="fade-right">
            <div class="position-sticky" style="top: 100px;">
                <!-- Main Image -->
                <div class="rounded-4 overflow-hidden shadow-sm bg-white mb-3 position-relative" style="height: 600px;">
                    <!-- Nút Favorite -->
                    <button class="btn btn-light rounded-circle position-absolute top-0 end-0 m-4 shadow-sm" style="width: 45px; height: 45px; z-index: 10;">
                        <i class="bi bi-heart text-danger"></i>
                    </button>
                    <!-- ĐIỀN ĐƯỜNG DẪN ẢNH SẢN PHẨM CHÍNH VÀO ĐÂY -->
                    <img src="DUONG_DAN_ANH_CHITIET_CHINH.jpg" class="w-100 h-100 object-fit-contain p-5" alt="Gentech Pro Max M3">
                </div>
                <!-- Thumbnails -->
                <div class="row g-3">
                    <?php for($i=1; $i<=4; $i++): ?>
                    <div class="col-3">
                        <div class="rounded-3 overflow-hidden border <?= $i==1 ? 'border-primary border-2' : 'border-light' ?> bg-white cursor-pointer" style="height: 120px;">
                            <img src="DUONG_DAN_ANH_THUMBNAIL_<?= $i ?>.jpg" class="w-100 h-100 object-fit-contain p-3" alt="Thumb <?= $i ?>">
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>

        <!-- Product Info (Phải) -->
        <div class="col-lg-5" data-aos="fade-left">
            <div class="mb-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-danger rounded-pill px-3 py-2 fw-medium">Trả góp 0%</span>
                    <span class="badge bg-dark rounded-pill px-3 py-2 fw-medium">Mới ra mắt</span>
                </div>
                <h1 class="fw-bold mb-3" style="font-size: 2.5rem; letter-spacing: -1px; line-height: 1.2;">Gentech Pro Max M3 - 256GB Chính hãng VN/A</h1>
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="d-flex text-warning">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                    </div>
                    <a href="#reviews" class="text-muted text-decoration-none hover-primary">(452 đánh giá)</a>
                    <span class="text-muted">|</span>
                    <span class="text-success fw-medium"><i class="bi bi-check-circle-fill me-1"></i>Còn hàng</span>
                </div>
                <div class="mb-4">
                    <span class="fs-1 fw-bold text-dark me-3">34.990.000đ</span>
                    <span class="fs-5 text-muted text-decoration-line-through">38.990.000đ</span>
                </div>
            </div>

            <!-- Dung lượng -->
            <div class="mb-4 pt-3 border-top border-light">
                <h6 class="fw-bold mb-3">Dung lượng bộ nhớ</h6>
                <div class="d-flex gap-2 flex-wrap">
                    <input type="radio" class="btn-check" name="storage" id="storage1" autocomplete="off" checked>
                    <label class="btn btn-outline-dark px-4 py-2 rounded-3 border-gray-300" for="storage1">256GB</label>
                    
                    <input type="radio" class="btn-check" name="storage" id="storage2" autocomplete="off">
                    <label class="btn btn-outline-dark px-4 py-2 rounded-3 border-gray-300" for="storage2">512GB</label>
                    
                    <input type="radio" class="btn-check" name="storage" id="storage3" autocomplete="off">
                    <label class="btn btn-outline-dark px-4 py-2 rounded-3 border-gray-300" for="storage3">1TB</label>
                </div>
            </div>

            <!-- Màu sắc -->
            <div class="mb-5">
                <h6 class="fw-bold mb-3">Màu sắc: <span class="text-muted fw-normal">Titan Tự Nhiên</span></h6>
                <div class="d-flex gap-3">
                    <input type="radio" class="btn-check" name="color" id="color1" autocomplete="off" checked>
                    <label class="btn btn-outline-dark p-1 rounded-circle" for="color1" style="width: 40px; height: 40px; border-width: 2px;">
                        <div class="w-100 h-100 rounded-circle" style="background-color: #beb9b5;"></div>
                    </label>
                    
                    <input type="radio" class="btn-check" name="color" id="color2" autocomplete="off">
                    <label class="btn btn-outline-dark p-1 rounded-circle border-gray-300" for="color2" style="width: 40px; height: 40px;">
                        <div class="w-100 h-100 rounded-circle" style="background-color: #2c2c2e;"></div>
                    </label>
                    
                    <input type="radio" class="btn-check" name="color" id="color3" autocomplete="off">
                    <label class="btn btn-outline-dark p-1 rounded-circle border-gray-300" for="color3" style="width: 40px; height: 40px;">
                        <div class="w-100 h-100 rounded-circle" style="background-color: #f5f5f7;"></div>
                    </label>
                </div>
            </div>

            <!-- Khuyến mãi Box -->
            <div class="bg-gray-100 rounded-4 p-4 mb-5 border border-gray-200">
                <h6 class="fw-bold mb-3 text-danger"><i class="bi bi-gift-fill me-2"></i>Ưu đãi nổi bật</h6>
                <ul class="list-unstyled mb-0 ms-1 text-dark">
                    <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i>Giảm thêm 1.500.000đ khi thanh toán qua thẻ tín dụng VIB/HSBC.</li>
                    <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i>Thu cũ đổi mới: Trợ giá thêm lên đến 2.000.000đ.</li>
                    <li><i class="bi bi-check2-circle text-success me-2"></i>Tặng gói bảo hành VIP Gentech Care 24 tháng.</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <button class="btn btn-premium-gradient w-100 py-3 d-flex flex-column align-items-center justify-content-center">
                        <span class="fs-5">MUA NGAY</span>
                        <small class="fw-normal" style="font-size: 0.85rem; opacity: 0.9;">Giao hàng miễn phí tận nơi</small>
                    </button>
                </div>
                <div class="col-6">
                    <button class="btn btn-outline-primary w-100 rounded-pill py-2 fw-bold hover-elevate">
                        TRẢ GÓP 0%
                        <small class="d-block fw-normal" style="font-size: 0.75rem;">Duyệt hồ sơ trong 5 phút</small>
                    </button>
                </div>
                <div class="col-6">
                    <button class="btn btn-outline-primary w-100 rounded-pill py-2 fw-bold hover-elevate">
                        TRẢ GÓP QUA THẺ
                        <small class="d-block fw-normal" style="font-size: 0.75rem;">Visa, Mastercard, JCB</small>
                    </button>
                </div>
            </div>
            
            <button class="btn btn-light border w-100 rounded-pill py-3 fw-bold text-dark hover-elevate shadow-sm"><i class="bi bi-cart-plus me-2 fs-5 align-middle"></i>THÊM VÀO GIỎ HÀNG</button>
        </div>
    </div>
</div>

<!-- Specs & Description -->
<div class="bg-white border-top py-5">
    <div class="container py-4">
        <div class="row g-5">
            <!-- Bài viết mô tả -->
            <div class="col-lg-8" data-aos="fade-up">
                <h3 class="fw-bold mb-4">Đặc điểm nổi bật</h3>
                <div class="content-article text-muted" style="line-height: 1.8;">
                    <p class="fs-5 text-dark mb-4 fw-medium">Gentech Pro Max M3 đại diện cho đỉnh cao thiết kế và công nghệ, mang đến hiệu năng đột phá nhờ con chip xử lý thế hệ mới, cùng hệ thống camera chuyên nghiệp chưa từng có.</p>
                    <img src="DUONG_DAN_ANH_MOTA_1.jpg" alt="Mô tả" class="img-fluid rounded-4 mb-4 w-100 bg-light" style="min-height: 400px; object-fit: cover;">
                    <h5 class="fw-bold text-dark mt-5 mb-3">Thiết kế viền Titan chuẩn hàng không vũ trụ</h5>
                    <p>Khung viền được chế tác từ Titanium Grade 5, mang lại độ bền vượt trội nhưng vẫn giữ được trọng lượng siêu nhẹ. Cảm giác cầm nắm đầm tay, viền màn hình mỏng nhất từ trước đến nay tạo nên không gian trải nghiệm hình ảnh vô cực.</p>
                    <h5 class="fw-bold text-dark mt-5 mb-3">Hiệu năng không đối thủ</h5>
                    <p>Chip M3 Pro mang kiến trúc GPU hoàn toàn mới, hỗ trợ Ray Tracing bằng phần cứng giúp chiến mượt mọi tựa game AAA. Khả năng xử lý đồ họa tăng gấp đôi so với thế hệ tiền nhiệm, đi kèm công nghệ tiết kiệm năng lượng tiên tiến.</p>
                </div>
                <div class="text-center mt-4">
                    <button class="btn btn-outline-dark rounded-pill px-5 py-2 fw-bold">Xem thêm nội dung <i class="bi bi-chevron-down ms-2"></i></button>
                </div>
            </div>
            
            <!-- Thông số kỹ thuật -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-gray-100 rounded-4 p-4 border border-gray-200">
                    <h4 class="fw-bold mb-4">Thông số kỹ thuật</h4>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex py-3 border-bottom border-gray-300">
                            <span class="text-muted w-50">Màn hình:</span>
                            <span class="text-dark fw-medium w-50">6.7" Super Retina XDR OLED, 120Hz</span>
                        </li>
                        <li class="d-flex py-3 border-bottom border-gray-300">
                            <span class="text-muted w-50">Hệ điều hành:</span>
                            <span class="text-dark fw-medium w-50">GenOS 18</span>
                        </li>
                        <li class="d-flex py-3 border-bottom border-gray-300">
                            <span class="text-muted w-50">Camera sau:</span>
                            <span class="text-dark fw-medium w-50">Chính 48MP & Phụ 12MP, 12MP</span>
                        </li>
                        <li class="d-flex py-3 border-bottom border-gray-300">
                            <span class="text-muted w-50">Camera trước:</span>
                            <span class="text-dark fw-medium w-50">12MP</span>
                        </li>
                        <li class="d-flex py-3 border-bottom border-gray-300">
                            <span class="text-muted w-50">Chip:</span>
                            <span class="text-dark fw-medium w-50">M3 Pro Bionic 3nm</span>
                        </li>
                        <li class="d-flex py-3 border-bottom border-gray-300">
                            <span class="text-muted w-50">RAM:</span>
                            <span class="text-dark fw-medium w-50">8 GB</span>
                        </li>
                        <li class="d-flex py-3 border-bottom border-gray-300">
                            <span class="text-muted w-50">Dung lượng lưu trữ:</span>
                            <span class="text-dark fw-medium w-50">256 GB</span>
                        </li>
                        <li class="d-flex py-3 pt-4">
                            <button class="btn btn-outline-dark w-100 rounded-pill fw-bold">Xem cấu hình chi tiết</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
<div class="container py-5 my-5">
    <div class="d-flex justify-content-between align-items-end mb-5" data-aos="fade-up">
        <div>
            <h2 class="fw-bold mb-2" style="font-size: 2.2rem; letter-spacing: -1px;">Sản Phẩm Tương Tự</h2>
            <p class="text-muted fs-5 mb-0">Các lựa chọn khác có thể bạn sẽ quan tâm.</p>
        </div>
        <a href="#" class="text-primary text-decoration-none fw-bold fs-5 d-none d-md-block">Xem tất cả <i class="bi bi-arrow-right ms-2"></i></a>
    </div>
    
    <div class="row g-4">
        <!-- Render 4 mock products -->
        <?php for($i=1; $i<=4; $i++): ?>
        <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
            <div class="product-card-premium h-100 d-flex flex-column">
                <div class="position-absolute top-0 end-0 m-3 z-3">
                    <div class="product-badge bg-danger shadow-sm px-3 py-1 rounded-pill text-white fw-bold" style="font-size:0.8rem;">-10%</div>
                </div>
                <div class="card-img-wrap bg-light border-bottom" style="border-color:#f1f5f9 !important;">
                    <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=2080&auto=format&fit=crop" alt="iPhone 15 Pro Max">
                    <button class="btn-quick-add hover-elevate">Thêm vào giỏ</button>
                </div>
                <div class="product-info p-4 flex-grow-1 d-flex flex-column">
                    <p class="text-muted small fw-bold mb-1">APPLE</p>
                    <h5 class="fw-bold mb-3 product-title text-truncate">iPhone 15 Pro Max 256GB</h5>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-bold fs-5 text-dark d-block">29.990.000đ</span>
                            <span class="text-muted text-decoration-line-through small">34.990.000đ</span>
                        </div>
                        <button class="btn btn-light rounded-circle icon-btn hover-elevate shadow-sm" style="width: 40px; height: 40px; display:flex; align-items:center; justify-content:center; border:1px solid #e2e8f0;">
                            <i class="bi bi-cart-plus fs-5 text-primary"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endfor; ?>
    </div>
</div>
