<<<<<<< HEAD

    </div>
                <div class="col-md-6">
=======
<?php
/** @var array $categories */
/** @var array $brands */
/** @var array $variants */
/** @var array|null $product */
/** @var int $id */
?>
<div class="row g-4">
    <div class="col-lg-12">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-8">
                    <div class="admin-form-card">
                        <h6 class="fw-bold mb-4"><i class="bi bi-box-seam me-2"></i>Thông tin sản phẩm</h6>

                        <div class="mb-3">
                            <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="product_name"
                                value="<?= htmlspecialchars($product['product_name'] ?? '') ?>"
                                placeholder="Nhập tên sản phẩm..." required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                                <select class="form-select" name="category_id" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['category_id'] ?>" <?= (isset($product['category_id']) && $product['category_id'] == $cat['category_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat['category_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
>>>>>>> 9151ec9 (quan-li-san-pham)
                                <label class="form-label">Thương hiệu</label>
                                <select class="form-select" name="brand_id">
                                    <option value="">-- Chọn thương hiệu --</option>
                                    <?php foreach ($brands as $brand): ?>
                                        <option value="<?= $brand['brand_id'] ?>" <?= (isset($product['brand_id']) && $product['brand_id'] == $brand['brand_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($brand['brand_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
<<<<<<< HEAD
                        </div>
=======
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="price" id="priceInput"
                                    value="<?= number_format($product['price'] ?? 0, 0, '', '.') ?>" placeholder="Ví dụ: 15.000.000" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Số lượng kho <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="stock"
                                    value="<?= htmlspecialchars($product['stock'] ?? 0) ?>" placeholder="Số lượng" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Thời gian bảo hành (tháng)</label>
                                <input type="number" class="form-control" name="warranty_period"
                                    value="<?= htmlspecialchars($product['warranty_period'] ?? '') ?>" placeholder="12">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mô tả chi tiết</label>
                            <textarea class="form-control" name="description" rows="6"
                                placeholder="Mô tả chi tiết sản phẩm..."><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="fw-bold mb-3 mt-4"><i class="bi bi-list-stars me-2"></i>Các tùy chọn (Màu sắc, Phiên bản)</h6>
                            <div id="variantsContainer">
                                <?php if (!empty($variants)): ?>
                                    <?php foreach ($variants as $idx => $v): ?>
                                    <div class="row g-2 mb-2 variant-row align-items-center">
                                        <div class="col-md-5">
                                            <input type="hidden" name="variant_id[]" value="<?= $v['variant_id'] ?>">
                                            <input type="text" class="form-control form-control-sm" name="variant_name[]" value="<?= htmlspecialchars($v['variant_name']) ?>" placeholder="Tên (VD: Đen 256GB)" required>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control form-control-sm" name="variant_price[]" value="<?= htmlspecialchars($v['price'] ?? '') ?>" placeholder="Giá (nếu có)">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" class="form-control form-control-sm" name="variant_stock[]" value="<?= htmlspecialchars($v['stock_quantity'] ?? '') ?>" placeholder="Tồn kho">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-sm btn-outline-danger w-100" onclick="this.closest('.variant-row').remove();"><i class="bi bi-trash"></i></button>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <!-- Empty row for new entry -->
                                    <div class="row g-2 mb-2 variant-row align-items-center">
                                        <div class="col-md-5">
                                            <input type="hidden" name="variant_id[]" value="">
                                            <input type="text" class="form-control form-control-sm" name="variant_name[]" value="" placeholder="Tên (VD: Đen 256GB)">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control form-control-sm" name="variant_price[]" value="" placeholder="Giá (nếu có)">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" class="form-control form-control-sm" name="variant_stock[]" value="" placeholder="Tồn kho">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-sm btn-outline-danger w-100" onclick="this.closest('.variant-row').remove();"><i class="bi bi-trash"></i></button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addVariantRow()">
                                <i class="bi bi-plus-lg me-1"></i> Thêm tùy chọn
                            </button>
                        </div>
                    </div>
                </div>

                <script>
                function addVariantRow() {
                    const container = document.getElementById('variantsContainer');
                    const html = `
                    <div class="row g-2 mb-2 variant-row align-items-center">
                        <div class="col-md-5">
                            <input type="hidden" name="variant_id[]" value="">
                            <input type="text" class="form-control form-control-sm" name="variant_name[]" placeholder="Tên (VD: Đen 256GB)" required>
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="form-control form-control-sm" name="variant_price[]" placeholder="Giá (nếu có)">
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control form-control-sm" name="variant_stock[]" placeholder="Tồn kho">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-sm btn-outline-danger w-100" onclick="this.closest('.variant-row').remove();"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                    `;
                    container.insertAdjacentHTML('beforeend', html);
                }
                </script>

                <!-- Side settings -->
                <div class="col-lg-4">
                    <div class="admin-form-card mb-4">
                        <h6 class="fw-bold mb-3">Trạng thái</h6>
                        <select class="form-select" name="status">
                            <option value="active" <?= (!isset($product['status']) || $product['status'] === 'active' || $product['status'] == 1) ? 'selected' : '' ?>>Hiển thị</option>
                            <option value="inactive" <?= (isset($product['status']) && ($product['status'] === 'inactive' || $product['status'] == 0)) ? 'selected' : '' ?>>Ẩn</option>
                        </select>
                    </div>

                    <div class="admin-form-card mb-4">
                        <h6 class="fw-bold mb-3">Hình ảnh</h6>
                        <?php if (!empty($product['image'])): ?>
                            <div class="mb-3">
                                <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image"
                                    class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                        <?php endif; ?>
                        <div class="upload-area">
                            <i class="bi bi-cloud-arrow-up d-block"></i>
                            <p>Kéo thả hình ảnh hoặc <strong class="text-accent">click để chọn</strong></p>
                        </div>
                        <input type="file" id="productImage" name="image" accept="image/*" class="d-none"
                            <?= empty($product['image']) ? 'required' : '' ?>>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-accent">
                            <i class="bi bi-check-lg me-1"></i> Lưu sản phẩm
                        </button>
                        <a href="<?= BASE_URL ?>?action=admin-products" class="btn btn-outline-secondary rounded-pill">
                            <i class="bi bi-x-lg me-1"></i> Hủy
                        </a>
                    </div>
                    <?php if ($id): ?>
                    <hr>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-danger" onclick="if(confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) { document.getElementById('deleteForm').submit(); }">
                            <i class="bi bi-trash me-1"></i> Xóa sản phẩm
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </form>
        <?php if ($id): ?>
        <form id="deleteForm" method="POST" action="<?= BASE_URL ?>?action=admin-products">
            <input type="hidden" name="action_type" value="delete">
            <input type="hidden" name="product_id" value="<?= $id ?>">
        </form>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const priceInput = document.getElementById('priceInput');
    if (priceInput) {
        priceInput.addEventListener('input', function(e) {
            // Remove non-numeric characters
            let value = this.value.replace(/[^0-9]/g, '');
            if (value !== '') {
                // Format with dots
                this.value = parseInt(value, 10).toLocaleString('vi-VN').replace(/,/g, '.');
            } else {
                this.value = '';
            }
        });
    }
});
</script>
>>>>>>> 9151ec9 (quan-li-san-pham)
