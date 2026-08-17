<!-- Hero Parallax Section -->
<div class="container-fluid px-4 mt-3" data-aos="fade-up">
    <div id="heroCarousel" class="carousel slide shadow-lg rounded-4 overflow-hidden" data-bs-ride="carousel" data-bs-interval="6000">
        <!-- Indicators -->
        <div class="carousel-indicators">
            <?php if (!empty($heroBanners)): ?>
                <?php foreach ($heroBanners as $index => $banner): ?>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $index + 1 ?>"></button>
                <?php endforeach; ?>
            <?php else: ?>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <?php endif; ?>
        </div>
        
        <div class="carousel-inner" style="height: 500px;">
        <?php if (!empty($heroBanners)): ?>
            <?php foreach ($heroBanners as $index => $banner): ?>
                <div class="carousel-item h-100 <?= $index === 0 ? 'active' : '' ?>">
                    <?php if (!empty($banner['link'])): ?>
                    <a href="<?= htmlspecialchars($banner['link']) ?>" class="d-block w-100 h-100 position-absolute z-1"></a>
                    <?php endif; ?>
                    <div class="position-absolute w-100 h-100" style="background-image: url('<?= BASE_URL ?>assets/uploads/banner/<?= $banner['image_url'] ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
                    <!-- Giảm độ tối của overlay để ảnh banner sáng hơn -->
                    <div class="position-absolute w-100 h-100" style="background: rgba(0,0,0,0.1);"></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Fallback nếu không có banner nào -->
            <div class="carousel-item active h-100">
                <div class="position-absolute w-100 h-100" style="background-image: url('https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center;"></div>
                <div class="position-absolute w-100 h-100" style="background: rgba(0,0,0,0.4);"></div>
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center h-100" style="bottom: 0;">
                    <span class="badge bg-primary rounded-pill px-3 py-1 mb-3 fs-6 shadow-sm border border-light border-opacity-25">GENTECH</span>
                    <h1 class="display-5 fw-bold mb-3 text-white" style="letter-spacing: -1px;">SẢN PHẨM <span class="text-primary">CHÍNH HÃNG</span></h1>
                </div>
            </div>
        <?php endif; ?>
        </div>
        
        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev" style="width: 5%; opacity: 1;">
            <span class="carousel-control-prev-icon p-3 bg-dark bg-opacity-50 rounded-circle" aria-hidden="true" style="width: 50px; height: 50px;"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next" style="width: 5%; opacity: 1;">
            <span class="carousel-control-next-icon p-3 bg-dark bg-opacity-50 rounded-circle" aria-hidden="true" style="width: 50px; height: 50px;"></span>
            <span class="visually-hidden">Next</span>
        </button>

    </div>
</div>

