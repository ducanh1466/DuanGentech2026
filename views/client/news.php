<!-- News Header & Pill Nav -->
<div class="container mt-3 pt-3" data-aos="fade-up">
    <div class="text-center mb-3">
        <h1 class="fw-bold mb-2" style="font-size: 2.5rem; letter-spacing: -1px;">Tin Tức & <span class="text-primary">Góc Nhìn</span></h1>
        <p class="text-muted fs-6 mx-auto" style="max-width: 600px;">Khám phá thế giới công nghệ qua lăng kính chuyên sâu của Gentech.</p>
    </div>
    
    <!-- Pill Navigation (Sticky) -->
    <div class="d-flex justify-content-center flex-wrap gap-2 mb-4 sticky-top bg-white py-2" style="z-index: 1020;">
        <a href="?action=news" class="btn btn-dark rounded-pill px-3 py-1 shadow-sm fs-6">Tất cả</a>
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $cat): ?>
                <a href="?action=news&category=<?= htmlspecialchars($cat['slug']) ?>" class="btn btn-outline-secondary rounded-pill px-3 py-1 border-0 bg-light text-dark fw-medium btn-pill-hover fs-6">
                    <?= htmlspecialchars($cat['name']) ?>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Asymmetrical Editorial Layout -->
<div class="container mb-5 pb-4">
    <?php if (!empty($featuredNews)): ?>
    <!-- Featured Hero Article -->
    <div class="row mb-4" data-aos="fade-up">
        <div class="col-12">
            <a href="?action=news-detail&slug=<?= htmlspecialchars($featuredNews['slug']) ?>" class="card text-white border-0 rounded-4 overflow-hidden editorial-card featured-card shadow-lg d-block text-decoration-none">
                <img src="<?= htmlspecialchars($featuredNews['image_url'] ?? 'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?q=80&w=1200&auto=format&fit=crop') ?>" class="card-img h-100 object-fit-cover parallax-img" data-speed="0.1" alt="<?= htmlspecialchars($featuredNews['title']) ?>">
                <div class="card-img-overlay d-flex flex-column justify-content-end p-3 p-md-4" style="background: linear-gradient(to top, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0.4) 50%, transparent 100%);">
                    <div class="editorial-content">
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                            <span class="badge bg-primary px-2 py-1 rounded-pill" style="font-size: 0.8rem;">Tâm điểm</span>
                            <?php if ($featuredNews['category_name']): ?>
                                <span class="badge bg-light text-dark px-2 py-1 rounded-pill" style="font-size: 0.8rem;"><?= htmlspecialchars($featuredNews['category_name']) ?></span>
                            <?php endif; ?>
                            <span class="text-light fw-medium" style="font-size: 0.85rem;"><i class="bi bi-calendar3 me-1"></i> <?= date('d/m/Y', strtotime($featuredNews['created_at'])) ?></span>
                            <span class="text-light fw-medium" style="font-size: 0.85rem;"><i class="bi bi-eye me-1"></i> <?= number_format($featuredNews['views']) ?></span>
                        </div>
                        <h2 class="card-title fw-bold mb-2 fs-3" style="letter-spacing: -0.5px; line-height: 1.3;"><?= htmlspecialchars($featuredNews['title']) ?></h2>
                        <p class="card-text text-gray-300 mb-3 d-none d-md-block" style="max-width: 800px; font-size: 0.95rem; line-height: 1.5;"><?= htmlspecialchars($featuredNews['summary']) ?></p>
                        <div class="read-more-btn fw-bold text-white d-inline-flex align-items-center gap-2" style="font-size: 0.9rem;">Đọc bài viết <i class="bi bi-arrow-right"></i></div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Standard Grid Cards -->
    <div class="row g-4">
        <?php if (!empty($activeNews)): ?>
            <?php foreach($activeNews as $index => $item): ?>
                <?php 
                    // Dynamic rendering to make the layout asymmetrical just like before
                    // First item is large left, second is small right, rest are standard grid
                    if ($index == 0 && count($activeNews) > 1): 
                ?>
                    <!-- Card 1 (Large left) -->
                    <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                        <a href="?action=news-detail&slug=<?= htmlspecialchars($item['slug']) ?>" class="card border-0 rounded-4 overflow-hidden editorial-card shadow-sm h-100 d-block text-decoration-none bg-dark">
                            <div class="position-relative overflow-hidden h-100" style="min-height: 300px;">
                                <img src="<?= htmlspecialchars($item['image_url'] ?? 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?q=80&w=800&auto=format&fit=crop') ?>" class="w-100 h-100 object-fit-cover position-absolute" alt="<?= htmlspecialchars($item['title']) ?>">
                                <?php if ($item['category_name']): ?>
                                <div class="position-absolute top-0 start-0 m-3 z-1">
                                    <span class="badge bg-dark bg-opacity-75 px-2 py-1 rounded-pill" style="font-size: 0.75rem;"><?= htmlspecialchars($item['category_name']) ?></span>
                                </div>
                                <?php endif; ?>
                                <div class="editorial-overlay p-3 p-md-4 d-flex flex-column justify-content-end text-white z-1">
                                    <div class="editorial-reveal">
                                        <h4 class="fw-bold mb-2 fs-5" style="line-height: 1.3;"><?= htmlspecialchars($item['title']) ?></h4>
                                        <p class="mb-2 text-gray-300 d-none d-md-block" style="font-size: 0.85rem; line-height: 1.4;"><?= htmlspecialchars($item['summary']) ?></p>
                                        <span class="fw-bold text-primary" style="font-size: 0.85rem;">Khám phá ngay <i class="bi bi-arrow-right"></i></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php elseif ($index == 1): ?>
                    <!-- Card 2 (Small right) -->
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                        <a href="?action=news-detail&slug=<?= htmlspecialchars($item['slug']) ?>" class="card border-0 rounded-4 overflow-hidden editorial-card shadow-sm h-100 d-block text-decoration-none bg-dark">
                            <div class="position-relative overflow-hidden h-100" style="min-height: 300px;">
                                <img src="<?= htmlspecialchars($item['image_url'] ?? 'https://images.unsplash.com/photo-1505156868547-9b49f4df4e04?q=80&w=600&auto=format&fit=crop') ?>" class="w-100 h-100 object-fit-cover position-absolute" alt="<?= htmlspecialchars($item['title']) ?>">
                                <?php if ($item['category_name']): ?>
                                <div class="position-absolute top-0 start-0 m-3 z-1">
                                    <span class="badge bg-dark bg-opacity-75 px-2 py-1 rounded-pill" style="font-size: 0.75rem;"><?= htmlspecialchars($item['category_name']) ?></span>
                                </div>
                                <?php endif; ?>
                                <div class="editorial-overlay p-3 p-md-4 d-flex flex-column justify-content-end text-white z-1">
                                    <div class="editorial-reveal">
                                        <h5 class="fw-bold mb-2 text-truncate" style="line-height: 1.3; font-size: 1rem;"><?= htmlspecialchars($item['title']) ?></h5>
                                        <p class="mb-2 text-gray-300 d-none d-md-block" style="font-size: 0.85rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?= htmlspecialchars($item['summary']) ?></p>
                                        <span class="fw-bold text-primary" style="font-size: 0.85rem;">Đọc thêm <i class="bi bi-arrow-right"></i></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Standard Card -->
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= ($index % 3 + 1) * 100 ?>">
                        <a href="?action=news-detail&slug=<?= htmlspecialchars($item['slug']) ?>" class="card border-0 rounded-4 overflow-hidden editorial-card shadow-sm h-100 d-block text-decoration-none">
                            <div class="position-relative overflow-hidden bg-light" style="height: 200px;">
                                <img src="<?= htmlspecialchars($item['image_url'] ?? 'https://images.unsplash.com/photo-1595225476474-87563907a212?q=80&w=600&auto=format&fit=crop') ?>" class="w-100 h-100 object-fit-cover" alt="<?= htmlspecialchars($item['title']) ?>">
                                <?php if ($item['category_name']): ?>
                                <div class="position-absolute top-0 start-0 m-3 z-1">
                                    <span class="badge bg-dark bg-opacity-75 px-2 py-1 rounded-pill" style="font-size: 0.75rem;"><?= htmlspecialchars($item['category_name']) ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="p-3 bg-white d-flex flex-column h-100">
                                <h6 class="fw-bold mb-2 text-dark" style="line-height: 1.4; font-size: 0.95rem;"><?= htmlspecialchars($item['title']) ?></h6>
                                <p class="text-muted mb-3 flex-grow-1" style="font-size: 0.85rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;"><?= htmlspecialchars($item['summary']) ?></p>
                                <span class="text-primary fw-bold read-more-btn" style="font-size: 0.85rem;">Đọc chi tiết <i class="bi bi-arrow-right ms-1"></i></span>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-journal-x text-muted mb-3 d-block" style="font-size: 3rem;"></i>
                <h4 class="text-muted">Chưa có bài viết nào được xuất bản.</h4>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Newsletter Glassmorphism Section -->
