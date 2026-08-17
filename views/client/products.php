<?php
$hasCustomBanner = !empty($productBanners);
?>
<!-- Premium Page Header Slider -->
<div class="container-fluid px-4 mt-3" data-aos="fade-up">
    <div id="productCarousel" class="carousel slide shadow-lg rounded-4 overflow-hidden" data-bs-ride="carousel" data-bs-interval="6000">
        <?php if ($hasCustomBanner && count($productBanners) > 1): ?>
        <!-- Indicators -->
        <div class="carousel-indicators">
            <?php foreach ($productBanners as $index => $banner): ?>
                <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $index + 1 ?>"></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <div class="carousel-inner" style="height: 400px;">
        <?php if ($hasCustomBanner): ?>
            <?php foreach ($productBanners as $index => $banner): ?>
                <div class="carousel-item h-100 <?= $index === 0 ? 'active' : '' ?>">
                    <div class="position-absolute w-100 h-100" style="background-image: url('<?= BASE_URL ?>assets/uploads/banner/<?= $banner['image_url'] ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
                    <!-- Lớp phủ tối nhẹ để làm nổi bật breadcrumb nhưng không che mất ảnh gốc -->
                    <div class="position-absolute w-100 h-100" style="background: rgba(0,0,0,0.25);"></div>
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-end h-100 pb-4">
                        <div class="px-4 py-2 rounded-pill" style="background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0" style="font-size: 0.9rem;">
                                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?? '/' ?>" class="text-decoration-none text-white-50 hover-white">Trang chủ</a></li>
                                    <li class="breadcrumb-item active text-white fw-bold" aria-current="page">Sản phẩm</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Fallback tĩnh nếu không có banner -->
            <div class="carousel-item active h-100">
                <div class="position-absolute w-100 h-100" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                    <!-- Svg pattern -->
                    <div class="position-absolute w-100 h-100 opacity-50" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                </div>
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center h-100">
                    <h1 class="fw-bold mb-3 display-5 text-white" style="letter-spacing: -1px; text-shadow: 0 4px 15px rgba(0,0,0,0.8);">Khám Phá Công Nghệ Đỉnh Cao</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0" style="text-shadow: 0 2px 10px rgba(0,0,0,0.8);">
                            <li class="breadcrumb-item"><a href="<?= BASE_URL ?? '/' ?>" class="text-decoration-none text-white-50 hover-white">Trang chủ</a></li>
                            <li class="breadcrumb-item active text-white fw-medium" aria-current="page">Sản phẩm</li>
                        </ol>
                    </nav>
                </div>
            </div>
        <?php endif; ?>
        </div>
        
        <?php if ($hasCustomBanner && count($productBanners) > 1): ?>
        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev" style="width: 5%; opacity: 1;">
            <span class="carousel-control-prev-icon p-3 bg-dark bg-opacity-50 rounded-circle" aria-hidden="true" style="width: 50px; height: 50px;"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next" style="width: 5%; opacity: 1;">
            <span class="carousel-control-next-icon p-3 bg-dark bg-opacity-50 rounded-circle" aria-hidden="true" style="width: 50px; height: 50px;"></span>
            <span class="visually-hidden">Next</span>
        </button>
        <?php endif; ?>
    </div>
</div>

