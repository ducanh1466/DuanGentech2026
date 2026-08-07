<!-- News Header -->
<div class="container mt-4" data-aos="fade-up">
    <div class="hero-section text-center d-flex flex-column align-items-center justify-content-center" style="padding: 4rem 2rem;">
        <h1 class="hero-title mb-3" data-aos="fade-up" data-aos-delay="100" style="font-size: 4rem;">Tin Tức & <span class="text-primary">Sự Kiện</span></h1>
        <p class="hero-subtitle mx-auto" data-aos="fade-up" data-aos-delay="200" style="max-width: 600px;">Cập nhật những xu hướng công nghệ mới nhất và các tin tức nổi bật từ Gentech.</p>
    </div>
</div>

<!-- Featured News -->
<div class="container mt-5 pt-4">
    <div class="row g-4 align-items-center">
        <div class="col-lg-7" data-aos="fade-right">
            <a href="#" class="d-block rounded-4 overflow-hidden shadow-soft hover-zoom position-relative">
                <!-- ĐIỀN ĐƯỜNG DẪN ẢNH TIN TỨC NỔI BẬT VÀO ĐÂY -->
                <img src="DUONG_DAN_ANH_TIN_TUC_NOI_BAT.jpg" alt="Tin tức nổi bật" class="w-100 img-fluid" style="object-fit: cover; min-height: 400px; background-color: #f1f5f9;">
                <div class="position-absolute top-0 start-0 m-4">
                    <span class="badge bg-primary px-3 py-2 fs-6 rounded-pill">Mới nhất</span>
                </div>
            </a>
        </div>
        <div class="col-lg-5" data-aos="fade-left">
            <p class="text-muted fw-medium mb-2">Công nghệ • 12 Tháng 8, 2026</p>
            <h2 class="fw-bold mb-3" style="letter-spacing: -1px; line-height: 1.3;">Apple ra mắt dòng sản phẩm mới với chip M4 cực kỳ mạnh mẽ</h2>
            <p class="text-muted fs-5 mb-4">Sự kiện thường niên của gã khổng lồ công nghệ đã đem đến vô số bất ngờ với dòng vi xử lý kiến trúc hoàn toàn mới, hứa hẹn hiệu năng đột phá cho dân chuyên nghiệp.</p>
            <a href="#" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-bold">Đọc tiếp <i class="bi bi-arrow-right ms-2"></i></a>
        </div>
    </div>
</div>

<!-- News Grid -->
<div class="container mt-5 pt-5 mb-5">
    <div class="row g-5">
        <?php for($i=1; $i<=6; $i++): ?>
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
            <div class="product-card p-0 overflow-hidden d-flex flex-column h-100">
                <a href="#" class="d-block overflow-hidden" style="height: 220px; background-color: #f1f5f9;">
                    <!-- ĐIỀN ĐƯỜNG DẪN ẢNH TIN TỨC VÀO ĐÂY -->
                    <img src="DUONG_DAN_ANH_TIN_TUC_<?= $i ?>.jpg" alt="Tin tức <?= $i ?>" class="w-100 h-100" style="object-fit: cover; transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                </a>
                <div class="p-4 d-flex flex-column flex-grow-1">
                    <p class="text-muted small fw-medium mb-2">Đánh giá • 10 Tháng 8, 2026</p>
                    <h5 class="fw-bold mb-3" style="line-height: 1.4;">Top 5 Laptop mỏng nhẹ đáng mua nhất dành cho dân văn phòng năm 2026</h5>
                    <p class="text-muted mb-4 flex-grow-1" style="font-size: 0.95rem;">Lựa chọn một chiếc laptop vừa mỏng nhẹ, pin trâu lại có thiết kế đẹp chưa bao giờ là dễ dàng. Cùng Gentech điểm qua...</p>
                    <div>
                        <a href="#" class="text-primary fw-bold text-decoration-none">Đọc chi tiết <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <?php endfor; ?>
    </div>
    
    <!-- Pagination -->
    <div class="mt-5 d-flex justify-content-center" data-aos="fade-up">
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
