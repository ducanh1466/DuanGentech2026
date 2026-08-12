<?php
/** @var array|null $category */
/** @var int $id */
/** @var bool $isDetail */
?>
<div class="row g-4 justify-content-center">
    <div class="col-lg-8">
        <div class="admin-form-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">
                    <?php
                        if ($isDetail) {
                            echo 'Chi tiết danh mục';
                        } else {
                            echo $id ? 'Chỉnh sửa danh mục' : 'Thêm danh mục mới';
                        }
                    ?>
                </h5>
                <?php if ($isDetail): ?>
                    <span class="badge bg-info">Chế độ xem</span>
                <?php endif; ?>
            </div>

            <form method="POST" action="<?= BASE_URL ?>?action=<?= $id ? 'admin-category-update' : 'admin-category-create' ?>" enctype="multipart/form-data">
                <?php if ($id): ?>
                    <input type="hidden" name="category_id" value="<?= $id ?>">
                <?php endif; ?>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Tên danh mục <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="name"
                            value="<?= htmlspecialchars($category['category_name'] ?? '') ?>" required
                            <?= $isDetail ? 'disabled' : '' ?>>
                    </div>
                </div>

                <div class="row form-horizontal-row">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Mô tả</label>
                    </div>
                    <div class="col-md-9">
                        <textarea class="form-control" name="description" rows="4"
                            <?= $isDetail ? 'disabled' : '' ?>><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Hình ảnh danh mục</label>
                    </div>
                    <div class="col-md-9">
                        <input type="file" class="form-control" name="image" accept="image/*" <?= $isDetail ? 'disabled' : '' ?>>
                        <?php if (!empty($category['icon'])): ?>
                            <div class="mt-3">
                                <img src="<?= BASE_URL ?>assets/uploads/categories/<?= htmlspecialchars($category['icon']) ?>" alt="Category Image" style="max-width: 100px; height: auto; border-radius: 8px; border: 1px solid #dee2e6;">
                            </div>
                        <?php endif; ?>
                        <small class="text-muted mt-1 d-block">Chọn hình ảnh đại diện cho danh mục. Định dạng: JPG, PNG, GIF, WebP.</small>
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-actions mt-5">
                    <?php if ($isDetail): ?>
                        <?php if ($id): ?>
                            <button type="button" class="btn-form-delete me-auto"
                            onclick="if(confirm('Bạn có chắc chắn muốn xóa danh mục này?')) { document.getElementById('deleteForm').submit(); }">
                                <i class="bi bi-trash me-1"></i> Xóa
                            </button>
                        <?php endif; ?>
                        
                        <a href="<?= BASE_URL ?>?action=admin-categories" class="btn-form-close text-decoration-none d-inline-flex align-items-center">
                            <i class="bi bi-x-lg me-1"></i> Đóng
                        </a>
                        
                        <a href="<?= BASE_URL ?>?action=admin-category-form&id=<?= $id ?>" class="btn-form-save text-decoration-none d-inline-flex align-items-center">
                            <i class="bi bi-pencil me-1"></i> Sửa
                        </a>
                    <?php else: ?>
                        <?php if ($id): ?>
                            <button type="button" class="btn-form-delete me-auto"
                            onclick="if(confirm('Bạn có chắc chắn muốn xóa danh mục này?')) { document.getElementById('deleteForm').submit(); }">
                                <i class="bi bi-trash me-1"></i> Xóa
                            </button>
                        <?php endif; ?>
                        
                        <a href="<?= BASE_URL ?>?action=admin-categories" class="btn-form-close text-decoration-none d-inline-flex align-items-center">
                            <i class="bi bi-x-lg me-1"></i> Đóng
                        </a>
                        
                        <button type="submit" class="btn-form-save d-inline-flex align-items-center">
                            <i class="bi bi-save me-1"></i> Lưu
                        </button>
                    <?php endif; ?>
                </div>
            </form>

            <?php if ($id): ?>
            <form id="deleteForm" method="POST" action="<?= BASE_URL ?>?action=admin-category-delete">
                <input type="hidden" name="action_type" value="delete">
                <input type="hidden" name="category_id" value="<?= $id ?>">
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>