<!-- Shop Content -->
<div class="container py-5 my-3">
    <div class="row g-5">
        <!-- Sidebar Filter -->
        <div class="col-lg-3">
            <style>
                .filter-sidebar { border-radius: 1.25rem; border: 1px solid rgba(0,0,0,0.05) !important; box-shadow: 0 10px 40px rgba(0,0,0,0.03) !important; }
                .filter-header { cursor: pointer; user-select: none; transition: all 0.2s ease; }
                .filter-header:hover { color: var(--primary-color); }
                .filter-header .toggle-icon { transition: transform 0.3s ease; font-size: 0.75rem; background: #f1f5f9; width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; border-radius: 50%; color: #64748b; }
                .filter-header:hover .toggle-icon { background: rgba(var(--primary-rgb, 13, 110, 253), 0.1); color: var(--primary-color); }
                .filter-header.collapsed .toggle-icon { transform: rotate(-180deg); }
                
                /* Custom Checkbox & Radio */
                .form-check-input { width: 1.2rem; height: 1.2rem; margin-top: 0.15rem; border: 2px solid #cbd5e1; cursor: pointer; transition: all 0.2s ease; border-radius: 4px; }
                .form-check-input[type="radio"] { border-radius: 50%; }
                .form-check-input:checked { background-color: var(--primary-color); border-color: var(--primary-color); }
                .form-check-input:focus { box-shadow: 0 0 0 4px rgba(var(--primary-rgb, 13, 110, 253), 0.15); border-color: var(--primary-color); }
                .form-check-label { cursor: pointer; font-size: 0.95rem; font-weight: 500; transition: color 0.2s ease; margin-left: 0.5rem; color: #475569; }
                .form-check-input:checked + .form-check-label { color: var(--primary-color) !important; font-weight: 700; }
                .form-check-label:hover { color: var(--primary-color) !important; }
                
                /* Pill Buttons for Brands */
                .filter-sidebar { border-radius: 1.25rem; border: 1px solid rgba(0,0,0,0.05) !important; box-shadow: 0 10px 40px rgba(0,0,0,0.03) !important; }
                .filter-header { cursor: pointer; user-select: none; transition: all 0.2s ease; }
                .filter-header:hover { color: var(--primary-color); }
                .filter-header .toggle-icon { transition: transform 0.3s ease; font-size: 0.75rem; background: #f1f5f9; width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; border-radius: 50%; color: #64748b; }
                .filter-header:hover .toggle-icon { background: rgba(var(--primary-rgb, 13, 110, 253), 0.1); color: var(--primary-color); }
                .filter-header.collapsed .toggle-icon { transform: rotate(-180deg); }
                
                /* Custom Checkbox & Radio */
                .form-check-input { width: 1.2rem; height: 1.2rem; margin-top: 0.15rem; border: 2px solid #cbd5e1; cursor: pointer; transition: all 0.2s ease; border-radius: 4px; }
                .form-check-input[type="radio"] { border-radius: 50%; }
                .form-check-input:checked { background-color: var(--primary-color); border-color: var(--primary-color); }
                .form-check-input:focus { box-shadow: 0 0 0 4px rgba(var(--primary-rgb, 13, 110, 253), 0.15); border-color: var(--primary-color); }
                .form-check-label { cursor: pointer; font-size: 0.95rem; font-weight: 500; transition: color 0.2s ease; margin-left: 0.5rem; color: #475569; }
                .form-check-input:checked + .form-check-label { color: var(--primary-color) !important; font-weight: 700; }
                .form-check-label:hover { color: var(--primary-color) !important; }
                
                /* Pill Buttons for Brands & Attributes */
                .btn-check:checked + .btn-outline-secondary { background-color: var(--primary-color); border-color: var(--primary-color); color: white; box-shadow: 0 4px 12px rgba(var(--primary-rgb, 13, 110, 253), 0.25); }
                .btn-outline-secondary { border: 2px solid #e2e8f0; color: #64748b; font-weight: 600; border-radius: 0.75rem; transition: all 0.2s ease; padding: 0.4rem 0.5rem; }
                .btn-outline-secondary:hover { border-color: var(--primary-color); color: var(--primary-color); background: rgba(var(--primary-rgb, 13, 110, 253), 0.05); }
            </style>
            <form id="filterForm" method="GET" action="" class="bg-white filter-sidebar p-4 sticky-top" style="top: 100px;">
                <input type="hidden" name="action" value="products">
                <?php if(isset($_GET['keyword'])): ?>
                    <input type="hidden" name="keyword" value="<?= htmlspecialchars($_GET['keyword']) ?>">
                <?php endif; ?>
                
                <h5 class="fw-bold mb-4 border-bottom pb-3">Bộ Lọc Tìm Kiếm</h5>
                
                <!-- Category Filter -->
                <div class="mb-4 border-bottom pb-3">
                    <div class="filter-header d-flex justify-content-between align-items-center mb-3" data-bs-toggle="collapse" data-bs-target="#collapseCat" aria-expanded="true">
                        <h6 class="fw-bold mb-0">Danh Mục</h6>
                        <i class="bi bi-chevron-up toggle-icon text-muted"></i>
                    </div>
                    <div class="collapse show" id="collapseCat">
                        <?php 
                        $selectedCats = isset($_GET['categories']) ? (array)$_GET['categories'] : [];
                        foreach($allCategories as $cat): 
                            $isChecked = in_array($cat['category_id'], $selectedCats) ? 'checked' : '';
                        ?>
                        <div class="form-check mb-2">
                            <input class="form-check-input filter-checkbox" type="checkbox" name="categories[]" value="<?= $cat['category_id'] ?>" id="cat_<?= $cat['category_id'] ?>" <?= $isChecked ?> onchange="submitFilter()">
                            <label class="form-check-label text-muted" for="cat_<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Brand Filter -->
                <div class="mb-4 border-bottom pb-3">
                    <div class="filter-header d-flex justify-content-between align-items-center mb-3" data-bs-toggle="collapse" data-bs-target="#collapseBrand" aria-expanded="true">
                        <h6 class="fw-bold mb-0">Thương Hiệu</h6>
                        <i class="bi bi-chevron-up toggle-icon text-muted"></i>
                    </div>
                    <div class="collapse show" id="collapseBrand">
                        <div class="row g-2">
                            <?php 
                            $selectedBrands = isset($_GET['brands']) ? (array)$_GET['brands'] : [];
                            foreach($allBrands as $brand): 
                                $isChecked = in_array($brand['brand_id'], $selectedBrands) ? 'checked' : '';
                            ?>
                            <div class="col-6">
                                <input class="btn-check filter-checkbox" type="checkbox" name="brands[]" value="<?= $brand['brand_id'] ?>" id="brand_<?= $brand['brand_id'] ?>" <?= $isChecked ?> onchange="submitFilter()">
                                <label class="btn btn-outline-secondary w-100 btn-sm text-truncate" for="brand_<?= $brand['brand_id'] ?>"><?= htmlspecialchars($brand['brand_name']) ?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Price Filter -->
                <div class="mb-4 border-bottom pb-3">
                    <div class="filter-header d-flex justify-content-between align-items-center mb-3" data-bs-toggle="collapse" data-bs-target="#collapsePrice" aria-expanded="true">
                        <h6 class="fw-bold mb-0">Khoảng Giá</h6>
                        <i class="bi bi-chevron-up toggle-icon text-muted"></i>
                    </div>
                    <div class="collapse show" id="collapsePrice">
                        <?php
                            $minP = isset($_GET['price_min']) && $_GET['price_min'] !== '' ? (int)$_GET['price_min'] : 0;
                            $maxP = isset($_GET['price_max']) && $_GET['price_max'] !== '' ? (int)$_GET['price_max'] : 50000000;
                        ?>
                        <div class="px-2 pt-3 pb-4">
                            <!-- Custom Range Slider HTML -->
                            <div class="price-slider-wrapper position-relative" style="height: 5px; background: #e2e8f0; border-radius: 5px;">
                                <div class="price-slider-track position-absolute h-100 bg-primary" style="left: 0%; right: 0%; border-radius: 5px;"></div>
                                <input type="range" id="priceRangeMin" min="0" max="50000000" step="500000" value="<?= $minP ?>" class="position-absolute w-100 price-range-input" style="top: -7px; pointer-events: none; -webkit-appearance: none; background: transparent; z-index: 3;">
                                <input type="range" id="priceRangeMax" min="0" max="50000000" step="500000" value="<?= $maxP ?>" class="position-absolute w-100 price-range-input" style="top: -7px; pointer-events: none; -webkit-appearance: none; background: transparent; z-index: 4;">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div class="input-group input-group-sm w-45">
                                <span class="input-group-text bg-light border-0">đ</span>
                                <input type="text" class="form-control text-center border-0 bg-light rounded-end" id="priceLabelMin" value="<?= number_format($minP, 0, ',', '.') ?>" readonly style="font-size: 0.8rem; font-weight: 600;">
                            </div>
                            <span class="text-muted">-</span>
                            <div class="input-group input-group-sm w-45">
                                <span class="input-group-text bg-light border-0">đ</span>
                                <input type="text" class="form-control text-center border-0 bg-light rounded-end" id="priceLabelMax" value="<?= number_format($maxP, 0, ',', '.') ?>" readonly style="font-size: 0.8rem; font-weight: 600;">
                            </div>
                        </div>
                        
                        <!-- Hidden inputs for form submission -->
                        <input type="hidden" name="price_min" id="input_price_min" value="<?= htmlspecialchars($minP) ?>">
                        <input type="hidden" name="price_max" id="input_price_max" value="<?= htmlspecialchars($maxP) ?>">
                        
                        <button type="button" class="btn btn-primary w-100 mt-3 btn-sm rounded-pill fw-bold" onclick="submitFilter()">Áp dụng giá</button>

                        <style>
                            .price-range-input::-webkit-slider-thumb {
                                -webkit-appearance: none;
                                pointer-events: auto;
                                width: 18px;
                                height: 18px;
                                background-color: #fff;
                                border: 2px solid var(--primary-color);
                                border-radius: 50%;
                                cursor: pointer;
                                box-shadow: 0 2px 6px rgba(0,0,0,0.15);
                            }
                            .price-range-input::-moz-range-thumb {
                                pointer-events: auto;
                                width: 18px;
                                height: 18px;
                                background-color: #fff;
                                border: 2px solid var(--primary-color);
                                border-radius: 50%;
                                cursor: pointer;
                                box-shadow: 0 2px 6px rgba(0,0,0,0.15);
                            }
                            .w-45 { width: 45%; }
                        </style>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const rangeMin = document.getElementById('priceRangeMin');
                                const rangeMax = document.getElementById('priceRangeMax');
                                const labelMin = document.getElementById('priceLabelMin');
                                const labelMax = document.getElementById('priceLabelMax');
                                const inputMin = document.getElementById('input_price_min');
                                const inputMax = document.getElementById('input_price_max');
                                const track = document.querySelector('.price-slider-track');
                                
                                function updateSlider() {
                                    let minVal = parseInt(rangeMin.value);
                                    let maxVal = parseInt(rangeMax.value);
                                    
                                    if(minVal >= maxVal - 500000) {
                                        if(this.id === 'priceRangeMin') {
                                            rangeMin.value = maxVal - 500000;
                                            minVal = parseInt(rangeMin.value);
                                        } else {
                                            rangeMax.value = minVal + 500000;
                                            maxVal = parseInt(rangeMax.value);
                                        }
                                    }
                                    
                                    // Calculate percentage for track
                                    const maxRange = parseInt(rangeMin.max);
                                    const minPercent = (minVal / maxRange) * 100;
                                    const maxPercent = (maxVal / maxRange) * 100;
                                    
                                    track.style.left = minPercent + '%';
                                    track.style.right = (100 - maxPercent) + '%';
                                    
                                    // Update labels
                                    labelMin.value = new Intl.NumberFormat('vi-VN').format(minVal);
                                    labelMax.value = new Intl.NumberFormat('vi-VN').format(maxVal);
                                    
                                    // Update hidden inputs
                                    inputMin.value = minVal;
                                    inputMax.value = maxVal;
                                }
                                
                                rangeMin.addEventListener('input', updateSlider);
                                rangeMax.addEventListener('input', updateSlider);
                                
                                // Initialize track
                                updateSlider.call(rangeMin);
                            });
                        </script>
                    </div>
                </div>
                
                <!-- Dynamic Attributes Filter -->
                <?php 
                $selectedAttrsGrouped = isset($_GET['attributes']) && is_array($_GET['attributes']) ? $_GET['attributes'] : [];
                // Flat array to easily check if a value is selected, just in case
                $flatSelectedAttrs = [];
                if (!empty($selectedAttrsGrouped)) {
                    if (is_array(current($selectedAttrsGrouped))) {
                        foreach ($selectedAttrsGrouped as $attrGroup) {
                            $flatSelectedAttrs = array_merge($flatSelectedAttrs, $attrGroup);
                        }
                    } else {
                        $flatSelectedAttrs = $selectedAttrsGrouped; // Fallback if still flat
                    }
                }
                
                foreach($allAttributes as $attrId => $attrData): 
                ?>
                <div class="mb-4 border-bottom pb-3">
                    <div class="filter-header d-flex justify-content-between align-items-center mb-3" data-bs-toggle="collapse" data-bs-target="#collapseAttr<?= $attrId ?>" aria-expanded="true">
                        <h6 class="fw-bold mb-0"><?= htmlspecialchars($attrData['attribute_name']) ?></h6>
                        <i class="bi bi-chevron-up toggle-icon text-muted"></i>
                    </div>
                    <div class="collapse show" id="collapseAttr<?= $attrId ?>">
                        <div class="d-flex flex-wrap gap-2 pt-1">
                            <?php foreach($attrData['values'] as $val): 
                                $isChecked = in_array($val['attribute_value_id'], $flatSelectedAttrs) ? 'checked' : '';
                            ?>
                            <div class="flex-fill" style="min-width: 45%;">
                                <input class="btn-check filter-checkbox" type="checkbox" name="attributes[<?= $attrId ?>][]" value="<?= $val['attribute_value_id'] ?>" id="attr_<?= $val['attribute_value_id'] ?>" <?= $isChecked ?> onchange="submitFilter()">
                                <label class="btn btn-outline-secondary w-100 btn-sm text-truncate" for="attr_<?= $val['attribute_value_id'] ?>"><?= htmlspecialchars($val['attribute_value']) ?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Other Filters -->
                <div class="mb-4">
                    <div class="filter-header d-flex justify-content-between align-items-center mb-3" data-bs-toggle="collapse" data-bs-target="#collapseOther" aria-expanded="true">
                        <h6 class="fw-bold mb-0">Tình Trạng & Đánh Giá</h6>
                        <i class="bi bi-chevron-up toggle-icon text-muted"></i>
                    </div>
                    <div class="collapse show" id="collapseOther">
                        <div class="form-check mb-2">
                            <input class="form-check-input filter-checkbox" type="checkbox" name="in_stock" value="1" id="in_stock" <?= isset($_GET['in_stock']) ? 'checked' : '' ?> onchange="submitFilter()">
                            <label class="form-check-label text-muted" for="in_stock">Còn hàng</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input filter-checkbox" type="checkbox" name="min_rating" value="4" id="min_rating" <?= (isset($_GET['min_rating']) && $_GET['min_rating'] == 4) ? 'checked' : '' ?> onchange="submitFilter()">
                            <label class="form-check-label text-muted" for="min_rating">Từ 4 sao trở lên</label>
                        </div>
                    </div>
                </div>

                <a href="?action=products" class="btn btn-outline-dark w-100 rounded-pill fw-bold py-2 mt-2">Xóa bộ lọc</a>
                <!-- Hidden input for sort -->
                <input type="hidden" name="sort" id="input_sort" value="<?= htmlspecialchars($_GET['sort'] ?? '') ?>">
            </form>
        </div>

        <!-- Product Grid -->
        <div class="col-lg-9" id="ajax-product-container">
            <!-- Toolbar -->
            <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded-4 shadow-sm border">
                <p class="mb-0 text-muted">Hiển thị <span class="fw-bold text-dark"><?= count($products) ?></span> trên <span class="fw-bold text-dark"><?= $totalProducts ?></span> sản phẩm</p>
                <div class="d-flex align-items-center gap-3">
                    <label class="text-muted text-nowrap mb-0 d-none d-md-block">Sắp xếp theo:</label>
                    <?php $currentSort = $_GET['sort'] ?? ''; ?>
                    <select class="form-select border-0 bg-light rounded-pill px-4 fw-medium" id="sortSelect" style="width: auto; cursor: pointer;" onchange="submitFilter()">
                        <option value="" <?= $currentSort == '' ? 'selected' : '' ?>>Mới nhất</option>
                        <option value="price_asc" <?= $currentSort == 'price_asc' ? 'selected' : '' ?>>Giá tăng dần</option>
                        <option value="price_desc" <?= $currentSort == 'price_desc' ? 'selected' : '' ?>>Giá giảm dần</option>
                        <option value="best_selling" <?= $currentSort == 'best_selling' ? 'selected' : '' ?>>Bán chạy nhất</option>
                        <option value="top_rated" <?= $currentSort == 'top_rated' ? 'selected' : '' ?>>Đánh giá cao nhất</option>
                    </select>
                </div>
            </div>

            <!-- Products -->
            <div class="row g-4">
                <?php $delay = 0; foreach($products as $product): ?>
                <div class="col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
                    <div class="product-card-premium bg-white rounded-4 h-100 d-flex flex-column position-relative overflow-hidden transition-all" style="box-shadow: 0 10px 30px rgba(0,0,0,0.04); border: 1px solid rgba(0,0,0,0.02);">
                        <div class="card-img-wrap bg-light position-relative p-4 rounded-top-4 d-flex align-items-center justify-content-center overflow-hidden" style="height: 250px;" onmouseover="this.querySelector('.hover-overlay').style.opacity='1'" onmouseout="this.querySelector('.hover-overlay').style.opacity='0'">
                            <!-- Thẻ trạng thái/Khuyến mãi -->
                            <?php if(isset($product['status']) && $product['status'] == 'new'): ?>
                                <span class="badge bg-danger bg-gradient shadow-sm px-3 py-2 rounded-pill fw-bold position-absolute" style="top: 15px; right: 15px; z-index: 10; font-size:0.7rem; letter-spacing: 1px;"><i class="bi bi-stars"></i> MỚI</span>
                            <?php endif; ?>
                            
                            <a href="<?= BASE_URL ?>?action=product-detail&id=<?= $product['product_id'] ?>" class="d-block w-100 h-100 position-relative">
                                <?php
                                $img = $product['image'] ?? '';
                                $imgName = !empty($img) ? basename($img) : '';
                                $imgUrl = !empty($imgName) ? BASE_ASSETS_UPLOADS . 'products/' . $imgName : 'https://placehold.co/400x400/e2e8f0/64748b?text=IMG';
                                ?>
                                <img src="<?= htmlspecialchars($imgUrl) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" style="object-fit: contain; width: 100%; height: 100%; transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); z-index: 2; position: relative;" class="product-img-main drop-shadow-md">
                            </a>
                            
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
                        <div class="product-info p-4 flex-grow-1 d-flex flex-column bg-white rounded-bottom-4">
                            <p class="text-muted mb-2 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 1.5px;">
                                <?= htmlspecialchars($product['brand_name'] ?? 'Thương hiệu') ?>
                            </p>
                            <a href="<?= BASE_URL ?>?action=product-detail&id=<?= $product['product_id'] ?>" class="text-decoration-none text-dark mb-3">
                                <h5 class="fw-bold mb-0 text-dark hover-primary lh-base" style="font-size: 1.1rem; letter-spacing: -0.3px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?= htmlspecialchars($product['product_name']) ?>
                                </h5>
                            </a>
                            
                            <div class="mt-auto pt-3 border-top border-gray-100">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="text-dark fw-bold" style="font-size: 1.2rem; letter-spacing: -0.5px;"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</span>
                                    <button class="btn btn-light rounded-circle text-muted hover-primary transition-all p-2" style="width: 40px; height: 40px;" onclick="window.location.href='<?= BASE_URL ?>?action=product-detail&id=<?= $product['product_id'] ?>'">
                                        <i class="bi bi-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $delay += 100; if($delay > 200) $delay = 0; endforeach; ?>
            </div>

            <!-- Pagination -->
            <div class="mt-5 pt-4 d-flex justify-content-center border-top">
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-lg gap-2">
                        <?php
                        $totalPages = ceil($totalProducts / $limit);
                        // Build query string for pagination links
                        $queryParams = $_GET;
                        unset($queryParams['page']);
                        $queryString = http_build_query($queryParams);
                        
                        $prevPage = $page > 1 ? $page - 1 : 1;
                        $nextPage = $page < $totalPages ? $page + 1 : $totalPages;
                        ?>
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link rounded-circle border-0 text-dark" href="?<?= $queryString ?>&page=<?= $prevPage ?>" tabindex="-1" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-chevron-left"></i></a>
                        </li>
                        
                        <?php for($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link rounded-circle border-0 <?= ($i == $page) ? 'shadow-sm' : 'text-dark' ?>" href="?<?= $queryString ?>&page=<?= $i ?>" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; <?= ($i == $page) ? 'background-color: var(--primary-color);' : '' ?>"><?= $i ?></a>
                        </li>
                        <?php endfor; ?>
                        
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link rounded-circle border-0 text-dark" href="?<?= $queryString ?>&page=<?= $nextPage ?>" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
function submitFilter(page = 1) {
    try {
        var filterForm = document.getElementById('filterForm');
        if (!filterForm) return;

        var inputPriceMin = document.getElementById('input_price_min');
        var inputPriceMax = document.getElementById('input_price_max');
        var inputSort = document.getElementById('input_sort');
        var sortSelect = document.getElementById('sortSelect');
        
        // Handle sort
        if (sortSelect && inputSort) {
            inputSort.value = sortSelect.value;
        }

        const formData = new FormData(filterForm);
        const searchParams = new URLSearchParams();
        
        for (const [key, value] of formData.entries()) {
            if(value !== '') {
                searchParams.append(key, value);
            }
        }
        searchParams.set('page', page);
        searchParams.set('ajax', '1');
        
        // Ensure action is explicitly in searchParams if missing
        if (!searchParams.has('action')) {
            searchParams.set('action', 'products');
        }
        
        const url = '?' + searchParams.toString();
        const displayUrl = url.replace('&ajax=1', '');
        
        // Update URL bar
        try {
            window.history.pushState({path: displayUrl}, '', displayUrl);
        } catch(e) {
            console.warn("History API failed:", e);
        }

        const container = document.getElementById('ajax-product-container');
        if (container) {
            container.style.opacity = '0.5';
            container.style.pointerEvents = 'none';
        }

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            cache: 'no-store'
        })
        .then(res => {
            if (!res.ok) throw new Error("Network response was not ok");
            return res.text();
        })
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newContainer = doc.getElementById('ajax-product-container');
            
            if (newContainer && container) {
                container.innerHTML = newContainer.innerHTML;
                container.style.opacity = '1';
                container.style.pointerEvents = 'auto';
                
                const newSortSelect = document.getElementById('sortSelect');
                if (newSortSelect) {
                    newSortSelect.addEventListener('change', () => submitFilter(1));
                }
                
                // Re-initialize AOS for newly added elements
                if (typeof AOS !== 'undefined') {
                    AOS.init();
                }
            } else {
                // If DOMParser fails, fallback to normal page load
                window.location.href = displayUrl;
            }
        })
        .catch(err => {
            console.error("AJAX Fetch Error:", err);
            // Fallback to normal navigation
            window.location.href = displayUrl;
        });
    } catch(err) {
        console.error("submitFilter Error:", err);
    }
}

document.addEventListener('click', function(e) {
    const pageLink = e.target.closest('a.page-link');
    if (pageLink && pageLink.href) {
        e.preventDefault();
        try {
            // Using URLSearchParams directly on the search string is safer
            let hrefStr = pageLink.getAttribute('href');
            if (hrefStr && hrefStr.indexOf('?') !== -1) {
                let qs = hrefStr.substring(hrefStr.indexOf('?'));
                let sp = new URLSearchParams(qs);
                let page = sp.get('page');
                if (page) {
                    submitFilter(page);
                    window.scrollTo({ top: 100, behavior: 'smooth' });
                }
            }
        } catch (err) {
            console.error("Pagination Error:", err);
            window.location.href = pageLink.href; // Fallback
        }
    }
});
</script>