<div class="container mb-5 pb-5">
    <div class="rounded-4 overflow-hidden position-relative p-4 p-md-5 shadow-float" data-aos="fade-up" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
        <!-- Abstract glowing shapes behind glass -->
        <div class="position-absolute" style="width: 250px; height: 250px; background: rgba(0, 113, 227, 0.25); filter: blur(60px); top: -50px; right: 5%; border-radius: 50%; z-index: 0;"></div>
        <div class="position-absolute" style="width: 250px; height: 250px; background: rgba(236, 72, 153, 0.15); filter: blur(60px); bottom: -50px; left: 5%; border-radius: 50%; z-index: 0;"></div>
        
        <div class="glass-newsletter mx-auto p-4 rounded-4 border position-relative z-1 text-center shadow-sm" style="max-width: 600px; background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-color: rgba(255,255,255,0.8);">
            <i class="bi bi-envelope-paper text-primary mb-2 d-block" style="font-size: 2rem;"></i>
            <h4 class="fw-bold mb-2" style="letter-spacing: -0.5px;">Đừng bỏ lỡ nhịp đập công nghệ</h4>
            <p class="text-muted fs-6 mb-3 mx-auto" style="max-width: 450px;">Đăng ký nhận bản tin hàng tuần từ Gentech để cập nhật các bài viết mới nhất và ưu đãi độc quyền.</p>
            
            <form class="d-flex flex-column flex-sm-row gap-2 mx-auto" style="max-width: 450px;">
                <input type="email" class="form-control rounded-pill px-3 py-2 bg-white border-0 shadow-sm flex-grow-1" style="font-size: 0.9rem;" placeholder="Nhập địa chỉ email của bạn..." required>
                <button type="submit" class="btn btn-primary rounded-pill px-3 py-2 fw-bold shadow-sm" style="min-width: 100px; font-size: 0.9rem;">Đăng ký</button>
            </form>
        </div>
    </div>
</div>
