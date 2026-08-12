<!-- Hero Parallax Section -->
<div class="container-fluid px-4 mt-3" data-aos="fade-up">
    <div class="hero-parallax-slider shadow-lg">
        <?php if (!empty($heroBanners)): ?>
            <?php foreach ($heroBanners as $index => $banner): ?>
                <div class="hero-parallax-item <?= $index === 0 ? 'active' : '' ?>">
                    <div class="hero-parallax-bg" style="background-image: url('<?= BASE_URL ?>assets/uploads/banner/<?= $banner['image_url'] ?>');"></div>
                    <div class="hero-parallax-overlay"></div>
                    <div class="hero-parallax-content">
                        <!-- Tùy chọn hiển thị text (nếu muốn, có thể lưu thêm mô tả vào bảng banners) -->
                        <span class="badge bg-primary rounded-pill px-3 py-2 mb-4 fs-6 shadow-sm border border-light border-opacity-25" data-aos="fade-up" data-aos-delay="200"><?= htmlspecialchars($banner['title']) ?></span>
                        <!-- Nút bấm với link động -->
                        <div class="d-flex gap-3 mt-4">
                            <?php if (!empty($banner['link'])): ?>
                                <a href="<?= htmlspecialchars($banner['link']) ?>" class="btn btn-primary rounded-pill px-5 py-3 fw-bold fs-6 shadow-sm hover-elevate border-0" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">Khám Phá Ngay</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Fallback nếu không có banner nào -->
            <div class="hero-parallax-item active">
                <div class="hero-parallax-bg" style="background-image: url('https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?q=80&w=2070&auto=format&fit=crop');"></div>
                <div class="hero-parallax-overlay"></div>
                <div class="hero-parallax-content">
                    <span class="badge bg-primary rounded-pill px-3 py-2 mb-4 fs-6 shadow-sm border border-light border-opacity-25" data-aos="fade-up" data-aos-delay="200">GENTECH</span>
                    <h1 class="display-3 fw-bold mb-4 text-white" style="letter-spacing: -2px;">SẢN PHẨM <span class="text-primary">CHÍNH HÃNG</span></h1>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Script to rotate slides (simulated for now, would be handled by JS) -->
        <script>
            // Basic parallax slider script
            document.addEventListener('DOMContentLoaded', function() {
                const slider = document.querySelector('.hero-parallax-slider');
                if(!slider) return;
                // Add more slides dynamically or handle in PHP
            });
        </script>
    </div>
</div>

<!-- Categories -->
<div class="container mt-5 pt-5">
    <div class="text-center mb-5" data-aos="fade-up">
        <h2 class="fw-bold mb-3" style="font-size: 2.5rem; letter-spacing: -1px;">Khám Phá Danh Mục</h2>
        <p class="text-muted fs-5">Lựa chọn sản phẩm phù hợp với nhu cầu của bạn.</p>
    </div>
    <div class="row justify-content-center">
        <?php if (!empty($homeCategories)): ?>
            <?php foreach ($homeCategories as $index => $cat): ?>
            <div class="col-6 col-md-3 col-lg-2 mb-4" data-aos="fade-up" data-aos-delay="<?= ($index % 5 + 1) * 100 ?>">
                <a href="<?= BASE_URL ?>?action=products&category_id=<?= $cat['category_id'] ?>" class="text-decoration-none text-dark category-item d-block">
                    <div class="category-box">
                        <?php if (!empty($cat['icon'])): ?>
                            <img src="<?= BASE_URL ?>assets/uploads/categories/<?= htmlspecialchars($cat['icon']) ?>" alt="<?= htmlspecialchars($cat['category_name']) ?>" style="height: 85px; width: auto; object-fit: contain; margin-bottom: 12px; transition: transform 0.3s ease;">
                        <?php else: ?>
                            <i class="bi bi-image text-muted" style="font-size: 2.5rem; display: block; margin-bottom: 12px;"></i>
                        <?php endif; ?>
                        <h6 class="mb-0 mt-2 text-dark" style="font-weight: 600; font-size: 0.95rem; letter-spacing: -0.3px;"><?= htmlspecialchars($cat['category_name']) ?></h6>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Latest Products -->
