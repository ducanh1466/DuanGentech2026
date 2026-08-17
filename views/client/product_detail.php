<!-- Breadcrumb -->
<div class="container mt-4 pt-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="?action=/" class="text-decoration-none text-muted hover-primary">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="?action=products" class="text-decoration-none text-muted hover-primary"><?= htmlspecialchars($product['category_name'] ?? 'Danh mục') ?></a></li>
            <li class="breadcrumb-item"><a href="?action=products" class="text-decoration-none text-muted hover-primary"><?= htmlspecialchars($product['brand_name'] ?? 'Thương hiệu') ?></a></li>
            <li class="breadcrumb-item active text-dark fw-medium" aria-current="page"><?= htmlspecialchars($product['product_name']) ?></li>
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
                    <img src="<?= $product['image'] ?>" id="mainImage" class="w-100 h-100 object-fit-contain p-5" alt="<?= htmlspecialchars($product['product_name']) ?>">
                </div>
                <!-- Thumbnails -->
                <div class="row g-3">
                    <?php if(!empty($images)): ?>
                        <?php foreach($images as $index => $img): ?>
                        <div class="col-3">
                            <div class="rounded-3 overflow-hidden border <?= $index==0 ? 'border-primary border-2' : 'border-light' ?> bg-white cursor-pointer thumbnail-box" style="height: 120px;" onclick="document.getElementById('mainImage').src='<?= $img['image_url'] ?>'; document.querySelectorAll('.thumbnail-box').forEach(el=>{el.classList.remove('border-primary', 'border-2'); el.classList.add('border-light');}); this.classList.remove('border-light'); this.classList.add('border-primary', 'border-2');">
                                <img src="<?= $img['image_url'] ?>" class="w-100 h-100 object-fit-contain p-3" alt="Thumbnail">
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Product Info (Phải) -->
        <div class="col-lg-5" data-aos="fade-left">
            <div class="mb-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-danger rounded-pill px-3 py-2 fw-medium">Trả góp 0%</span>
                    <?php if(isset($product['status']) && $product['status'] == 'new'): ?>
                        <span class="badge bg-dark rounded-pill px-3 py-2 fw-medium">Mới</span>
                    <?php endif; ?>
                </div>
                <h1 class="fw-bold mb-3" style="font-size: 2.5rem; letter-spacing: -1px; line-height: 1.2;"><?= htmlspecialchars($product['product_name']) ?></h1>
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="d-flex text-warning">
                        <?php 
                        $fullStars = floor($avgRating);
                        $halfStar = ($avgRating - $fullStars) >= 0.5 ? 1 : 0;
                        $emptyStars = 5 - $fullStars - $halfStar;
                        for($i=0; $i<$fullStars; $i++) echo '<i class="bi bi-star-fill"></i>';
                        if($halfStar) echo '<i class="bi bi-star-half"></i>';
                        for($i=0; $i<$emptyStars; $i++) echo '<i class="bi bi-star"></i>';
                        ?>
                    </div>
                    <a href="#reviews" class="text-muted text-decoration-none hover-primary">(<?= $totalReviews ?> đánh giá)</a>
                    <span class="text-muted">|</span>
                    <?php 
                    $totalStock = 0;
                    foreach ($variantsData as $v) {
                        $totalStock += (int)($v['stock_quantity'] ?? $v['stock'] ?? 0);
                    }
                    ?>
                    <span id="stockDisplay">
                        <?php if ($totalStock > 0): ?>
                            <span class="text-success fw-medium"><i class="bi bi-check-circle-fill me-1"></i>Còn hàng</span>
                        <?php else: ?>
                            <span class="text-danger fw-medium"><i class="bi bi-x-circle-fill me-1"></i>Hết hàng</span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="mb-4">
                    <?php if (!empty($product['is_flash_sale'])): ?>
                        <div class="d-flex flex-column gap-2 mb-3 bg-danger bg-opacity-10 p-3 rounded-3 border border-danger border-opacity-25">
                            <div class="d-flex align-items-center gap-2 text-danger fw-bold">
                                <i class="bi bi-lightning-fill"></i> FLASH SALE ĐANG DIỄN RA
                            </div>
                            <div class="d-flex align-items-baseline gap-3">
                                <span id="productPrice" class="fs-1 fw-bold text-danger"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</span>
                                <?php if ($product['original_price'] > $product['price']): ?>
                                    <span class="fs-5 text-muted text-decoration-line-through"><?= number_format($product['original_price'], 0, ',', '.') ?>đ</span>
                                    <span class="badge bg-danger">-<?= round((($product['original_price'] - $product['price']) / $product['original_price']) * 100) ?>%</span>
                                <?php endif; ?>
                            </div>
                            <!-- Countdown -->
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <span class="text-danger fw-medium" style="font-size: 0.9rem;">Kết thúc trong:</span>
                                <div class="d-flex gap-1 fw-bold text-danger fs-5 lh-1" id="fs-countdown">
                                    --:--:--
                                </div>
                            </div>
                            <!-- Progress -->
                            <?php if ($product['flash_limit'] > 0): ?>
                            <div class="mt-2">
                                <div class="d-flex justify-content-between text-danger mb-1" style="font-size: 0.8rem; font-weight: 500;">
                                    <span>Đã bán <?= $product['flash_sold'] ?></span>
                                    <span>Tối đa <?= $product['flash_limit'] ?></span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" style="width: <?= min(100, ($product['flash_sold'] / $product['flash_limit']) * 100) ?>%"></div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                let deadline = new Date("<?= date('Y-m-d\TH:i:s', strtotime($product['flash_end_time'])) ?>").getTime();
                                let timer = setInterval(function() {
                                    let now = new Date().getTime();
                                    let distance = deadline - now;
                                    if (distance < 0) {
                                        clearInterval(timer);
                                        document.getElementById('fs-countdown').innerText = 'Đã kết thúc';
                                        return;
                                    }
                                    let hours = Math.floor(distance / (1000 * 60 * 60));
                                    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                    let seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                    document.getElementById('fs-countdown').innerText = 
                                        hours.toString().padStart(2, '0') + ':' + 
                                        minutes.toString().padStart(2, '0') + ':' + 
                                        seconds.toString().padStart(2, '0');
                                }, 1000);
                            });
                        </script>
                    <?php else: ?>
                        <span id="productPrice" class="fs-1 fw-bold text-dark me-3"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</span>
                    <?php endif; ?>
                </div>
            </div>

            <?php if(!empty($attributes)): ?>
                <?php 
                $hasRenderedAnyAttr = false;
                foreach($attributes as $index => $attrGroup): 
                    $attrNameLower = mb_strtolower(trim($attrGroup['attribute_name']), 'UTF-8');
                    // Bỏ qua Hệ điều hành, chỉ giữ lại các thuộc tính liên quan đến Bộ nhớ, Dung lượng, Màu sắc...
                    if (strpos($attrNameLower, 'hệ điều hành') !== false || strpos($attrNameLower, 'os') !== false) {
                        continue;
                    }
                    $hasRenderedAnyAttr = true;
                ?>
                    <div class="mb-4 pt-3 <?= $index === 0 ? 'border-top border-light' : '' ?>">
                        <h6 class="fw-bold mb-3"><?= htmlspecialchars($attrGroup['attribute_name']) ?></h6>
                        <div class="d-flex gap-2 flex-wrap">
                            <?php 
                                $values = explode(', ', $attrGroup['attribute_values']);
                                foreach($values as $vIndex => $val): 
                                    $id = 'attr_' . md5($attrGroup['attribute_name'] . $val);
                            ?>
                                <input type="radio" class="btn-check attr-radio" name="attr_<?= md5($attrGroup['attribute_name']) ?>" id="<?= $id ?>" value="<?= htmlspecialchars($val) ?>" data-attr-name="<?= htmlspecialchars($attrGroup['attribute_name']) ?>" autocomplete="off" <?= $vIndex === 0 ? 'checked' : '' ?>>
                                <label class="btn btn-outline-dark px-4 py-2 rounded-3 border-gray-300" for="<?= $id ?>"><?= htmlspecialchars($val) ?></label>
                            <?php 
                                endforeach; 
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if(!$hasRenderedAnyAttr): ?>
                    <!-- Hiển thị mặc định nếu chưa có thuộc tính phù hợp (Màu sắc, Dung lượng) -->
                    <div class="alert alert-info py-2 small">Sản phẩm này chưa được thiết lập thuộc tính mua hàng (Màu sắc, Dung lượng).</div>
                <?php endif; ?>
            <?php else: ?>
                <!-- Hiển thị mặc định nếu chưa có thuộc tính trong DB -->
                <div class="alert alert-info py-2 small">Sản phẩm này chưa được thiết lập thuộc tính (Màu sắc, Dung lượng).</div>
            <?php endif; ?>

            <!-- Khuyến mãi Box -->
            <div class="bg-gray-100 rounded-4 p-4 mb-5 border border-gray-200">
                <h6 class="fw-bold mb-3 text-danger"><i class="bi bi-gift-fill me-2"></i>Ưu đãi nổi bật</h6>
                <ul class="list-unstyled mb-0 ms-1 text-dark">
                    <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i>Giảm thêm 1.500.000đ khi thanh toán qua thẻ tín dụng VIB/HSBC.</li>
                    <li class="mb-2"><i class="bi bi-check2-circle text-success me-2"></i>Thu cũ đổi mới: Trợ giá thêm lên đến 2.000.000đ.</li>
                    <li><i class="bi bi-check2-circle text-success me-2"></i>Tặng gói bảo hành VIP Gentech Care 24 tháng.</li>
                </ul>
            </div>

            <!-- Action Buttons Form -->
            <form action="?action=cart-add" method="POST" class="ajax-add-to-cart-form">
                <!-- Chỗ này thực tế cần dùng JS để lấy variant_id chuẩn dựa vào lựa chọn Màu sắc/Dung lượng, hiện tại tạm fix lấy variant đầu tiên -->
                <input type="hidden" name="variant_id" value="<?= !empty($variantsData) ? htmlspecialchars($variantsData[0]['variant_id']) : 0 ?>">
                <input type="hidden" name="quantity" value="1">
                
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <button type="submit" name="action_type" value="buy_now" class="btn btn-premium-gradient w-100 py-3 d-flex flex-column align-items-center justify-content-center">
                            <span class="fs-5">MUA NGAY</span>
                            <small class="fw-normal" style="font-size: 0.85rem; opacity: 0.9;">Giao hàng miễn phí tận nơi</small>
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-primary w-100 rounded-pill py-2 fw-bold hover-elevate">
                            TRẢ GÓP 0%
                            <small class="d-block fw-normal" style="font-size: 0.75rem;">Duyệt hồ sơ trong 5 phút</small>
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-primary w-100 rounded-pill py-2 fw-bold hover-elevate">
                            TRẢ GÓP QUA THẺ
                            <small class="d-block fw-normal" style="font-size: 0.75rem;">Visa, Mastercard, JCB</small>
                        </button>
                    </div>
                </div>
                
                <button type="submit" name="action_type" value="add_to_cart" class="btn btn-light border w-100 rounded-pill py-3 fw-bold text-dark hover-elevate shadow-sm"><i class="bi bi-cart-plus me-2 fs-5 align-middle"></i>THÊM VÀO GIỎ HÀNG</button>
            </form>
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
                    <?= $product['description'] ?? '<p>Chưa có mô tả cho sản phẩm này.</p>' ?>
                </div>
            </div>
            
            <!-- Thông số kỹ thuật -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-gray-100 rounded-4 p-4 border border-gray-200">
                    <h4 class="fw-bold mb-4">Thông số kỹ thuật</h4>
                    <ul class="list-unstyled mb-0">
                        <?php if(!empty($specs)): ?>
                            <?php foreach($specs as $spec): ?>
                            <li class="d-flex py-3 border-bottom border-gray-300">
                                <span class="text-muted w-50"><?= htmlspecialchars($spec['spec_name']) ?>:</span>
                                <span class="text-dark fw-medium w-50"><?= htmlspecialchars($spec['spec_value']) ?></span>
                            </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="py-3 text-muted">Chưa có thông số kỹ thuật.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reviews Section -->
