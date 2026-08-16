<!-- Hero Parallax Section -->
<div class="container-fluid px-4 mt-3" data-aos="fade-up">
    <div class="hero-parallax-slider shadow-lg">
        <?php if (!empty($heroBanners)): ?>
            <?php foreach ($heroBanners as $index => $banner): ?>
                <div class="hero-parallax-item <?= $index === 0 ? 'active' : '' ?>">
                    <div class="hero-parallax-bg" style="background-image: url('<?= BASE_URL ?>assets/uploads/banner/<?= $banner['image_url'] ?>');"></div>
                    <div class="hero-parallax-overlay"></div>
                    <div class="hero-parallax-content d-flex flex-column align-items-center justify-content-center h-100">
                        <div class="p-5 rounded-4 text-center mx-3" style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.3); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3); max-width: 800px; transform: translateY(20px); animation: fadeInUp 1s ease forwards;">
                            <span class="badge bg-white text-primary rounded-pill px-4 py-2 mb-4 fw-bold text-uppercase tracking-wider" style="letter-spacing: 2px; font-size: 0.85rem;" data-aos="fade-up" data-aos-delay="100">Khám Phá Kỷ Nguyên Mới</span>
                            
                            <h1 class="display-3 fw-bolder mb-4 text-white text-shadow-sm" style="line-height: 1.2; letter-spacing: -1px;" data-aos="fade-up" data-aos-delay="200">
                                <?= htmlspecialchars($banner['title']) ?>
                            </h1>
                            
                            <p class="lead text-white mb-5 opacity-75 mx-auto" style="max-width: 600px; font-size: 1.15rem;" data-aos="fade-up" data-aos-delay="300">
                                Trải nghiệm đỉnh cao công nghệ cùng Gentech. Sự hoàn hảo đến từ những chi tiết nhỏ nhất.
                            </p>
                            
                            <!-- Nút bấm với link động -->
                            <div class="d-flex gap-3 justify-content-center" data-aos="fade-up" data-aos-delay="400">
                                <?php if (!empty($banner['link'])): ?>
                                    <a href="<?= htmlspecialchars($banner['link']) ?>" class="btn btn-light text-primary rounded-pill px-5 py-3 fw-bold fs-6 shadow-lg hover-scale transition-all d-flex align-items-center gap-2">
                                        Khám Phá Ngay <i class="bi bi-arrow-right"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
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

