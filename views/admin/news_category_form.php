<div class="row g-4 justify-content-center">
    <div class="col-lg-8">
        <div class="admin-form-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">
                    <?= isset($category) ? 'Chỉnh sửa danh mục' : 'Thêm danh mục mới' ?>
                </h5>
            </div>

            <form action="<?= isset($category) ? '?action=admin-news-category-update' : '?action=admin-news-category-create' ?>" method="POST">
                
                <?php if (isset($category)): ?>
                    <input type="hidden" name="category_id" value="<?= $category['id'] ?>">
                <?php endif; ?>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Tên danh mục <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="name" id="nameInput" value="<?= isset($category) ? htmlspecialchars($category['name']) : '' ?>" required>
                    </div>
                </div>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Đường dẫn (Slug) <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="slug" id="slugInput" value="<?= isset($category) ? htmlspecialchars($category['slug']) : '' ?>" required>
                    </div>
                </div>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Trạng thái</label>
                    </div>
                    <div class="col-md-9">
                        <select class="form-select" name="status">
                            <option value="1" <?= (isset($category) && $category['status'] == 1) ? 'selected' : '' ?>>Hiển thị</option>
                            <option value="0" <?= (isset($category) && $category['status'] == 0) ? 'selected' : '' ?>>Ẩn</option>
                        </select>
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-actions mt-5">
                    <?php if (isset($category)): ?>
                        <button type="button" class="btn-form-delete me-auto"
                        onclick="if(confirm('Bạn có chắc chắn muốn xóa danh mục này?')) { document.getElementById('deleteForm').submit(); }">
                            <i class="bi bi-trash me-1"></i> Xóa
                        </button>
                    <?php endif; ?>
                    
                    <a href="?action=admin-news-categories" class="btn-form-close text-decoration-none d-inline-flex align-items-center">
                        <i class="bi bi-x-lg me-1"></i> Đóng
                    </a>
                    
                    <button type="submit" class="btn-form-save d-inline-flex align-items-center">
                        <i class="bi bi-save me-1"></i> Lưu
                    </button>
                </div>
            </form>

            <?php if (isset($category)): ?>
            <form id="deleteForm" method="POST" action="?action=admin-news-category-delete">
                <input type="hidden" name="category_id" value="<?= $category['id'] ?>">
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Hàm chuyển Tên thành Slug
    document.getElementById('nameInput').addEventListener('keyup', function() {
        let name = this.value;
        let slug = name.toLowerCase();
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        slug = slug.replace(/[^a-z0-9 -]/g, '');
        slug = slug.replace(/\s+/g, '-');
        slug = slug.replace(/-+/g, '-');
        
        document.getElementById('slugInput').value = slug;
    });
</script>