<!-- Flash Sale Section -->
<?php if (!empty($activeFlashSale) && !empty($flashSaleItems)): ?>
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
                    <h3 class="fw-bold mb-1" style="letter-spacing: -1px; text-shadow: 0 2px 4px rgba(0,0,0,0.2);"><?= htmlspecialchars($activeFlashSale['title']) ?></h3>
                    <p class="mb-0 opacity-75 fw-medium">Săn sale sập sàn - Số lượng có hạn!</p>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <span class="text-white fw-bold">Kết thúc trong:</span>
                <div class="d-flex gap-2">
                    <div class="bg-white text-danger rounded p-2 text-center shadow-sm" style="min-width: 45px;">
                        <div class="fw-bold fs-5 lh-1" id="fs-hours">00</div>
                        <div style="font-size: 0.65rem;" class="fw-bold text-uppercase mt-1">Giờ</div>
                    </div>
                    <div class="text-white fw-bold fs-4">:</div>
                    <div class="bg-white text-danger rounded p-2 text-center shadow-sm" style="min-width: 45px;">
                        <div class="fw-bold fs-5 lh-1" id="fs-minutes">00</div>
                        <div style="font-size: 0.65rem;" class="fw-bold text-uppercase mt-1">Phút</div>
                    </div>
                    <div class="text-white fw-bold fs-4">:</div>
                    <div class="bg-white text-danger rounded p-2 text-center shadow-sm" style="min-width: 45px;">
                        <div class="fw-bold fs-5 lh-1" id="fs-seconds">00</div>
                        <div style="font-size: 0.65rem;" class="fw-bold text-uppercase mt-1">Giây</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4 position-relative z-1 g-3">
            <?php foreach($flashSaleItems as $item): 
                $img = $item['image'] ?? '';
                $imgName = !empty($img) ? basename($img) : '';
                $imgUrl = !empty($imgName) ? BASE_ASSETS_UPLOADS . 'products/' . $imgName : 'https://placehold.co/400x400/e2e8f0/64748b?text=IMG';
                $discountPercent = $item['price'] > 0 ? round((($item['price'] - $item['flash_price']) / $item['price']) * 100) : 0;
                $soldPercent = $item['quantity'] > 0 ? min(100, ($item['sold'] / $item['quantity']) * 100) : 0;
            ?>
                <div class="col-6 col-md-3">
                    <div class="bg-white rounded-4 p-2 h-100 d-flex flex-column hover-elevate transition-all cursor-pointer" onclick="window.location.href='<?= BASE_URL ?>?action=product-detail&id=<?= $item['product_id'] ?>'">
                        <div class="position-relative bg-light rounded-3 mb-2" style="padding-top: 100%;">
                            <img src="<?= $imgUrl ?>" class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain p-2" alt="Product">
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2">-<?= $discountPercent ?>%</span>
                        </div>
                        <div class="px-2 pb-2 d-flex flex-column flex-grow-1">
                            <h6 class="text-dark fw-bold text-truncate mb-1" style="font-size: 0.9rem;"><?= htmlspecialchars($item['product_name']) ?></h6>
                            <div class="mt-auto d-flex flex-column">
                                <span class="text-danger fw-bold fs-6"><?= number_format($item['flash_price'], 0, ',', '.') ?>đ</span>
                                <?php if ($item['price'] > $item['flash_price']): ?>
                                    <span class="text-muted text-decoration-line-through" style="font-size: 0.75rem;"><?= number_format($item['price'], 0, ',', '.') ?>đ</span>
                                <?php endif; ?>
                                <div class="progress mt-2" style="height: 6px;">
                                    <div class="progress-bar bg-danger" style="width: <?= $soldPercent ?>%"></div>
                                </div>
                                <small class="text-danger mt-1" style="font-size: 0.65rem;">Đã bán <?= $item['sold'] ?> <?= $item['quantity'] ? '/ '.$item['quantity'] : '' ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Script đếm ngược -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let deadline = new Date("<?= date('Y-m-d\TH:i:s', strtotime($activeFlashSale['end_time'])) ?>").getTime();
        
        let timer = setInterval(function() {
            let now = new Date().getTime();
            let distance = deadline - now;
            
            if (distance < 0) {
                clearInterval(timer);
                return;
            }
            
            let hours = Math.floor(distance / (1000 * 60 * 60)); // Show total hours
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            document.getElementById('fs-hours').innerText = hours.toString().padStart(2, '0');
            document.getElementById('fs-minutes').innerText = minutes.toString().padStart(2, '0');
            document.getElementById('fs-seconds').innerText = seconds.toString().padStart(2, '0');
        }, 1000);
    });
