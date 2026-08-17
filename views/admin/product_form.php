<?php
/** @var array $categories */
/** @var array $brands */
/** @var array $variants */
/** @var array|null $product */
/** @var int $id */
/** @var array $all_attributes */
/** @var array $specs */

$id = $id ?? 0;
$product = $product ?? null;
$variants = $variants ?? [];
$specs = $specs ?? [];
$all_attributes = $all_attributes ?? [];
?>
<style>
    .nav-tabs .nav-link { font-weight: 500; color: #64748b; border: none; padding: 1rem 1.5rem; margin-bottom: -1px; }
    .nav-tabs .nav-link.active { color: #0d6efd; background-color: transparent; border-bottom: 2px solid #0d6efd; }
    .nav-tabs { border-bottom: 1px solid #e2e8f0; mb-4; }
    .spec-row { transition: all 0.2s; }
    .spec-row:hover { background: #f8fafc; }
    .variant-matrix th { background: #f8fafc; font-weight: 600; color: #475569; font-size: 0.875rem; text-transform: uppercase; }
    .attribute-checkboxes { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 0.5rem; }
    .attr-group { border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 1rem; margin-bottom: 1rem; }
</style>

<div class="row g-4 justify-content-center">
    <div class="col-lg-12">
        <div class="admin-form-card shadow-sm bg-white rounded p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0"><?= $id ? 'Chỉnh sửa sản phẩm' : 'Thêm sản phẩm mới' ?></h5>
            </div>

            <form method="POST" action="" enctype="multipart/form-data" id="productForm">
                <ul class="nav nav-tabs mb-4" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">Thông tin cơ bản</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab">Thông số kỹ thuật</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="variants-tab" data-bs-toggle="tab" data-bs-target="#variants" type="button" role="tab">Biến thể sản phẩm</button>
                    </li>
                </ul>

                <div class="tab-content" id="productTabsContent">
                    <!-- TAB CƠ BẢN -->
                    <div class="tab-pane fade show active" id="basic" role="tabpanel">
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
                                <input type="text" class="form-control" name="product_name" value="<?= htmlspecialchars($product['product_name'] ?? '') ?>" required>
                            </div>
                        </div>

                        <div class="row form-horizontal-row align-items-center mt-3">
                            <div class="col-md-2">
                                <label class="form-horizontal-label">Danh mục <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" name="category_id" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['category_id'] ?>" <?= (isset($product['category_id']) && $product['category_id'] == $cat['category_id']) ? 'selected' : '' ?>><?= htmlspecialchars($cat['category_name']) ?></option>
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
                                        <option value="<?= $brand['brand_id'] ?>" <?= (isset($product['brand_id']) && $product['brand_id'] == $brand['brand_id']) ? 'selected' : '' ?>><?= htmlspecialchars($brand['brand_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row form-horizontal-row align-items-center mt-3">
                            <div class="col-md-2">
                                <label class="form-horizontal-label">Giá bán chung <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="price" id="priceInput" value="<?= number_format($product['price'] ?? 0, 0, '', '.') ?>" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-horizontal-label ps-md-4">Kho chung <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control" name="stock" id="stockInput" value="<?= htmlspecialchars($product['stock'] ?? ($variants[0]['stock_quantity'] ?? 0)) ?>" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-horizontal-label ps-md-4">Bảo hành</label>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control" name="warranty_period" value="<?= htmlspecialchars($product['warranty_period'] ?? '') ?>" placeholder="tháng">
                            </div>
                        </div>

                        <div class="row form-horizontal-row mt-4">
                            <div class="col-md-2">
                                <label class="form-horizontal-label">Hình ảnh chính <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <?php if (!empty($product['image'])): ?>
                                    <div class="mb-3">
                                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image" class="img-fluid rounded shadow-sm" style="max-height: 150px; border: 1px solid #e2e8f0;">
                                    </div>
                                <?php endif; ?>
                                <div class="upload-area p-4 text-center" style="border: 2px dashed #cbd5e1; border-radius: 8px; cursor: pointer; background: #f8fafc; transition: all 0.2s;" id="uploadAreaMain">
                                    <i class="bi bi-cloud-arrow-up text-primary fs-2"></i>
                                    <p class="mb-0 mt-2 fw-medium text-secondary">Click để tải lên hình ảnh chính mới</p>
                                </div>
                                <input type="file" id="productImage" name="image" accept="image/*" class="d-none" <?= empty($product['image']) ? 'required' : '' ?>>
                            </div>
                        </div>

                        <div class="row form-horizontal-row mt-4">
                            <div class="col-md-2">
                                <label class="form-horizontal-label">Hình ảnh phụ (Gallery)</label>
                            </div>
                            <div class="col-md-10">
                                <?php if (!empty($gallery_images)): ?>
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <?php foreach ($gallery_images as $img): ?>
                                            <img src="<?= htmlspecialchars($img['image_url']) ?>" alt="Gallery Image" class="img-fluid rounded shadow-sm" style="max-height: 100px; border: 1px solid #e2e8f0;">
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="alert alert-warning py-2 mb-3" style="font-size: 0.875rem;"><i class="bi bi-info-circle me-1"></i> Nếu bạn tải lên ảnh phụ mới, tất cả ảnh phụ cũ sẽ bị xóa.</div>
                                <?php endif; ?>
                                <div class="upload-area p-4 text-center" style="border: 2px dashed #cbd5e1; border-radius: 8px; cursor: pointer; background: #f8fafc; transition: all 0.2s;" id="uploadAreaGallery">
                                    <i class="bi bi-images text-primary fs-2"></i>
                                    <p class="mb-0 mt-2 fw-medium text-secondary">Click để tải lên nhiều hình ảnh phụ</p>
                                </div>
                                <input type="file" id="galleryImages" name="gallery_images[]" accept="image/*" multiple class="d-none">
                            </div>
                        </div>

                        <div class="row form-horizontal-row mt-4">
                            <div class="col-md-2">
                                <label class="form-horizontal-label">Mô tả chi tiết</label>
                            </div>
                            <div class="col-md-10">
                                <textarea class="form-control" name="description" rows="6" placeholder="Mô tả chi tiết sản phẩm..."><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- TAB THÔNG SỐ KỸ THUẬT -->
                    <div class="tab-pane fade" id="specs" role="tabpanel">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i> Thông số kỹ thuật dùng để hiển thị bảng tóm tắt cấu hình sản phẩm (Ví dụ: CPU, Độ phân giải màn hình...). Không dùng để tạo biến thể chọn mua.
                        </div>
                        <div id="specsContainer">
                            <?php foreach ($specs as $spec): ?>
                                <div class="row g-2 mb-2 spec-row align-items-center">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="spec_name[]" value="<?= htmlspecialchars($spec['spec_name']) ?>" placeholder="Tên thông số (VD: Chipset)">
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" name="spec_value[]" value="<?= htmlspecialchars($spec['spec_value']) ?>" placeholder="Giá trị (VD: Apple M2)">
                                    </div>
                                    <div class="col-md-1 text-end">
                                        <button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.spec-row').remove();"><i class="bi bi-trash"></i></button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-outline-primary mt-3" onclick="addSpecRow()">
                            <i class="bi bi-plus-lg me-1"></i> Thêm thông số
                        </button>
                    </div>

                    <!-- TAB BIẾN THỂ -->
                    <div class="tab-pane fade" id="variants" role="tabpanel">
                        <div class="alert alert-warning">
                            <i class="bi bi-lightbulb me-2"></i> Chọn các thuộc tính bên dưới để hệ thống tự động sinh ra các biến thể kết hợp. Bỏ trống nếu sản phẩm không có biến thể.
                        </div>

                        <!-- Chọn Thuộc tính -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">1. Chọn thuộc tính kết hợp:</h6>
                            <div class="row g-3">
                                <?php foreach ($all_attributes as $attr): ?>
                                    <div class="col-md-4">
                                        <div class="attr-group">
                                            <div class="fw-semibold mb-2 text-primary"><?= htmlspecialchars($attr['attribute_name']) ?></div>
                                            <div class="attribute-checkboxes">
                                                <?php foreach ($attr['values'] as $val): ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input attr-checkbox" type="checkbox" 
                                                               data-attr-name="<?= htmlspecialchars($attr['attribute_name']) ?>"
                                                               data-val-name="<?= htmlspecialchars($val['attribute_value']) ?>"
                                                               value="<?= $val['attribute_value_id'] ?>" id="attr_<?= $val['attribute_value_id'] ?>">
                                                        <label class="form-check-label" for="attr_<?= $val['attribute_value_id'] ?>">
                                                            <?= htmlspecialchars($val['attribute_value']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="btn btn-primary mt-3" onclick="generateMatrix()">
                                <i class="bi bi-magic me-1"></i> Tự động tạo ma trận biến thể
                            </button>
                        </div>

                        <hr>

                        <!-- Bảng Ma Trận Biến Thể -->
                        <h6 class="fw-bold mb-3 mt-4">2. Danh sách biến thể:</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle variant-matrix" id="variantTable">
                                <thead>
                                    <tr>
                                        <th>Tên Phiên Bản</th>
                                        <th width="15%">SKU (Mã SP)</th>
                                        <th width="15%">Giá Bán</th>
                                        <th width="12%">Tồn Kho</th>
                                        <th width="8%" class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="variantMatrixBody">
                                    <!-- Rendered by JS -->
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="addEmptyVariantRow()">
                            <i class="bi bi-plus"></i> Thêm biến thể thủ công
                        </button>
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-actions mt-5">
                    <?php if ($id): ?>
                        <button type="button" class="btn-form-delete me-auto" onclick="if(confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) { document.getElementById('deleteForm').submit(); }">
                            <i class="bi bi-trash me-1"></i> Xóa sản phẩm
                        </button>
                    <?php endif; ?>

                    <a href="<?= BASE_URL ?>?action=admin-products" class="btn-form-close text-decoration-none d-inline-flex align-items-center">
                        <i class="bi bi-x-lg me-1"></i> Đóng
                    </a>
                    
                    <button type="submit" class="btn-form-save d-inline-flex align-items-center">
                        <i class="bi bi-save me-1"></i> Lưu thông tin
                    </button>
                </div>
            </form>

            <?php if ($id): ?>
            <form id="deleteForm" method="POST" action="<?= BASE_URL ?>?action=admin-product-delete">
                <input type="hidden" name="action_type" value="delete">
                <input type="hidden" name="product_id" value="<?= $id ?>">
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    const existingVariants = <?= json_encode($variants ?? []) ?>;

    document.addEventListener('DOMContentLoaded', function () {
        // Formatter tiền tệ chung
        const priceInput = document.getElementById('priceInput');
        if (priceInput) {
            priceInput.addEventListener('input', function (e) {
                let value = this.value.replace(/[^0-9]/g, '');
                if (value !== '') {
                    this.value = parseInt(value, 10).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                } else {
                    this.value = '';
                }
            });
        }

        // Kích hoạt nút upload hình
        const uploadAreaMain = document.getElementById('uploadAreaMain');
        const imageInput = document.getElementById('productImage');
        if (uploadAreaMain && imageInput) {
            uploadAreaMain.addEventListener('click', () => imageInput.click());
            imageInput.addEventListener('change', function() {
                if(this.files && this.files[0]) {
                    uploadAreaMain.innerHTML = `<i class="bi bi-check-circle text-success fs-2"></i><p class="mb-0 mt-2 text-success fw-medium">Đã chọn: ${this.files[0].name}</p>`;
                }
            });
        }

        const uploadAreaGallery = document.getElementById('uploadAreaGallery');
        const galleryImages = document.getElementById('galleryImages');
        if (uploadAreaGallery && galleryImages) {
            uploadAreaGallery.addEventListener('click', () => galleryImages.click());
            galleryImages.addEventListener('change', function() {
                if(this.files && this.files.length > 0) {
                    uploadAreaGallery.innerHTML = `<i class="bi bi-check-circle text-success fs-2"></i><p class="mb-0 mt-2 text-success fw-medium">Đã chọn: ${this.files.length} hình ảnh</p>`;
                }
            });
        }

        // Render existing variants if they are not just "Mặc định"
        if(existingVariants.length > 0 && !(existingVariants.length === 1 && existingVariants[0].variant_name === 'Mặc định')) {
            existingVariants.forEach(v => {
                let p = v.price ? Math.round(parseFloat(v.price)) : '';
                let sq = typeof v.stock_quantity !== 'undefined' ? v.stock_quantity : (v.stock || 0);
                appendVariantRow(v.variant_id, v.variant_name, v.sku || '', p, sq, '');
            });
        }
    });

    // Thêm dòng Thông số kỹ thuật
    function addSpecRow() {
        const container = document.getElementById('specsContainer');
        const html = `
        <div class="row g-2 mb-2 spec-row align-items-center">
            <div class="col-md-4">
                <input type="text" class="form-control" name="spec_name[]" placeholder="Tên thông số (VD: Chipset)">
            </div>
            <div class="col-md-7">
                <input type="text" class="form-control" name="spec_value[]" placeholder="Giá trị (VD: Apple M2)">
            </div>
            <div class="col-md-1 text-end">
                <button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.spec-row').remove();"><i class="bi bi-trash"></i></button>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', html);
    }

    // Tự động sinh Ma trận biến thể
    function generateMatrix() {
        const checkedBoxes = Array.from(document.querySelectorAll('.attr-checkbox:checked'));
        if(checkedBoxes.length === 0) {
            alert('Vui lòng chọn ít nhất một thuộc tính để tạo biến thể!');
            return;
        }

        // Gom nhóm các checkbox đã chọn theo Tên thuộc tính (Ví dụ: nhóm "Màu", nhóm "RAM")
        const attrGroups = {};
        checkedBoxes.forEach(cb => {
            const attrName = cb.dataset.attrName;
            if(!attrGroups[attrName]) attrGroups[attrName] = [];
            attrGroups[attrName].push({ id: cb.value, name: cb.dataset.valName });
        });

        // Chuyển object thành mảng các mảng để nhân ma trận
        const groupsArray = Object.values(attrGroups);
        
        // Hàm tính toán tổ hợp (Cartesian product)
        const cartesian = (...a) => a.reduce((a, b) => a.flatMap(d => b.map(e => [d, e].flat())));
        const matrix = groupsArray.length > 1 ? cartesian(...groupsArray) : groupsArray[0].map(item => [item]);

        const tbody = document.getElementById('variantMatrixBody');
        tbody.innerHTML = ''; // Clear bảng cũ

        const basePrice = document.getElementById('priceInput').value || '0';
        const baseStock = document.getElementById('stockInput').value || '0';

        matrix.forEach(combo => {
            // combo là mảng các object {id, name}
            const variantName = combo.map(c => c.name).join(' - ');
            const attrIds = combo.map(c => c.id).join(',');
            
            appendVariantRow('', variantName, '', basePrice, baseStock, attrIds);
        });
    }

    function addEmptyVariantRow() {
        appendVariantRow('', '', '', document.getElementById('priceInput').value, 0, '');
    }

    function appendVariantRow(id, name, sku, price, stock, attrIds) {
        // Format price
        let formattedPrice = price.toString().replace(/[^0-9]/g, '');
        if(formattedPrice) formattedPrice = parseInt(formattedPrice, 10).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        const tbody = document.getElementById('variantMatrixBody');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <input type="hidden" name="variant_id[]" value="${id}">
                <input type="hidden" name="variant_attr_ids[]" value="${attrIds}">
                <input type="text" class="form-control form-control-sm" name="variant_name[]" value="${name}" placeholder="VD: Xám - 16GB" required>
            </td>
            <td>
                <input type="text" class="form-control form-control-sm" name="variant_sku[]" value="${sku}" placeholder="SKU">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm price-input" name="variant_price[]" value="${formattedPrice}" required>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm" name="variant_stock[]" value="${stock}" required>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove();"><i class="bi bi-trash"></i></button>
            </td>
        `;
        tbody.appendChild(tr);

        // Add event listener to new price input
        const newPriceInput = tr.querySelector('.price-input');
        newPriceInput.addEventListener('input', function() {
            let value = this.value.replace(/[^0-9]/g, '');
            if (value !== '') {
                this.value = parseInt(value, 10).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            } else {
                this.value = '';
            }
        });
    }
</script>