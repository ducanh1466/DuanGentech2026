<!-- Page Header -->
<div class="bg-gray-100 py-4 border-bottom">
    <div class="container text-center">
        <h1 class="fw-bold mb-2">Tất Cả Sản Phẩm</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="?action=/" class="text-decoration-none text-muted hover-primary">Trang chủ</a></li>
                <li class="breadcrumb-item active text-dark fw-medium" aria-current="page">Sản phẩm</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Slider Banner Header -->
<div class="container mt-4" data-aos="fade-up">
    <div class="w-100 rounded-4 overflow-hidden shadow-float">
        <!-- SLIDER BANNER CHÍNH -->
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <!-- Chấm tròn chuyển slide -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            
            <!-- Khu vực chứa các ảnh -->
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="4000">
                    <img src="DUONG_DAN_ANH_BANNER_1.jpg" class="d-block w-100" alt="Banner 1" style="object-fit: cover; max-height: 400px; min-height: 250px;">
                </div>
                <div class="carousel-item" data-bs-interval="4000">
                    <img src="DUONG_DAN_ANH_BANNER_2.jpg" class="d-block w-100" alt="Banner 2" style="object-fit: cover; max-height: 400px; min-height: 250px;">
                </div>
                <div class="carousel-item" data-bs-interval="4000">
                    <img src="DUONG_DAN_ANH_BANNER_3.jpg" class="d-block w-100" alt="Banner 3" style="object-fit: cover; max-height: 400px; min-height: 250px;">
                </div>
            </div>
            
            <!-- Nút bấm trái phải -->
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Trước</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Sau</span>
            </button>
        </div>
    </div>
</div>

