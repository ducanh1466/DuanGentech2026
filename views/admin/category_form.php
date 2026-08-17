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
                        <label class="form-horizontal-label">Icon danh mục (Bootstrap Icon)</label>
                    </div>
                    <div class="col-md-9">
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="<?= htmlspecialchars($category['icon'] ?? 'bi-grid') ?>" id="iconPreview"></i></span>
                            <input type="text" class="form-control" name="icon" id="iconInput"
                                value="<?= htmlspecialchars($category['icon'] ?? '') ?>" placeholder="VD: bi-laptop, bi-phone..." 
                                <?= $isDetail ? 'disabled' : '' ?>>
                        </div>
                        <small class="text-muted d-block mt-1">
                            Nhập tên class của Bootstrap Icon. Ví dụ: <code>bi-laptop</code>, <code>bi-phone</code>, <code>bi-headphones</code>, <code>bi-mouse</code>...
                        </small>
                        <script>
                            document.getElementById('iconInput').addEventListener('input', function(e) {
                                let iconClass = e.target.value.trim();
                                if(!iconClass.startsWith('bi-')) {
                                    iconClass = 'bi-grid';
                                }
                                document.getElementById('iconPreview').className = 'bi ' + iconClass;
                            });
                        </script>
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
