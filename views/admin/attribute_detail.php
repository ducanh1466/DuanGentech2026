<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row g-4 justify-content-center">
    <div class="col-lg-8">
        <div class="admin-form-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Chi tiết thuộc tính: <?= htmlspecialchars($attribute['attribute_name'] ?? '') ?></h5>
                <a href="<?= BASE_URL ?>?action=admin-attributes" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại
                </a>
            </div>

            <div class="mb-4">
                <h6 class="fw-semibold text-secondary mb-3">Danh sách giá trị hiện có</h6>
                <div class="d-flex flex-wrap gap-2">
                    <?php if (empty($attribute['values'])): ?>
                        <span class="text-muted small">Chưa có giá trị nào.</span>
                    <?php else: ?>
                        <?php foreach ($attribute['values'] as $val): ?>
                            <div class="badge bg-light text-dark border p-2 px-3 d-flex align-items-center rounded-pill" style="font-weight: 500; font-size: 0.9rem;">
                                <span class="me-2"><?= htmlspecialchars($val['attribute_value']) ?></span>
                                <form method="POST" action="<?= BASE_URL ?>?action=admin-attribute-value-delete" class="d-inline m-0 p-0" onsubmit="return confirm('Bạn có chắc chắn muốn xóa giá trị này?');">
                                    <input type="hidden" name="attribute_id" value="<?= $attribute['attribute_id'] ?>">
                                    <input type="hidden" name="attribute_value_id" value="<?= $val['attribute_value_id'] ?>">
                                    <button type="submit" class="btn-close" style="font-size: 0.55rem;"></button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <hr class="my-4" style="border-color: #e2e8f0;">

            <form method="POST" action="<?= BASE_URL ?>?action=admin-attribute-value-create">
                <input type="hidden" name="attribute_id" value="<?= $attribute['attribute_id'] ?>">
                
                <h6 class="fw-semibold text-secondary mb-3">Thêm giá trị mới</h6>
                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label mb-0">Tên giá trị <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" class="form-control" name="attribute_value" placeholder="VD: Đỏ, Xanh lá, 8GB, 256GB..." required>
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="submit" class="btn-form-save w-100 py-2 d-inline-flex align-items-center justify-content-center">
                            <i class="bi bi-plus-lg me-1"></i> Thêm
                        </button>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>