<div class="container mt-5 pt-5">
    <div class="text-center mb-5" data-aos="fade-up">
        <h2 class="fw-bold mb-2" style="font-size: 2.5rem; letter-spacing: -1px;">Sản Phẩm Mới Nhất</h2>
        <p class="text-muted fs-5 mb-0">Những công nghệ đột phá vừa ra mắt.</p>
    </div>
    
    <div class="row">
        <?php if (!empty($latestProducts)): ?>
            <?php foreach($latestProducts as $index => $product): 
                $img = $product['image'] ?? '';
                $imgUrl = !empty($img) ? (str_starts_with($img, 'http') ? $img : BASE_URL . 'assets/uploads/' . $img) : 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?q=80&w=2071&auto=format&fit=crop';
            ?>
            <div class="col-sm-6 col-lg-3 mb-5" data-aos="fade-up" data-aos-delay="<?= ($index % 4 + 1) * 100 ?>">
                <div class="product-card-premium h-100 d-flex flex-column position-relative overflow-hidden">
                    <div class="card-img-wrap bg-light position-relative">
                        <a href="<?= BASE_URL ?>?action=product-detail&id=<?= $product['product_id'] ?? 0 ?>" class="d-block w-100 h-100" style="padding: 1rem;">
                            <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($product['product_name'] ?? 'Product') ?>" style="object-fit: contain; width: 100%; height: 220px; transition: transform 0.5s ease;" class="product-img-main">
                        </a>
                        <div style="position: absolute; top: 12px; right: 12px; z-index: 10;">
                            <span class="badge bg-danger shadow-sm px-3 py-2 rounded-pill fw-bold" style="font-size:0.75rem; letter-spacing: 1px;"><i class="bi bi-stars"></i> MỚI</span>
                        </div>
                        
                        <!-- Premium Hover Overlay -->
                        <div class="premium-hover-overlay">
                            <form action="?action=cart-add" method="POST" class="ajax-add-to-cart-form w-100 px-3">
                                <input type="hidden" name="variant_id" value="<?= htmlspecialchars($product['default_variant_id'] ?? 0) ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" name="action_type" value="add_to_cart" class="btn btn-dark w-100 rounded-pill py-3 fw-bold btn-premium-add shadow-lg d-flex justify-content-center align-items-center gap-2">
                                    <i class="bi bi-cart-plus fs-5"></i> THÊM VÀO GIỎ
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="product-info p-4 flex-grow-1 d-flex flex-column bg-white">
                        <div class="d-flex text-warning mb-2" style="font-size:0.8rem;">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <a href="<?= BASE_URL ?>?action=product-detail&id=<?= $product['product_id'] ?? 0 ?>" class="text-decoration-none text-dark">
                            <h5 class="fw-bold mb-2 text-truncate text-dark hover-primary" style="font-size:1.1rem; letter-spacing: -0.3px;"><?= htmlspecialchars($product['product_name'] ?? 'Tên sản phẩm') ?></h5>
                        </a>
                        <p class="text-muted mb-3 text-uppercase fw-semibold" style="font-size: 0.75rem; letter-spacing: 1px;"><?= htmlspecialchars($product['category_name'] ?? 'Danh mục') ?></p>
                        <div class="mt-auto d-flex justify-content-between align-items-end">
                            <div>
                                <span class="fw-bold text-dark" style="font-size: 1.3rem;"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center text-muted">
                <p>Không có sản phẩm nào để hiển thị.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Banner Khuyến Mãi -->
