<!-- Hero Section (Premium Layout) -->
<div class="container mt-4" data-aos="fade-up">
    <div class="row g-3">
        <!-- Main Carousel (Left) -->
        <div class="col-lg-8">
            <div id="heroCarousel" class="carousel slide shadow-sm rounded-4 overflow-hidden h-100" data-bs-ride="carousel" data-bs-interval="5000">
                <!-- Indicators -->
                <div class="carousel-indicators mb-2">
                    <?php if (!empty($heroBanners)): ?>
                        <?php foreach ($heroBanners as $index => $banner): ?>
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $index + 1 ?>" style="width: 10px; height: 10px; border-radius: 50%; margin: 0 4px;"></button>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1" style="width: 10px; height: 10px; border-radius: 50%;"></button>
                    <?php endif; ?>
                </div>
                
                <div class="carousel-inner" style="height: 420px;">
                <?php if (!empty($heroBanners)): ?>
                    <?php foreach ($heroBanners as $index => $banner): ?>
                        <div class="carousel-item h-100 <?= $index === 0 ? 'active' : '' ?>">
                            <?php if (!empty($banner['link'])): ?>
                            <a href="<?= htmlspecialchars($banner['link']) ?>" class="d-block w-100 h-100 position-absolute z-1"></a>
                            <?php endif; ?>
                            <div class="position-absolute w-100 h-100" style="background-image: url('<?= BASE_URL ?>assets/uploads/banner/<?= $banner['image_url'] ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
                            <div class="position-absolute w-100 h-100" style="background: rgba(0,0,0,0.05);"></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="carousel-item active h-100">
                        <div class="position-absolute w-100 h-100" style="background-image: url('https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center;"></div>
                        <div class="position-absolute w-100 h-100" style="background: rgba(0,0,0,0.3);"></div>
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center h-100" style="bottom: 0;">
                            <span class="badge bg-primary rounded-pill px-3 py-1 mb-3 fs-6 shadow-sm border border-light border-opacity-25">GENTECH PRIME</span>
                            <h1 class="display-5 fw-bold mb-3 text-white" style="letter-spacing: -1px;">CÔNG NGHỆ <span class="text-primary">ĐỈNH CAO</span></h1>
                        </div>
                    </div>
                <?php endif; ?>
                </div>
                
                <!-- Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev" style="width: 60px;">
                    <span class="carousel-control-prev-icon p-3 bg-white bg-opacity-25 rounded-circle shadow-sm" aria-hidden="true" style="backdrop-filter: blur(4px);"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next" style="width: 60px;">
                    <span class="carousel-control-next-icon p-3 bg-white bg-opacity-25 rounded-circle shadow-sm" aria-hidden="true" style="backdrop-filter: blur(4px);"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <!-- Static Promo Banners (Right) -->
        <div class="col-lg-4 d-none d-lg-flex flex-column gap-3">
            <div class="rounded-4 overflow-hidden shadow-sm position-relative hover-scale transition-all cursor-pointer flex-fill" style="background: linear-gradient(135deg, #2563eb, #1e40af); height: 200px;">
                <!-- Decorative -->
                <div class="position-absolute opacity-25" style="top: -20px; right: -10px; transform: rotate(15deg);">
                    <i class="bi bi-controller text-white" style="font-size: 8rem;"></i>
                </div>
                <div class="position-absolute w-100 h-100 d-flex flex-column justify-content-center p-4 z-1 text-white">
                    <span class="badge bg-white text-primary rounded-pill w-auto align-self-start mb-2 fw-bold shadow-sm" style="font-size: 0.7rem;">ƯU ĐÃI ĐỘC QUYỀN</span>
                    <h4 class="fw-bold mb-1" style="text-shadow: 0 2px 4px rgba(0,0,0,0.2);">Gaming Gear</h4>
                    <p class="mb-0 fs-6 opacity-75 fw-medium">Giảm đến 30%</p>
                </div>
            </div>
            <div class="rounded-4 overflow-hidden shadow-sm position-relative hover-scale transition-all cursor-pointer flex-fill" style="background: linear-gradient(135deg, #10b981, #047857); height: 200px;">
                <!-- Decorative -->
                <div class="position-absolute opacity-25" style="bottom: -10px; right: 0px; transform: rotate(-10deg);">
                    <i class="bi bi-laptop text-white" style="font-size: 8rem;"></i>
                </div>
                <div class="position-absolute w-100 h-100 d-flex flex-column justify-content-center p-4 z-1 text-white">
                    <span class="badge bg-white text-success rounded-pill w-auto align-self-start mb-2 fw-bold shadow-sm" style="font-size: 0.7rem;">HÀNG MỚI VỀ</span>
                    <h4 class="fw-bold mb-1" style="text-shadow: 0 2px 4px rgba(0,0,0,0.2);">Laptop Core Ultra</h4>
                    <p class="mb-0 fs-6 opacity-75 fw-medium">Trải nghiệm AI đỉnh cao</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Flash Sale Section -->