<!-- Shop Content -->
<div class="container py-5 my-3">
    <div class="row g-5">
        <!-- Sidebar Filter -->
        <div class="col-lg-3">
            <style>
                .filter-header { cursor: pointer; user-select: none; }
                .filter-header .toggle-icon { transition: transform 0.3s ease; font-size: 0.9rem; }
                .filter-header.collapsed .toggle-icon { transform: rotate(-180deg); }
            </style>
            <form id="filterForm" method="GET" action="" class="bg-white rounded-4 shadow-sm border p-4 sticky-top" style="top: 100px;">
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
                        <h6 class="fw-bold mb-0">Mức Giá</h6>
                        <i class="bi bi-chevron-up toggle-icon text-muted"></i>
                    </div>
                    <div class="collapse show" id="collapsePrice">
                        <?php
                            $minP = isset($_GET['price_min']) ? $_GET['price_min'] : '';
                            $maxP = isset($_GET['price_max']) ? $_GET['price_max'] : '';
                            $priceOption = $minP . '-' . $maxP;
                        ?>
                        <div class="form-check mb-2">
                            <input class="form-check-input filter-checkbox" type="radio" name="price_range" value="" id="price_all" <?= $priceOption == '-' ? 'checked' : '' ?> onchange="submitFilter()">
                            <label class="form-check-label text-muted" for="price_all">Tất cả</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input filter-checkbox" type="radio" name="price_range" value="0-5000000" id="price1" <?= $priceOption == '0-5000000' ? 'checked' : '' ?> onchange="submitFilter()">
                            <label class="form-check-label text-muted" for="price1">Dưới 5 triệu</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input filter-checkbox" type="radio" name="price_range" value="5000000-15000000" id="price2" <?= $priceOption == '5000000-15000000' ? 'checked' : '' ?> onchange="submitFilter()">
                            <label class="form-check-label text-muted" for="price2">Từ 5 - 15 triệu</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input filter-checkbox" type="radio" name="price_range" value="15000000-25000000" id="price3" <?= $priceOption == '15000000-25000000' ? 'checked' : '' ?> onchange="submitFilter()">
                            <label class="form-check-label text-muted" for="price3">Từ 15 - 25 triệu</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input filter-checkbox" type="radio" name="price_range" value="25000000-0" id="price4" <?= $priceOption == '25000000-0' ? 'checked' : '' ?> onchange="submitFilter()">
                            <label class="form-check-label text-muted" for="price4">Trên 25 triệu</label>
                        </div>
                        <!-- Hidden inputs for actual price range to be sent -->
                        <input type="hidden" name="price_min" id="input_price_min" value="<?= htmlspecialchars($minP) ?>">
                        <input type="hidden" name="price_max" id="input_price_max" value="<?= htmlspecialchars($maxP) ?>">
                    </div>
                </div>
                
                <!-- Dynamic Attributes Filter -->
                <?php 
                $selectedAttrs = isset($_GET['attributes']) ? (array)$_GET['attributes'] : [];
                foreach($allAttributes as $attrId => $attrData): 
                ?>
                <div class="mb-4 border-bottom pb-3">
                    <div class="filter-header d-flex justify-content-between align-items-center mb-3" data-bs-toggle="collapse" data-bs-target="#collapseAttr<?= $attrId ?>" aria-expanded="true">
                        <h6 class="fw-bold mb-0"><?= htmlspecialchars($attrData['attribute_name']) ?></h6>
                        <i class="bi bi-chevron-up toggle-icon text-muted"></i>
                    </div>
                    <div class="collapse show" id="collapseAttr<?= $attrId ?>">
                        <?php foreach($attrData['values'] as $val): 
                            $isChecked = in_array($val['attribute_value_id'], $selectedAttrs) ? 'checked' : '';
                        ?>
                        <div class="form-check mb-2">
                            <input class="form-check-input filter-checkbox" type="checkbox" name="attributes[]" value="<?= $val['attribute_value_id'] ?>" id="attr_<?= $val['attribute_value_id'] ?>" <?= $isChecked ?> onchange="submitFilter()">
                            <label class="form-check-label text-muted" for="attr_<?= $val['attribute_value_id'] ?>"><?= htmlspecialchars($val['attribute_value']) ?></label>
                        </div>
                        <?php endforeach; ?>
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
        <div class="col-lg-9">
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
                    <div class="product-card-premium h-100 d-flex flex-column position-relative overflow-hidden">
                        <div class="card-img-wrap bg-light position-relative">
                            <!-- Thẻ trạng thái/Khuyến mãi -->
                            <?php if(isset($product['status']) && $product['status'] == 'new'): ?>
                                <span class="badge bg-danger shadow-sm px-3 py-2 rounded-pill fw-bold position-absolute" style="top: 12px; left: 12px; z-index: 10; font-size:0.75rem; letter-spacing: 1px;"><i class="bi bi-stars"></i> MỚI</span>
                            <?php endif; ?>
                            
                            <a href="<?= BASE_URL ?>?action=product-detail&id=<?= $product['product_id'] ?>" class="d-block w-100 h-100" style="padding: 1.5rem;">
                                <img src="<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" style="object-fit: contain; width: 100%; height: 200px; transition: transform 0.5s ease;" class="product-img-main">
                            </a>
                            
                            <!-- Premium Hover Overlay -->
                            <div class="premium-hover-overlay" style="padding: 1rem;">
                                <form action="?action=cart-add" method="POST" class="ajax-add-to-cart-form w-100 d-flex justify-content-center">
                                    <input type="hidden" name="variant_id" value="<?= htmlspecialchars($product['default_variant_id'] ?? 0) ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" name="action_type" value="add_to_cart" class="btn btn-dark rounded-pill px-4 py-2 fw-medium btn-premium-add shadow-sm d-flex justify-content-center align-items-center gap-2" style="font-size: 0.9rem; transition: all 0.3s ease;">
                                        <i class="bi bi-cart-plus fs-5"></i> Thêm vào giỏ
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="product-info p-4 flex-grow-1 d-flex flex-column bg-white">
                            <p class="text-muted mb-2 text-uppercase fw-semibold" style="font-size: 0.75rem; letter-spacing: 1px;">
                                <?= htmlspecialchars($product['brand_name'] ?? 'Thương hiệu') ?>
                            </p>
                            <a href="<?= BASE_URL ?>?action=product-detail&id=<?= $product['product_id'] ?>" class="text-decoration-none text-dark mb-3">
                                <h5 class="fw-bold mb-0 text-dark hover-primary lh-base" style="font-size:1.05rem; letter-spacing: -0.2px;">
                                    <?= htmlspecialchars($product['product_name']) ?>
                                </h5>
                            </a>
                            
                            <div class="mt-auto">
                                <span class="text-dark fw-bold fs-5 d-block"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</span>
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
function submitFilter() {
    var filterForm = document.getElementById('filterForm');
    var inputPriceMin = document.getElementById('input_price_min');
    var inputPriceMax = document.getElementById('input_price_max');
    var inputSort = document.getElementById('input_sort');
    var sortSelect = document.getElementById('sortSelect');
    
    // Xử lý giá trị price_range nếu có
    var priceRadio = document.querySelector('input[name="price_range"]:checked');
    if (priceRadio && priceRadio.value) {
        var parts = priceRadio.value.split('-');
        if (inputPriceMin) inputPriceMin.value = parts[0];
        if (inputPriceMax) inputPriceMax.value = parts[1] == '0' ? '' : parts[1];
    } else {
        if (inputPriceMin) inputPriceMin.value = '';
        if (inputPriceMax) inputPriceMax.value = '';
    }

    // Xử lý sắp xếp
    if (sortSelect && inputSort) {
        inputSort.value = sortSelect.value;
    }

    if (filterForm) {
        // Fix: Đôi khi form.submit bị đè bởi một element có name="submit"
        // Dùng phương thức native an toàn hơn:
        HTMLFormElement.prototype.submit.call(filterForm);
    }
}
</script>
