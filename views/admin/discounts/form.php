<?php
/** @var array|null $discount */
/** @var int $id */
?>
<div class="row g-4 justify-content-center">
    <div class="col-lg-8">
        <div class="admin-form-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">
                    <?php
                        if ($isDetail ?? false) {
                            echo 'Chi tiết mã giảm giá';
                        } else {
                            echo $id ? 'Chỉnh sửa mã giảm giá' : 'Thêm mã giảm giá mới';
                        }
                    ?>
                </h5>
                <?php if ($isDetail ?? false): ?>
                    <span class="badge bg-info">Chế độ xem</span>
                <?php endif; ?>
            </div>

            <form method="POST" action="<?= BASE_URL ?>?action=admin-discount-create" enctype="multipart/form-data">
                <?php if ($id): ?>
                    <input type="hidden" name="discount_id" value="<?= $id ?>">
                <?php endif; ?>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Mã Code <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control text-uppercase" name="code" required
                            value="<?= htmlspecialchars($discount['code'] ?? '') ?>" 
                            placeholder="Vd: GENTECH10" <?= ($isDetail ?? false) ? 'disabled' : '' ?>>
                    </div>
                </div>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Loại giảm giá <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <select class="form-select" name="discount_type" required <?= ($isDetail ?? false) ? 'disabled' : '' ?>>
                            <option value="percent" <?= ($discount['discount_type'] ?? '') == 'percent' ? 'selected' : '' ?>>Phần trăm (%)</option>
                            <option value="fixed" <?= ($discount['discount_type'] ?? '') == 'fixed' ? 'selected' : '' ?>>Số tiền cố định (đ)</option>
                        </select>
                    </div>
                </div>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Mức giảm <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control currency-input" id="discount_value_display" required
                            value="<?= isset($discount['discount_value']) ? number_format($discount['discount_value'], 0, ',', '.') : '' ?>" 
                            placeholder="Nhập phần trăm (vd: 10) hoặc số tiền (vd: 50.000)" <?= ($isDetail ?? false) ? 'disabled' : '' ?>>
                        <input type="hidden" name="discount_value" id="discount_value_raw" value="<?= $discount['discount_value'] ?? '' ?>">
                        <small class="text-muted d-block mt-1">Lưu ý: Nếu chọn Phần trăm thì mức giảm <= 100.</small>
                    </div>
                </div>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Giảm tối đa</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control currency-input" id="max_discount_display"
                            value="<?= isset($discount['max_discount']) ? number_format($discount['max_discount'], 0, ',', '.') : '' ?>" 
                            placeholder="Chỉ áp dụng cho loại Phần trăm. Vd: 100.000" <?= ($isDetail ?? false) ? 'disabled' : '' ?>>
                        <input type="hidden" name="max_discount" id="max_discount_raw" value="<?= $discount['max_discount'] ?? '' ?>">
                    </div>
                </div>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Đơn tối thiểu</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control currency-input" id="minimum_order_value_display"
                            value="<?= isset($discount['minimum_order_value']) ? number_format($discount['minimum_order_value'], 0, ',', '.') : '' ?>" 
                            placeholder="Để trống nếu không yêu cầu. Vd: 200.000" <?= ($isDetail ?? false) ? 'disabled' : '' ?>>
                        <input type="hidden" name="minimum_order_value" id="minimum_order_value_raw" value="<?= $discount['minimum_order_value'] ?? '' ?>">
                    </div>
                </div>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Số lượng</label>
                    </div>
                    <div class="col-md-9">
                        <input type="number" class="form-control" name="quantity" min="1"
                            value="<?= $discount['quantity'] ?? '' ?>" 
                            placeholder="Bỏ trống nếu không giới hạn" <?= ($isDetail ?? false) ? 'disabled' : '' ?>>
                    </div>
                </div>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Trạng thái <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <select class="form-select" name="status" required <?= ($isDetail ?? false) ? 'disabled' : '' ?>>
                            <option value="active" <?= ($discount['status'] ?? '') == 'active' ? 'selected' : '' ?>>Hoạt động</option>
                            <option value="inactive" <?= ($discount['status'] ?? '') == 'inactive' ? 'selected' : '' ?>>Tạm khóa</option>
                        </select>
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-actions mt-5">
                    <?php if ($isDetail ?? false): ?>
                        <?php if ($id): ?>
                            <button type="button" class="btn-form-delete me-auto"
                            onclick="if(confirm('Bạn có chắc chắn muốn xóa mã giảm giá này?')) { document.getElementById('deleteForm').submit(); }">
                                <i class="bi bi-trash me-1"></i> Xóa
                            </button>
                        <?php endif; ?>
                        
                        <a href="<?= BASE_URL ?>?action=admin-discounts" class="btn-form-close text-decoration-none d-inline-flex align-items-center">
                            <i class="bi bi-x-lg me-1"></i> Đóng
                        </a>
                        
                        <a href="<?= BASE_URL ?>?action=admin-discount-form&id=<?= $id ?>" class="btn-form-save text-decoration-none d-inline-flex align-items-center">
                            <i class="bi bi-pencil me-1"></i> Sửa
                        </a>
                    <?php else: ?>
                        <?php if ($id): ?>
                            <button type="button" class="btn-form-delete me-auto"
                            onclick="if(confirm('Bạn có chắc chắn muốn xóa mã giảm giá này?')) { document.getElementById('deleteForm').submit(); }">
                                <i class="bi bi-trash me-1"></i> Xóa
                            </button>
                        <?php endif; ?>
                        
                        <a href="<?= BASE_URL ?>?action=admin-discounts" class="btn-form-close text-decoration-none d-inline-flex align-items-center">
                            <i class="bi bi-x-lg me-1"></i> Đóng
                        </a>
                        
                        <button type="submit" class="btn-form-save d-inline-flex align-items-center">
                            <i class="bi bi-save me-1"></i> Lưu
                        </button>
                    <?php endif; ?>
                </div>
            </form>

            <?php if ($id): ?>
            <form id="deleteForm" method="POST" action="<?= BASE_URL ?>?action=admin-discount-delete">
                <input type="hidden" name="id" value="<?= $id ?>">
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function formatCurrencyInput(displayId, rawId) {
        const displayEl = document.getElementById(displayId);
        const rawEl = document.getElementById(rawId);

        if (displayEl && rawEl) {
            displayEl.addEventListener('input', function(e) {
                let value = this.value.replace(/\D/g, '');
                rawEl.value = value;
                if (value) {
                    this.value = parseInt(value, 10).toLocaleString('vi-VN');
                } else {
                    this.value = '';
                }
            });
        }
    }

    formatCurrencyInput('discount_value_display', 'discount_value_raw');
    formatCurrencyInput('max_discount_display', 'max_discount_raw');
    formatCurrencyInput('minimum_order_value_display', 'minimum_order_value_raw');
});
</script>