<?php if (!empty($activeFlashSale) && !empty($flashSaleItems)): ?>
<div class="container mt-5 pt-4">
    <div class="p-4 rounded-4 position-relative overflow-hidden shadow-lg" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); border: 1px solid rgba(255,255,255,0.1);">
        
        <!-- Decorative glowing orbs -->
        <div class="position-absolute rounded-circle" style="width: 300px; height: 300px; background: rgba(239, 68, 68, 0.4); filter: blur(80px); top: -100px; left: -100px; pointer-events: none;"></div>
        <div class="position-absolute rounded-circle" style="width: 400px; height: 400px; background: rgba(139, 92, 246, 0.3); filter: blur(100px); bottom: -150px; right: -150px; pointer-events: none;"></div>
        
        <!-- Lightning decorative -->
        <div class="position-absolute opacity-10" style="top: 10px; right: 10px; transform: rotate(15deg);">
            <i class="bi bi-lightning-charge-fill text-white" style="font-size: 15rem;"></i>
        </div>
        
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between position-relative z-1 gap-4 mb-4">
            <div class="text-white d-flex align-items-center gap-3">
                <div class="bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 60px; height: 60px; font-size: 1.8rem; background: linear-gradient(135deg, #ef4444 0%, #f97316 100%); box-shadow: 0 0 20px rgba(239,68,68,0.5) !important;">
                    <i class="bi bi-lightning-fill" style="animation: pulse-glow 2s infinite;"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-1 d-flex align-items-center gap-2" style="letter-spacing: -0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                        <span class="bg-clip-text text-transparent" style="background-image: linear-gradient(to right, #ff8a00, #e52e71); -webkit-background-clip: text; color: transparent;">FLASHSALE</span> 
                        <span class="fs-5 text-light fw-normal opacity-75 d-none d-md-inline">| <?= htmlspecialchars($activeFlashSale['title']) ?></span>
                    </h3>
                    <p class="mb-0 text-white-50 fw-medium" style="font-size: 0.9rem;">Săn sale sập sàn - Số lượng có hạn!</p>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-3 bg-white bg-opacity-10 backdrop-blur-md px-4 py-3 rounded-4 border border-white border-opacity-25 shadow-sm">
                <span class="text-white fw-bold text-uppercase d-none d-sm-inline" style="font-size: 0.85rem; letter-spacing: 1px;">Kết thúc trong</span>
                <div class="d-flex gap-2">
                    <div class="bg-dark bg-gradient text-white rounded p-2 text-center shadow" style="min-width: 45px; border: 1px solid rgba(255,255,255,0.1);">
                        <div class="fw-bold fs-5 lh-1" id="fs-hours">00</div>
                        <div style="font-size: 0.6rem;" class="fw-bold text-white-50 text-uppercase mt-1">Giờ</div>
                    </div>
                    <div class="text-white-50 fw-bold fs-4 align-self-center pb-2">:</div>
                    <div class="bg-dark bg-gradient text-white rounded p-2 text-center shadow" style="min-width: 45px; border: 1px solid rgba(255,255,255,0.1);">
                        <div class="fw-bold fs-5 lh-1" id="fs-minutes">00</div>
                        <div style="font-size: 0.6rem;" class="fw-bold text-white-50 text-uppercase mt-1">Phút</div>
                    </div>
                    <div class="text-white-50 fw-bold fs-4 align-self-center pb-2">:</div>
                    <div class="bg-danger bg-gradient text-white rounded p-2 text-center shadow" style="min-width: 45px; box-shadow: 0 0 15px rgba(220,53,69,0.5) !important;">
                        <div class="fw-bold fs-5 lh-1" id="fs-seconds">00</div>
                        <div style="font-size: 0.6rem;" class="fw-bold text-white-50 text-uppercase mt-1">Giây</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="d-flex position-relative z-1 overflow-x-auto custom-scrollbar gap-3 pb-3" style="scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch;">
            <?php foreach($flashSaleItems as $item): 
                $img = $item['image'] ?? '';
                $imgName = !empty($img) ? basename($img) : '';
                $imgUrl = !empty($imgName) ? BASE_ASSETS_UPLOADS . 'products/' . $imgName : 'https://placehold.co/400x400/e2e8f0/64748b?text=IMG';
                $discountPercent = $item['price'] > 0 ? round((($item['price'] - $item['flash_price']) / $item['price']) * 100) : 0;
                $soldPercent = $item['quantity'] > 0 ? min(100, ($item['sold'] / $item['quantity']) * 100) : 0;
            ?>
                <div class="flex-shrink-0" style="width: 250px; scroll-snap-align: start;">
                    <div class="bg-white rounded-4 p-3 h-100 d-flex flex-column hover-elevate transition-all cursor-pointer shadow-sm position-relative" style="border: 1px solid rgba(0,0,0,0.05);" onclick="window.location.href='<?= BASE_URL ?>?action=product-detail&id=<?= $item['product_id'] ?>'">
                        <div class="position-absolute top-0 start-0 z-3 m-3">
                            <span class="badge bg-danger bg-gradient shadow-sm px-2 py-1 rounded-pill fw-bold d-flex align-items-center gap-1" style="font-size:0.75rem;">
                                <i class="bi bi-lightning-fill"></i> -<?= $discountPercent ?>%
                            </span>
                        </div>
                        <div class="position-relative bg-light rounded-3 mb-3 d-flex align-items-center justify-content-center overflow-hidden" style="height: 200px;">
                            <img src="<?= $imgUrl ?>" class="w-100 h-100 object-fit-contain p-2 hover-scale transition-all" alt="<?= htmlspecialchars($item['product_name']) ?>" style="mix-blend-mode: multiply;">
                        </div>
                        <div class="d-flex flex-column flex-grow-1">
                            <h6 class="text-dark fw-bold mb-2 text-truncate-2" style="font-size: 1rem; line-height: 1.4; height: 2.8em;"><?= htmlspecialchars($item['product_name']) ?></h6>
                            <div class="mt-auto">
                                <div class="d-flex align-items-end gap-2 mb-2">
                                    <span class="text-danger fw-bold fs-5 lh-1"><?= number_format($item['flash_price'], 0, ',', '.') ?>đ</span>
                                    <?php if ($item['price'] > $item['flash_price']): ?>
                                        <span class="text-muted text-decoration-line-through mb-1" style="font-size: 0.8rem;"><?= number_format($item['price'], 0, ',', '.') ?>đ</span>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Premium Progress Bar -->
                                <div class="position-relative bg-danger bg-opacity-10 rounded-pill mt-2 overflow-hidden border border-danger border-opacity-25" style="height: 20px;">
                                    <div class="position-absolute top-0 start-0 h-100 bg-danger bg-gradient rounded-pill" style="width: <?= $soldPercent ?>%; transition: width 1s ease-in-out;"></div>
                                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                        <span class="text-white fw-bold" style="font-size: 0.65rem; text-shadow: 0 0 3px rgba(0,0,0,0.8); z-index: 2;">
                                            <?= $soldPercent >= 100 ? 'Đã bán hết' : 'Đã bán '.$item['sold'].'/'.$item['quantity'] ?>
                                        </span>
                                    </div>
                                    <?php if ($soldPercent >= 80 && $soldPercent < 100): ?>
                                    <div class="position-absolute top-0 end-0 h-100 d-flex align-items-center pe-2">
                                        <i class="bi bi-fire text-white" style="font-size: 0.7rem; filter: drop-shadow(0 0 2px rgba(0,0,0,0.5)); animation: pulse-glow 1s infinite;"></i>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<style>
/* Custom scrollbar for Flash Sale horizontal scroll */
.custom-scrollbar::-webkit-scrollbar {
    height: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(255,255,255,0.05);
    border-radius: 10px;
    margin: 0 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.2);
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(255,255,255,0.4);
}
@keyframes pulse-glow {
    0% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.7; transform: scale(1.2); }
    100% { opacity: 1; transform: scale(1); }
}
.text-truncate-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
.backdrop-blur-md {
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}
</style>

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