<div class="bg-light py-5" id="reviews">
    <div class="container py-4">
        <h3 class="fw-bold mb-4">Đánh giá & Nhận xét</h3>
        <div class="row g-5">
            <!-- Form Đánh giá -->
            <div class="col-lg-4">
                <div class="bg-white rounded-4 p-4 shadow-sm border border-gray-100">
                    <div class="text-center mb-4 border-bottom pb-4">
                        <h1 class="display-3 fw-bold text-dark mb-0"><?= number_format($avgRating, 1) ?></h1>
                        <div class="d-flex justify-content-center text-warning fs-5 my-2">
                            <?php 
                            for($i=0; $i<$fullStars; $i++) echo '<i class="bi bi-star-fill"></i>';
                            if($halfStar) echo '<i class="bi bi-star-half"></i>';
                            for($i=0; $i<$emptyStars; $i++) echo '<i class="bi bi-star"></i>';
                            ?>
                        </div>
                        <p class="text-muted mb-0"><?= $totalReviews ?> lượt đánh giá</p>
                    </div>
                    
                    <?php if($isEligibleToReview): ?>
                        <h5 class="fw-bold mb-3">Viết đánh giá của bạn</h5>
                        <form action="?action=post-review" method="POST">
                            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                            <div class="mb-3">
                                <label class="form-label text-muted small d-block mb-2">Chọn số sao</label>
                                <div class="star-rating d-flex gap-2 text-warning fs-3" id="ratingStars" style="cursor: pointer;">
                                    <i class="bi bi-star-fill rating-star" data-rating="1"></i>
                                    <i class="bi bi-star-fill rating-star" data-rating="2"></i>
                                    <i class="bi bi-star-fill rating-star" data-rating="3"></i>
                                    <i class="bi bi-star-fill rating-star" data-rating="4"></i>
                                    <i class="bi bi-star-fill rating-star" data-rating="5"></i>
                                </div>
                                <input type="hidden" name="rating" id="ratingInput" value="5">
                                <div class="text-muted mt-1 small" id="ratingText">Tuyệt vời</div>
                            </div>
                            <div class="mb-3">
                                <textarea name="content" class="form-control" rows="4" placeholder="Chia sẻ cảm nhận của bạn về sản phẩm này..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">GỬI ĐÁNH GIÁ</button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-warning text-center small mb-0">
                            <i class="bi bi-info-circle me-1"></i> Bạn cần mua và trải nghiệm sản phẩm này để viết đánh giá.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Danh sách bình luận -->
            <div class="col-lg-8">
                <?php if(!empty($reviews)): ?>
                    <div class="d-flex flex-column gap-4">
                        <?php foreach($reviews as $review): ?>
                        <div class="bg-white rounded-4 p-4 border border-gray-100 shadow-sm">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px; font-size: 1.2rem;">
                                        <?= strtoupper(substr($review['full_name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold"><?= htmlspecialchars($review['full_name']) ?></h6>
                                        <span class="text-success small fw-medium"><i class="bi bi-check-circle-fill me-1"></i>Đã mua hàng</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="text-warning mb-1">
                                        <?php for($i=1; $i<=5; $i++): ?>
                                            <i class="bi bi-star-<?= $i <= $review['rating'] ? 'fill' : '' ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <small class="text-muted"><?= date('d/m/Y', strtotime($review['review_date'])) ?></small>
                                </div>
                            </div>
                            <p class="mb-0 text-dark" style="line-height: 1.6;"><?= nl2br(htmlspecialchars($review['content'])) ?></p>
                            
                            <?php if (!empty($review['replies'])): ?>
                                <div class="mt-4 ms-4 border-start border-2 ps-4" style="border-color: #e2e8f0 !important; position: relative;">
                                    <?php foreach ($review['replies'] as $reply): ?>
                                        <!-- Timeline dot -->
                                        <div class="position-absolute" style="left: -7px; width: 12px; height: 12px; border-radius: 50%; background-color: <?= $reply['is_admin'] == 1 ? '#0d6efd' : '#6c757d' ?>; margin-top: 20px; box-shadow: 0 0 0 4px #fff;"></div>
                                        
                                        <?php if ($reply['is_admin'] == 1): ?>
                                            <div class="mb-3">
                                                <div class="p-3 bg-gradient rounded-4 shadow-sm position-relative overflow-hidden hover-elevate transition-all" style="background: linear-gradient(145deg, #f0f7ff 0%, #ffffff 100%); border: 1px solid rgba(13, 110, 253, 0.1);">
                                                    <!-- Admin Decorative icon -->
                                                    <div class="position-absolute opacity-10" style="right: -5px; top: -5px;">
                                                        <i class="bi bi-patch-check-fill text-primary" style="font-size: 2.5rem;"></i>
                                                    </div>
                                                    
                                                    <div class="d-flex align-items-center gap-2 mb-2 position-relative z-1">
                                                        <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 35px; height: 35px;">
                                                            <i class="bi bi-headset fs-6"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                                                                CSKH Gentech
                                                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill fw-normal" style="font-size: 0.7rem;"><i class="bi bi-check-circle-fill me-1"></i>Official</span>
                                                            </h6>
                                                            <small class="text-muted" style="font-size: 0.8rem;"><?= date('H:i - d/m/Y', strtotime($reply['created_at'])) ?></small>
                                                        </div>
                                                    </div>
                                                    <div class="text-dark position-relative z-1" style="line-height: 1.6; font-size: 0.95rem;">
                                                        <?= nl2br(htmlspecialchars($reply['content'])) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="mb-3">
                                                <div class="p-3 bg-white rounded-4 shadow-sm position-relative hover-elevate transition-all border border-gray-100">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px; font-size: 0.9rem;">
                                                            <?= strtoupper(substr($reply['full_name'] ?? 'K', 0, 1)) ?>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.95rem;"><?= htmlspecialchars($reply['full_name'] ?? 'Khách hàng') ?></h6>
                                                            <small class="text-muted" style="font-size: 0.75rem;"><?= date('H:i - d/m/Y', strtotime($reply['created_at'])) ?></small>
                                                        </div>
                                                    </div>
                                                    <div class="text-dark" style="line-height: 1.6; font-size: 0.95rem;">
                                                        <?= nl2br(htmlspecialchars($reply['content'])) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($_SESSION['user'])): ?>
                                <div class="mt-4 text-end">
                                    <button class="btn btn-light border rounded-pill px-4 py-2 hover-elevate shadow-sm fw-medium text-primary transition-all" type="button" data-bs-toggle="collapse" data-bs-target="#replyForm<?= $review['review_id'] ?>" aria-expanded="false" onclick="this.classList.toggle('bg-primary'); this.classList.toggle('text-white'); this.classList.toggle('text-primary');">
                                        <i class="bi bi-reply-fill me-1"></i> Viết phản hồi
                                    </button>
                                </div>
                                <div class="collapse mt-3" id="replyForm<?= $review['review_id'] ?>">
                                    <form action="?action=client-reply-review" method="POST" class="p-4 bg-white rounded-4 shadow-sm border border-gray-200 position-relative overflow-hidden">
                                        <!-- Decorative glass background -->
                                        <div class="position-absolute w-100 h-100 top-0 start-0 bg-primary opacity-10" style="filter: blur(40px); z-index: 0; pointer-events: none;"></div>
                                        
                                        <div class="position-relative z-1">
                                            <input type="hidden" name="review_id" value="<?= $review['review_id'] ?>">
                                            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                                                <i class="bi bi-chat-dots-fill text-primary"></i> Phản hồi của bạn
                                            </h6>
                                            <div class="mb-3">
                                                <textarea name="reply_content" class="form-control bg-light border-0" rows="3" placeholder="Nhập câu trả lời của bạn tại đây..." style="box-shadow: inset 0 2px 4px rgba(0,0,0,0.02); resize: none;" required></textarea>
                                            </div>
                                            <div class="d-flex justify-content-end gap-2">
                                                <button type="button" class="btn btn-light px-4 rounded-pill fw-medium" data-bs-toggle="collapse" data-bs-target="#replyForm<?= $review['review_id'] ?>">Hủy</button>
                                                <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold shadow-sm d-flex align-items-center gap-2">
                                                    Gửi <i class="bi bi-send-fill"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="bg-white rounded-4 p-5 text-center border border-gray-100 h-100 d-flex flex-column align-items-center justify-content-center">
                        <i class="bi bi-chat-square-text text-muted" style="font-size: 3rem; opacity: 0.5;"></i>
                        <h5 class="fw-bold mt-3 text-muted">Chưa có đánh giá nào</h5>
                        <p class="text-muted mb-0">Hãy là người đầu tiên đánh giá sản phẩm này!</p>
                    </div>
                <?php endif; ?>
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
        <?php $delay = 0; foreach($relatedProducts as $relProduct): ?>
        <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
            <div class="product-card-premium h-100 d-flex flex-column">
                <?php if(isset($relProduct['status']) && $relProduct['status'] == 'new'): ?>
                <div class="position-absolute top-0 end-0 m-3 z-3">
                    <div class="product-badge bg-dark shadow-sm px-3 py-1 rounded-pill text-white fw-bold" style="font-size:0.8rem;">Mới</div>
                </div>
                <?php endif; ?>
                <div class="card-img-wrap bg-light border-bottom cursor-pointer" style="border-color:#f1f5f9 !important;" onclick="window.location.href='?action=product-detail&id=<?= $relProduct['product_id'] ?>'">
                    <img src="<?= $relProduct['image'] ?>" alt="<?= htmlspecialchars($relProduct['product_name']) ?>">
                    <button class="btn-quick-add hover-elevate" onclick="event.stopPropagation(); window.location.href='?action=cart-add&id=<?= $relProduct['product_id'] ?>'">Thêm vào giỏ</button>
                </div>
                <div class="product-info p-4 flex-grow-1 d-flex flex-column">
                    <p class="text-muted small fw-bold mb-1"><?= strtoupper(htmlspecialchars($relProduct['brand_name'] ?? '')) ?></p>
                    <h5 class="fw-bold mb-3 product-title text-truncate cursor-pointer hover-primary" onclick="window.location.href='?action=product-detail&id=<?= $relProduct['product_id'] ?>'"><?= htmlspecialchars($relProduct['product_name']) ?></h5>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-bold fs-5 text-dark d-block"><?= number_format($relProduct['price'] ?? 0, 0, ',', '.') ?>đ</span>
                        </div>
                        <button class="btn btn-light rounded-circle icon-btn hover-elevate shadow-sm" style="width: 40px; height: 40px; display:flex; align-items:center; justify-content:center; border:1px solid #e2e8f0;" onclick="window.location.href='?action=cart-add&id=<?= $relProduct['product_id'] ?>'">
                            <i class="bi bi-cart-plus fs-5 text-primary"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php $delay += 100; endforeach; ?>
    </div>
</div>

<script>
    const productVariants = <?= json_encode($variantsData ?? []) ?>;
    
    document.addEventListener('DOMContentLoaded', function() {
        const priceDisplay = document.getElementById('productPrice');
        const radios = document.querySelectorAll('.attr-radio');
        
        function updatePrice() {
            if (!productVariants || productVariants.length === 0) return;

            // Lấy các thuộc tính đang được chọn
            const selectedAttrs = {};
            document.querySelectorAll('.attr-radio:checked').forEach(radio => {
                selectedAttrs[radio.dataset.attrName] = radio.value;
            });
            
            // Tìm biến thể phù hợp nhất
            let matchedVariant = null;
            for (const variant of productVariants) {
                if (!variant.attributes || variant.attributes.length === 0) continue;
                
                let isMatch = true;
                for (const attr of variant.attributes) {
                    // Nếu thuộc tính này có trong danh sách chọn mà giá trị không khớp -> bỏ qua
                    if (selectedAttrs[attr.attribute_name] && selectedAttrs[attr.attribute_name] !== attr.attribute_value) {
                        isMatch = false;
                        break;
                    }
                }
                
                if (isMatch) {
                    matchedVariant = variant;
                    break;
                }
            }
            
            // Cập nhật giá & số lượng tồn kho
            if (matchedVariant) {
                if (priceDisplay) {
                    const price = parseFloat(matchedVariant.price);
                    priceDisplay.textContent = price.toLocaleString('vi-VN').replace(/,/g, '.') + 'đ';
                }
                
                const stockDisplay = document.getElementById('stockDisplay');
                if (stockDisplay) {
                    const stock = parseInt(matchedVariant.stock_quantity !== undefined ? matchedVariant.stock_quantity : (matchedVariant.stock || 0));
                    if (stock > 0) {
                        stockDisplay.innerHTML = `<span class="text-success fw-medium"><i class="bi bi-check-circle-fill me-1"></i>Còn hàng</span>`;
                    } else {
                        stockDisplay.innerHTML = `<span class="text-danger fw-medium"><i class="bi bi-x-circle-fill me-1"></i>Hết hàng</span>`;
                    }
                }
            }
        }
        
        radios.forEach(radio => {
            radio.addEventListener('change', updatePrice);
        });
        
        // Cập nhật lần đầu khi load trang
        if(radios.length > 0) updatePrice();

        // Xử lý Click Đánh giá Sao
        const stars = document.querySelectorAll('.rating-star');
        const ratingInput = document.getElementById('ratingInput');
        const ratingText = document.getElementById('ratingText');
        
        const texts = {
            1: 'Tệ',
            2: 'Tạm được',
            3: 'Bình thường',
            4: 'Tốt',
            5: 'Tuyệt vời'
        };

        if(stars.length > 0) {
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.getAttribute('data-rating'));
                    ratingInput.value = rating;
                    ratingText.textContent = texts[rating];
                    
                    stars.forEach(s => {
                        if (parseInt(s.getAttribute('data-rating')) <= rating) {
                            s.classList.remove('bi-star');
                            s.classList.add('bi-star-fill');
                        } else {
                            s.classList.remove('bi-star-fill');
                            s.classList.add('bi-star');
                        }
                    });
                });

                star.addEventListener('mouseover', function() {
                    this.style.transform = 'scale(1.2)';
                    this.style.transition = '0.2s';
                });

                star.addEventListener('mouseout', function() {
                    this.style.transform = 'scale(1)';
                });
            });
        }
    });
</script>