<!-- Flash Sale Section -->
<div class="container mt-5 pt-4">
    <div class="p-4 rounded-4 position-relative overflow-hidden shadow-lg" style="background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);">
        <!-- Decorative elements -->
        <div class="position-absolute opacity-25" style="top: -20px; right: -20px;">
            <i class="bi bi-lightning-charge-fill text-white" style="font-size: 10rem;"></i>
        </div>
        
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between position-relative z-1 gap-4">
            <div class="text-white d-flex align-items-center gap-3">
                <div class="bg-white text-danger rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 60px; height: 60px; font-size: 1.5rem;">
                    <i class="bi bi-lightning-fill"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-1" style="letter-spacing: -1px; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">DEAL CHỚP NHOÁNG</h3>
                    <p class="mb-0 opacity-75 fw-medium">Săn sale sập sàn - Số lượng có hạn!</p>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <span class="text-white fw-bold">Kết thúc trong:</span>
                <div class="d-flex gap-2">
                    <div class="bg-white text-danger rounded p-2 text-center shadow-sm" style="min-width: 45px;">
                        <div class="fw-bold fs-5 lh-1" id="fs-hours">03</div>
                        <div style="font-size: 0.65rem;" class="fw-bold text-uppercase mt-1">Giờ</div>
                    </div>
                    <div class="text-white fw-bold fs-4">:</div>
                    <div class="bg-white text-danger rounded p-2 text-center shadow-sm" style="min-width: 45px;">
                        <div class="fw-bold fs-5 lh-1" id="fs-minutes">45</div>
                        <div style="font-size: 0.65rem;" class="fw-bold text-uppercase mt-1">Phút</div>
                    </div>
                    <div class="text-white fw-bold fs-4">:</div>
                    <div class="bg-white text-danger rounded p-2 text-center shadow-sm" style="min-width: 45px;">
                        <div class="fw-bold fs-5 lh-1" id="fs-seconds">12</div>
                        <div style="font-size: 0.65rem;" class="fw-bold text-uppercase mt-1">Giây</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4 position-relative z-1 g-3">
            <?php if (!empty($latestProducts)): ?>
                <?php $count = 0; foreach($latestProducts as $product): if($count >= 4) break; 
                    $img = $product['image'] ?? '';
                    $imgUrl = !empty($img) ? (str_starts_with($img, 'http') ? $img : BASE_URL . 'assets/uploads/' . $img) : 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853';
                ?>
                <div class="col-6 col-md-3">
                    <div class="bg-white rounded-4 p-2 h-100 d-flex flex-column hover-elevate transition-all cursor-pointer" onclick="window.location.href='<?= BASE_URL ?>?action=product-detail&id=<?= $product['product_id'] ?>'">
                        <div class="position-relative bg-light rounded-3 mb-2" style="padding-top: 100%;">
                            <img src="<?= $imgUrl ?>" class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain p-2" alt="Product">
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2">-15%</span>
                        </div>
                        <div class="px-2 pb-2 d-flex flex-column flex-grow-1">
                            <h6 class="text-dark fw-bold text-truncate mb-1" style="font-size: 0.9rem;"><?= htmlspecialchars($product['product_name']) ?></h6>
                            <div class="mt-auto d-flex flex-column">
                                <span class="text-danger fw-bold fs-6"><?= number_format($product['price'] * 0.85, 0, ',', '.') ?>đ</span>
                                <span class="text-muted text-decoration-line-through" style="font-size: 0.75rem;"><?= number_format($product['price'], 0, ',', '.') ?>đ</span>
                                <div class="progress mt-2" style="height: 6px;">
                                    <div class="progress-bar bg-danger" style="width: <?= rand(40, 90) ?>%"></div>
                                </div>
                                <small class="text-danger mt-1" style="font-size: 0.65rem;">Đã bán <?= rand(10, 50) ?></small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $count++; endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Script đếm ngược -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tạo một deadline giả định là 3 giờ nữa
        let deadline = new Date().getTime() + (3 * 60 * 60 * 1000) + (45 * 60 * 1000) + (12 * 1000);
        
        let timer = setInterval(function() {
            let now = new Date().getTime();
            let distance = deadline - now;
            
            if (distance < 0) {
                clearInterval(timer);
                return;
            }
            
            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            document.getElementById('fs-hours').innerText = hours.toString().padStart(2, '0');
            document.getElementById('fs-minutes').innerText = minutes.toString().padStart(2, '0');
            document.getElementById('fs-seconds').innerText = seconds.toString().padStart(2, '0');
        }, 1000);
    });
</script>