</script>
<?php endif; ?>

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
                        <div class="d-flex align-items-center justify-content-center bg-light rounded-circle mx-auto mb-3 category-icon-wrapper" style="width: 70px; height: 70px; transition: all 0.3s ease;">
                            <?php 
                                $iconClass = !empty($cat['icon']) ? htmlspecialchars($cat['icon']) : 'bi-grid';
                                // Nếu icon cũ đang là file ảnh (chứa dấu chấm), tạm thời fallback về bi-grid để tránh lỗi hiển thị HTML
                                if (strpos($iconClass, '.') !== false) {
                                    $iconClass = 'bi-grid';
                                }
                            ?>
                            <i class="bi <?= $iconClass ?> text-primary category-icon" style="font-size: 1.8rem; transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);"></i>
                        </div>
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
                $imgName = !empty($img) ? basename($img) : '';
                $imgUrl = !empty($imgName) ? BASE_ASSETS_UPLOADS . 'products/' . $imgName : 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?q=80&w=2071&auto=format&fit=crop';
            ?>
            <div class="col-sm-6 col-lg-3 mb-5" data-aos="fade-up" data-aos-delay="<?= ($index % 4 + 1) * 100 ?>">
                <div class="product-card-premium bg-white rounded-4 h-100 d-flex flex-column position-relative overflow-hidden transition-all" style="box-shadow: 0 10px 30px rgba(0,0,0,0.04); border: 1px solid rgba(0,0,0,0.02);">
                    <div class="card-img-wrap bg-light position-relative p-4 rounded-top-4 d-flex align-items-center justify-content-center overflow-hidden" style="height: 250px;" onmouseover="this.querySelector('.hover-overlay').style.opacity='1'" onmouseout="this.querySelector('.hover-overlay').style.opacity='0'">
                        <a href="<?= BASE_URL ?>?action=product-detail&id=<?= $product['product_id'] ?? 0 ?>" class="d-block w-100 h-100 position-relative">
                            <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($product['product_name'] ?? 'Product') ?>" style="object-fit: contain; width: 100%; height: 100%; transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); z-index: 2; position: relative;" class="product-img-main drop-shadow-md">
                        </a>
                        <div style="position: absolute; top: 15px; right: 15px; z-index: 10;">
                            <span class="badge bg-danger bg-gradient shadow-sm px-3 py-2 rounded-pill fw-bold" style="font-size:0.7rem; letter-spacing: 1px;"><i class="bi bi-stars"></i> MỚI</span>
                        </div>
                        
                        <!-- Premium Hover Overlay -->
                        <div class="position-absolute d-flex justify-content-center align-items-center w-100 h-100 hover-overlay" style="top: 0; left: 0; background: rgba(255,255,255,0.4); opacity: 0; transition: all 0.3s ease; z-index: 15; pointer-events: none;">
                            <form action="?action=cart-add" method="POST" class="ajax-add-to-cart-form" style="pointer-events: auto;">
                                <input type="hidden" name="variant_id" value="<?= htmlspecialchars($product['default_variant_id'] ?? 0) ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" name="action_type" value="add_to_cart" class="btn btn-dark rounded-circle shadow-lg d-flex justify-content-center align-items-center transition-all hover-scale" style="width: 55px; height: 55px; transform: translateY(10px); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(0)'" onmouseout="this.style.transform='translateY(10px)'" title="Thêm vào giỏ">
                                    <i class="bi bi-cart-plus fs-4"></i>
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
    <div id="promoCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="7000">
        <div class="carousel-inner">
            <?php if (!empty($promoBanners)): ?>
                <?php 
                // Gộp 2 banner vào 1 slide để giữ layout 2 cột
                $chunks = array_chunk($promoBanners, 2);
                foreach ($chunks as $index => $chunk): 
                ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="row g-4">
                            <?php foreach ($chunk as $banner): ?>
                                <div class="col-md-6">
                                    <a href="<?= !empty($banner['link']) ? htmlspecialchars($banner['link']) : '#' ?>" class="d-block rounded-4 overflow-hidden shadow-sm hover-zoom">
                                        <img src="<?= BASE_URL ?>assets/uploads/banner/<?= $banner['image_url'] ?>" alt="<?= htmlspecialchars($banner['title']) ?>" class="img-fluid w-100 rounded-4" style="height:250px; object-fit:cover;">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- ========================================== -->
                <!-- VỊ TRÍ THÊM BANNER QUẢNG CÁO CỦA BẠN Ở ĐÂY -->
                <!-- ========================================== -->
                <div class="carousel-item active">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <a href="#" class="d-block rounded-4 overflow-hidden shadow-sm hover-zoom bg-light border d-flex justify-content-center align-items-center" style="height:250px;">
                                <img src="https://placehold.co/800x300/475569/ffffff?text=BANNER+1" alt="Banner Khuyến Mãi 1" class="img-fluid w-100 h-100 rounded-4" style="object-fit:cover;">
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="d-block rounded-4 overflow-hidden shadow-sm hover-zoom bg-light border d-flex justify-content-center align-items-center" style="height:250px;">
                                <img src="https://placehold.co/800x300/64748b/ffffff?text=BANNER+2" alt="Banner Khuyến Mãi 2" class="img-fluid w-100 h-100 rounded-4" style="object-fit:cover;">
                            </a>
                        </div>
                    </div>
                </div>
                <!-- ========================================== -->
            <?php endif; ?>
        </div>
        
        <?php if (!empty($promoBanners) && count($promoBanners) > 2): ?>
            <!-- Controls (chỉ hiện khi có hơn 2 banner) -->
            <button class="carousel-control-prev justify-content-start ms-n4" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev" style="width: auto;">
                <span class="carousel-control-prev-icon p-3 bg-dark bg-opacity-50 rounded-circle shadow" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next justify-content-end me-n4" type="button" data-bs-target="#promoCarousel" data-bs-slide="next" style="width: auto;">
                <span class="carousel-control-next-icon p-3 bg-dark bg-opacity-50 rounded-circle shadow" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
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
                $imgName = !empty($img) ? basename($img) : '';
                $imgUrl = !empty($imgName) ? BASE_ASSETS_UPLOADS . 'products/' . $imgName : 'https://placehold.co/400x400/e2e8f0/64748b?text=IMG';
            ?>
            <div class="col-sm-6 col-lg-3 mb-5" data-aos="fade-up" data-aos-delay="<?= ($index % 4 + 1) * 100 ?>">
                <div class="product-card-premium bg-white rounded-4 h-100 d-flex flex-column position-relative overflow-hidden transition-all" style="box-shadow: 0 10px 30px rgba(0,0,0,0.04); border: 1px solid rgba(0,0,0,0.02);">
                    <div class="card-img-wrap bg-light position-relative p-4 rounded-top-4 d-flex align-items-center justify-content-center overflow-hidden" style="height: 250px;" onmouseover="this.querySelector('.hover-overlay').style.opacity='1'" onmouseout="this.querySelector('.hover-overlay').style.opacity='0'">
                        <a href="<?= BASE_URL ?>?action=product-detail&id=<?= $product['product_id'] ?? 0 ?>" class="d-block w-100 h-100 position-relative">
                            <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($product['product_name'] ?? 'Product') ?>" style="object-fit: contain; width: 100%; height: 100%; transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); z-index: 2; position: relative;" class="product-img-main drop-shadow-md">
                        </a>
                        <div class="position-absolute" style="top: 15px; left: 15px; z-index: 10;">
                            <span class="badge bg-warning text-dark shadow-sm px-3 py-2 rounded-pill fw-bold" style="font-size:0.7rem; letter-spacing: 1px;"><i class="bi bi-fire text-danger"></i> HOT</span>
                        </div>
                        
                        <!-- Premium Hover Overlay -->
                        <div class="position-absolute d-flex justify-content-center align-items-center w-100 h-100 hover-overlay" style="top: 0; left: 0; background: rgba(255,255,255,0.4); opacity: 0; transition: all 0.3s ease; z-index: 15; pointer-events: none;">
                            <form action="?action=cart-add" method="POST" class="ajax-add-to-cart-form" style="pointer-events: auto;">
                                <input type="hidden" name="variant_id" value="<?= htmlspecialchars($product['default_variant_id'] ?? 0) ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" name="action_type" value="add_to_cart" class="btn btn-dark rounded-circle shadow-lg d-flex justify-content-center align-items-center transition-all hover-scale" style="width: 55px; height: 55px; transform: translateY(10px); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(0)'" onmouseout="this.style.transform='translateY(10px)'" title="Thêm vào giỏ">
                                    <i class="bi bi-cart-plus fs-4"></i>
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
