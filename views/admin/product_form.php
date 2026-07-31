<?php
/** @var array $categories */
/** @var array $brands */
/** @var array $variants */
/** @var array|null $product */
/** @var int $id */
?>
<div class="row g-4 justify-content-center">
    <div class="col-lg-10">
        <div class="admin-form-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0"><?= $id ? 'Chỉnh sửa sản phẩm' : 'Thêm sản phẩm mới' ?></h5>
            </div>

            <form method="POST" action="" enctype="multipart/form-data">
                
                <!-- Row 1 -->
                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-2">
                        <label class="form-horizontal-label">Trạng thái <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="status">
                            <option value="active" <?= (!isset($product['status']) || $product['status'] === 'active' || $product['status'] == 1) ? 'selected' : '' ?>>Hiển thị</option>
                            <option value="inactive" <?= (isset($product['status']) && ($product['status'] === 'inactive' || $product['status'] == 0)) ? 'selected' : '' ?>>Ẩn</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-horizontal-label ps-md-4">Tên sản phẩm <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="product_name"
                            value="<?= htmlspecialchars($product['product_name'] ?? '') ?>" required>
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-2">
                        <label class="form-horizontal-label">Danh mục <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="category_id" required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['category_id'] ?>" <?= (isset($product['category_id']) && $product['category_id'] == $cat['category_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['category_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-horizontal-label ps-md-4">Thương hiệu</label>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="brand_id">
                            <option value="">-- Chọn thương hiệu --</option>
                            <?php foreach ($brands as $brand): ?>
                            <option value="<?= $brand['brand_id'] ?>" <?= (isset($product['brand_id']) && $product['brand_id'] == $brand['brand_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($brand['brand_name']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-2">
                        <label class="form-horizontal-label">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="price" id="priceInput"
                            value="<?= number_format($product['price'] ?? 0, 0, '', '.') ?>" required>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-horizontal-label ps-md-4">Kho / Bảo hành</label>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex gap-2">
                            <input type="number" class="form-control" name="stock"
                                value="<?= htmlspecialchars($product['stock'] ?? 0) ?>" placeholder="SL" required>
                            <input type="number" class="form-control" name="warranty_period"
                                value="<?= htmlspecialchars($product['warranty_period'] ?? '') ?>" placeholder="Bảo hành (tháng)">
                        </div>
                    </div>
                </div>

                <!-- Row 4 -->
                <div class="row form-horizontal-row">
                    <div class="col-md-2">
                        <label class="form-horizontal-label">Mô tả</label>
                    </div>
                    <div class="col-md-10">
                        <textarea class="form-control" name="description" rows="4"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                    </div>
                </div>

                <!-- Row 5 -->
                <div class="row form-horizontal-row">
                    <div class="col-md-2">
                        <label class="form-horizontal-label">Hình ảnh</label>
                    </div>
                    <div class="col-md-10">
                        <?php if (!empty($product['image'])): ?>
                            <div class="mb-3">
                                <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image"
                                    class="img-fluid rounded" style="max-height: 150px; border: 1px solid #e2e8f0;">
                            </div>
                        <?php endif; ?>
                        <div class="upload-area p-3 text-center" style="border: 2px dashed #cbd5e1; border-radius: 8px; cursor: pointer;">
                            <i class="bi bi-image text-muted fs-4"></i>
                            <p class="mb-0 text-muted">Click để tải lên hình ảnh mới</p>
                        </div>
                        <input type="file" id="productImage" name="image" accept="image/*" class="d-none"
                            <?= empty($product['image']) ? 'required' : '' ?>>
                    </div>
                </div>

                <!-- Row 6: Variants -->
                <div class="row form-horizontal-row">
                    <div class="col-md-2">
                        <label class="form-horizontal-label">Tùy chọn <br><small class="text-muted fw-normal">(Màu sắc, Dung lượng)</small></label>
                    </div>
                    <div class="col-md-10">
                        <div id="variantsContainer">
                            <?php if (!empty($variants)): ?>
                                <?php foreach ($variants as $idx => $v): ?>
                                <div class="row g-2 mb-2 variant-row align-items-center">
                                    <div class="col-md-5">
                                        <input type="hidden" name="variant_id[]" value="<?= $v['variant_id'] ?>">
                                        <input type="text" class="form-control form-control-sm" name="variant_name[]"
                                        value="<?= htmlspecialchars($v['variant_name']) ?>" placeholder="Tên (VD: Đen 256GB)" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control form-control-sm" name="variant_price[]"
                                        value="<?= htmlspecialchars($v['price'] ?? '') ?>" placeholder="Giá (nếu có)">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control form-control-sm" name="variant_stock[]"
                                        value="<?= htmlspecialchars($v['stock_quantity'] ?? '') ?>" placeholder="Tồn kho">
                                    </div>
                                    <div class="col-md-1 text-end">
                                        <button type="button" class="btn btn-sm btn-outline-danger w-100" style="padding: 4px 0;"
                                        onclick="this.closest('.variant-row').remove();"><i class="bi bi-trash"></i></button>
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
                                    <div class="col-md-3">
                                        <input type="number" class="form-control form-control-sm" name="variant_stock[]" value="" placeholder="Tồn kho">
                                    </div>
                                    <div class="col-md-1 text-end">
                                        <button type="button" class="btn btn-sm btn-outline-danger w-100" style="padding: 4px 0;"
                                        onclick="this.closest('.variant-row').remove();"><i class="bi bi-trash"></i></button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addVariantRow()">
                            <i class="bi bi-plus-lg me-1"></i> Thêm tùy chọn
                        </button>
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-actions mt-5">
                    <?php if ($id): ?>
                        <button type="button" class="btn-form-delete me-auto"
                        onclick="if(confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) { document.getElementById('deleteForm').submit(); }">
                            <i class="bi bi-trash me-1"></i> Xóa
                        </button>
                    <?php endif; ?>
                    
                    <a href="<?= BASE_URL ?>?action=admin-products" class="btn-form-close text-decoration-none d-inline-flex align-items-center">
                        <i class="bi bi-x-lg me-1"></i> Đóng
                    </a>
                    
                    <button type="submit" class="btn-form-save d-inline-flex align-items-center">
                        <i class="bi bi-save me-1"></i> Lưu
                    </button>
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
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Price formatter
    const priceInput = document.getElementById('priceInput');
    if (priceInput) {
        priceInput.addEventListener('input', function(e) {
            let value = this.value.replace(/[^0-9]/g, '');
            if (value !== '') {
                this.value = parseInt(value, 10).toLocaleString('vi-VN').replace(/,/g, '.');
            } else {
                this.value = '';
            }
        });
    }

    // Image upload trigger
    const uploadArea = document.querySelector('.upload-area');
    const imageInput = document.getElementById('productImage');
    if (uploadArea && imageInput) {
        uploadArea.addEventListener('click', () => imageInput.click());
    }
});

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
        <div class="col-md-3">
            <input type="number" class="form-control form-control-sm" name="variant_stock[]" placeholder="Tồn kho">
        </div>
        <div class="col-md-1 text-end">
            <button type="button" class="btn btn-sm btn-outline-danger w-100" style="padding: 4px 0;"
            onclick="this.closest('.variant-row').remove();"><i class="bi bi-trash"></i></button>
        </div>
    </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
}
</script>
