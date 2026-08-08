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
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                    </div>
                    <a href="#reviews" class="text-muted text-decoration-none hover-primary">(0 đánh giá)</a>
                    <span class="text-muted">|</span>
                    <span class="text-success fw-medium"><i class="bi bi-check-circle-fill me-1"></i>Còn hàng</span>
                </div>
                <div class="mb-4">
                    <span id="productPrice" class="fs-1 fw-bold text-dark me-3"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</span>
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
            
            // Cập nhật giá
            if (matchedVariant && priceDisplay) {
                const price = parseFloat(matchedVariant.price);
                priceDisplay.textContent = price.toLocaleString('vi-VN').replace(/,/g, '.') + 'đ';
            }
        }
        
        radios.forEach(radio => {
            radio.addEventListener('change', updatePrice);
        });
        
        // Cập nhật lần đầu khi load trang
        if(radios.length > 0) updatePrice();
    });
</script>