<!-- Categories -->
<div class="container mt-5 pt-5">
    <div class="text-center mb-5" data-aos="fade-up">
        <h2 class="fw-bold mb-3 position-relative d-inline-block" style="font-size: 2.5rem; letter-spacing: -1px;">
            Khám Phá Danh Mục
            <div class="position-absolute w-50" style="height: 4px; bottom: -10px; left: 25%; background: linear-gradient(90deg, transparent, var(--primary-color), transparent); border-radius: 2px;"></div>
        </h2>
        <p class="text-muted fs-5 mt-4">Lựa chọn sản phẩm phù hợp với nhu cầu của bạn.</p>
    </div>
    <div class="row justify-content-center">
        <?php if (!empty($homeCategories)): ?>
            <?php foreach ($homeCategories as $index => $cat): ?>
            <div class="col-6 col-md-3 col-lg-2 mb-4" data-aos="fade-up" data-aos-delay="<?= ($index % 5 + 1) * 100 ?>">
                <a href="<?= BASE_URL ?>?action=products&category_id=<?= $cat['category_id'] ?>" class="text-decoration-none text-dark category-item d-block">
                    <div class="category-box p-4 rounded-4 text-center transition-all hover-elevate bg-white" style="border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                        <?php if (!empty($cat['icon'])): ?>
                            <img src="<?= BASE_URL ?>assets/uploads/categories/<?= htmlspecialchars($cat['icon']) ?>" alt="<?= htmlspecialchars($cat['category_name']) ?>" style="height: 65px; width: auto; object-fit: contain; margin-bottom: 15px; transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);" class="category-icon">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center bg-light rounded-circle mx-auto mb-3" style="width: 70px; height: 70px;">
                                <i class="bi bi-image text-muted" style="font-size: 1.8rem;"></i>
                            </div>
                        <?php endif; ?>
                        <h6 class="mb-0 text-dark category-title transition-all" style="font-weight: 600; font-size: 0.95rem; letter-spacing: -0.3px;"><?= htmlspecialchars($cat['category_name']) ?></h6>
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
                <div class="product-card-premium bg-white rounded-4 h-100 d-flex flex-column position-relative overflow-hidden transition-all" style="box-shadow: 0 10px 30px rgba(0,0,0,0.04); border: 1px solid rgba(0,0,0,0.02);">
                    <div class="card-img-wrap bg-light position-relative p-4 rounded-top-4 d-flex align-items-center justify-content-center overflow-hidden" style="height: 250px;">
                        <a href="<?= BASE_URL ?>?action=product-detail&id=<?= $product['product_id'] ?? 0 ?>" class="d-block w-100 h-100 position-relative">
                            <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($product['product_name'] ?? 'Product') ?>" style="object-fit: contain; width: 100%; height: 100%; transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); z-index: 2; position: relative;" class="product-img-main drop-shadow-md">
                        </a>
                        <div style="position: absolute; top: 15px; right: 15px; z-index: 10;">
                            <span class="badge bg-danger bg-gradient shadow-sm px-3 py-2 rounded-pill fw-bold" style="font-size:0.7rem; letter-spacing: 1px;"><i class="bi bi-stars"></i> MỚI</span>
                        </div>
                        
                        <!-- Premium Hover Overlay -->
                        <div class="premium-hover-overlay" style="padding: 1.5rem 1rem;">
                            <form action="?action=cart-add" method="POST" class="ajax-add-to-cart-form w-100 d-flex justify-content-center">
                                <input type="hidden" name="variant_id" value="<?= htmlspecialchars($product['default_variant_id'] ?? 0) ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" name="action_type" value="add_to_cart" class="btn btn-dark rounded-pill px-4 py-2 fw-medium btn-premium-add shadow d-flex justify-content-center align-items-center gap-2 transition-all hover-scale" style="font-size: 0.9rem;">
                                    <i class="bi bi-cart-plus fs-5"></i> Thêm vào giỏ
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="product-info p-4 flex-grow-1 d-flex flex-column bg-white rounded-bottom-4 position-relative z-1">
                        <div class="d-flex text-warning mb-3 gap-1" style="font-size:0.8rem;">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <a href="<?= BASE_URL ?>?action=product-detail&id=<?= $product['product_id'] ?? 0 ?>" class="text-decoration-none text-dark d-block mb-1">
                            <h5 class="fw-bold text-truncate text-dark product-title transition-all" style="font-size:1.15rem; letter-spacing: -0.3px; line-height: 1.4;"><?= htmlspecialchars($product['product_name'] ?? 'Tên sản phẩm') ?></h5>
                        </a>
                        <p class="text-muted mb-4 text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 1px;"><?= htmlspecialchars($product['category_name'] ?? 'Danh mục') ?></p>
                        
                        <div class="mt-auto pt-3 border-top border-gray-100 d-flex justify-content-between align-items-end">
                            <div>
                                <span class="fw-bold text-dark d-block" style="font-size: 1.25rem; letter-spacing: -0.5px;"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</span>
                            </div>
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-muted hover-primary transition-all cursor-pointer" style="width: 35px; height: 35px;" onclick="window.location.href='<?= BASE_URL ?>?action=product-detail&id=<?= $product['product_id'] ?? 0 ?>'">
                                <i class="bi bi-arrow-right"></i>
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
                <div class="product-card-premium bg-white rounded-4 h-100 d-flex flex-column position-relative overflow-hidden transition-all" style="box-shadow: 0 10px 30px rgba(0,0,0,0.04); border: 1px solid rgba(0,0,0,0.02);">
                    <div class="card-img-wrap bg-light position-relative p-4 rounded-top-4 d-flex align-items-center justify-content-center overflow-hidden" style="height: 250px;">
                        <a href="<?= BASE_URL ?>?action=product-detail&id=<?= $product['product_id'] ?? 0 ?>" class="d-block w-100 h-100 position-relative">
                            <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($product['product_name'] ?? 'Product') ?>" style="object-fit: contain; width: 100%; height: 100%; transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); z-index: 2; position: relative;" class="product-img-main drop-shadow-md">
                        </a>
                        <div style="position: absolute; top: 15px; right: 15px; z-index: 10;">
                            <span class="badge bg-dark bg-gradient shadow-sm px-3 py-2 rounded-pill fw-bold" style="font-size:0.7rem; letter-spacing: 1px;"><i class="bi bi-fire text-warning"></i> BÁN CHẠY</span>
                        </div>
                        
                        <!-- Premium Hover Overlay -->
                        <div class="premium-hover-overlay" style="padding: 1.5rem 1rem;">
                            <form action="?action=cart-add" method="POST" class="ajax-add-to-cart-form w-100 d-flex justify-content-center">
                                <input type="hidden" name="variant_id" value="<?= htmlspecialchars($product['default_variant_id'] ?? 0) ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" name="action_type" value="add_to_cart" class="btn btn-dark rounded-pill px-4 py-2 fw-medium btn-premium-add shadow d-flex justify-content-center align-items-center gap-2 transition-all hover-scale" style="font-size: 0.9rem;">
                                    <i class="bi bi-cart-plus fs-5"></i> Thêm vào giỏ
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="product-info p-4 flex-grow-1 d-flex flex-column bg-white rounded-bottom-4 position-relative z-1">
                        <div class="d-flex text-warning mb-3 gap-1" style="font-size:0.8rem;">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <a href="<?= BASE_URL ?>?action=product-detail&id=<?= $product['product_id'] ?? 0 ?>" class="text-decoration-none text-dark d-block mb-1">
                            <h5 class="fw-bold text-truncate text-dark product-title transition-all" style="font-size:1.15rem; letter-spacing: -0.3px; line-height: 1.4;"><?= htmlspecialchars($product['product_name'] ?? 'Tên sản phẩm') ?></h5>
                        </a>
                        <p class="text-muted mb-4 text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 1px;"><?= htmlspecialchars($product['category_name'] ?? 'Danh mục') ?></p>
                        
                        <div class="mt-auto pt-3 border-top border-gray-100 d-flex justify-content-between align-items-end">
                            <div>
                                <span class="fw-bold text-dark d-block" style="font-size: 1.25rem; letter-spacing: -0.5px;"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</span>
                            </div>
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-muted hover-primary transition-all cursor-pointer" style="width: 35px; height: 35px;" onclick="window.location.href='<?= BASE_URL ?>?action=product-detail&id=<?= $product['product_id'] ?? 0 ?>'">
                                <i class="bi bi-arrow-right"></i>
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