<div class="container mt-5 pt-5">
    <div class="row g-4">
        <?php if (!empty($promoBanners)): ?>
            <?php foreach ($promoBanners as $index => $banner): ?>
                <div class="col-md-6" data-aos="<?= $index % 2 == 0 ? 'fade-right' : 'fade-left' ?>">
                    <a href="<?= !empty($banner['link']) ? htmlspecialchars($banner['link']) : '#' ?>" class="d-block rounded-4 overflow-hidden shadow-sm hover-zoom">
                        <img src="<?= BASE_URL ?>assets/uploads/banner/<?= $banner['image_url'] ?>" alt="<?= htmlspecialchars($banner['title']) ?>" class="img-fluid w-100 rounded-4" style="height:250px; object-fit:cover;">
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Fallback tĩnh nếu admin chưa thêm banner -->
            <div class="col-md-6" data-aos="fade-right">
                <a href="#" class="d-block rounded-4 overflow-hidden shadow-sm hover-zoom">
                    <img src="<?= BASE_URL ?>assets/uploads/banner/bannersale1.jpg" alt="Banner Khuyến Mãi 1" class="img-fluid w-100 rounded-4" style="height:250px; object-fit:cover;">
                </a>
            </div>
            <div class="col-md-6" data-aos="fade-left">
                <a href="#" class="d-block rounded-4 overflow-hidden shadow-sm hover-zoom">
                    <img src="<?= BASE_URL ?>assets/uploads/banner/bannersale2.jpg" alt="Banner Khuyến Mãi 2" class="img-fluid w-100 rounded-4" style="height:250px; object-fit:cover;">
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Best Sellers -->
<div class="container mt-5 pt-5 mb-5">
    <div class="text-center mb-5" data-aos="fade-up">
        <h2 class="fw-bold mb-2" style="font-size: 2.5rem; letter-spacing: -1px;">Bán Chạy Nhất</h2>
        <p class="text-muted fs-5 mb-0">Các sản phẩm được yêu thích nhất tháng này.</p>
    </div>
    
    <div class="row">
        <?php if (!empty($bestSellers)): ?>
            <?php foreach($bestSellers as $index => $product): 
                $img = $product['image'] ?? '';
                $imgUrl = !empty($img) ? (str_starts_with($img, 'http') ? $img : BASE_URL . 'assets/uploads/' . $img) : 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=2080&auto=format&fit=crop';
            ?>
            <div class="col-sm-6 col-lg-3 mb-5" data-aos="fade-up" data-aos-delay="<?= ($index % 4 + 1) * 100 ?>">
                <div class="product-card-premium h-100 d-flex flex-column position-relative overflow-hidden">
                    <div class="card-img-wrap bg-light position-relative">
                        <a href="<?= BASE_URL ?>?action=product-detail&id=<?= $product['product_id'] ?? 0 ?>" class="d-block w-100 h-100" style="padding: 1rem;">
                            <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($product['product_name'] ?? 'Product') ?>" style="object-fit: contain; width: 100%; height: 220px; transition: transform 0.5s ease;" class="product-img-main">
                        </a>
                        <div style="position: absolute; top: 12px; right: 12px; z-index: 10;">
                            <span class="badge bg-dark shadow-sm px-3 py-2 rounded-pill fw-bold" style="font-size:0.75rem; letter-spacing: 1px;"><i class="bi bi-fire text-warning"></i> BÁN CHẠY</span>
                        </div>
                        
                        <!-- Premium Hover Overlay -->
                        <div class="premium-hover-overlay">
                            <form action="?action=cart-add" method="POST" class="ajax-add-to-cart-form w-100 px-3">
                                <input type="hidden" name="variant_id" value="<?= htmlspecialchars($product['default_variant_id'] ?? 0) ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" name="action_type" value="add_to_cart" class="btn btn-dark w-100 rounded-pill py-3 fw-bold btn-premium-add shadow-lg d-flex justify-content-center align-items-center gap-2">
                                    <i class="bi bi-cart-plus fs-5"></i> THÊM VÀO GIỎ
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="product-info p-4 flex-grow-1 d-flex flex-column bg-white">
                        <div class="d-flex text-warning mb-2" style="font-size:0.8rem;">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <a href="<?= BASE_URL ?>?action=product-detail&id=<?= $product['product_id'] ?? 0 ?>" class="text-decoration-none text-dark">
                            <h5 class="fw-bold mb-2 text-truncate text-dark hover-primary" style="font-size:1.1rem; letter-spacing: -0.3px;"><?= htmlspecialchars($product['product_name'] ?? 'Tên sản phẩm') ?></h5>
                        </a>
                        <p class="text-muted mb-3 text-uppercase fw-semibold" style="font-size: 0.75rem; letter-spacing: 1px;"><?= htmlspecialchars($product['category_name'] ?? 'Danh mục') ?></p>
                        <div class="mt-auto d-flex justify-content-between align-items-end">
                            <div>
                                <span class="fw-bold text-dark" style="font-size: 1.3rem;"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</span>
                            </div>
                            <button class="btn btn-light rounded-circle icon-btn hover-elevate shadow-sm" style="width: 40px; height: 40px; display:flex; align-items:center; justify-content:center; border:1px solid #e2e8f0;">
                                <i class="bi bi-heart text-danger"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center text-muted">
                <p>Không có sản phẩm nào để hiển thị.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
