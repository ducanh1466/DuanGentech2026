<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<div class="row g-4 justify-content-center">
    <div class="col-lg-8">
        <div class="admin-form-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">
                    <?= isset($banner) ? 'Chỉnh sửa Banner' : 'Thêm mới Banner' ?>
                </h5>
            </div>

            <form method="POST" action="<?= BASE_URL ?>?action=<?= isset($banner) ? 'admin-banner-update' : 'admin-banner-create' ?>" enctype="multipart/form-data">
                <?php if (isset($banner)): ?>
                    <input type="hidden" name="id" value="<?= $banner['id'] ?>">
                    <input type="hidden" name="old_image" value="<?= $banner['image_url'] ?>">
                <?php endif; ?>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Tiêu đề Banner <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="title"
                            value="<?= htmlspecialchars($banner['title'] ?? '') ?>" required
                            placeholder="Ví dụ: Sale mùa hè">
                    </div>
                </div>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Vị trí hiển thị</label>
                    </div>
                    <div class="col-md-9">
                        <?php $currentPosition = isset($banner) ? trim($banner['position']) : ''; ?>
                        <select class="form-select" name="position" required>
                            <option value="hero_slider" <?= ($currentPosition === 'hero_slider') ? 'selected' : '' ?>>Hero Slider (Banner lớn nhất)</option>
                            <option value="promo_banner" <?= ($currentPosition === 'promo_banner') ? 'selected' : '' ?>>Khuyến Mãi (Banner nhỏ)</option>
                            <option value="product_page_banner" <?= ($currentPosition === 'product_page_banner') ? 'selected' : '' ?>>Trang Sản Phẩm (Banner ngang)</option>
                        </select>
                    </div>
                </div>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Link điều hướng</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="link"
                            value="<?= htmlspecialchars($banner['link'] ?? '') ?>"
                            placeholder="https://dgentech.vn/san-pham">
                        <small class="text-muted mt-1 d-block">Đường dẫn khi khách hàng bấm vào banner (Tùy chọn)</small>
                    </div>
                </div>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Trạng thái</label>
                    </div>
                    <div class="col-md-9">
                        <select class="form-select" name="status">
                            <option value="1" <?= (!isset($banner) || (isset($banner) && $banner['status'] == 1)) ? 'selected' : '' ?>>Hiển thị</option>
                            <option value="0" <?= (isset($banner) && $banner['status'] == 0) ? 'selected' : '' ?>>Ẩn</option>
                        </select>
                    </div>
                </div>

                <div class="row form-horizontal-row">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Hình ảnh <?= !isset($banner) ? '<span class="text-danger">*</span>' : '' ?></label>
                    </div>
                    <div class="col-md-9">
                        <input type="file" class="form-control" name="image" accept="image/*" <?= !isset($banner) ? 'required' : '' ?> onchange="previewImage(event)">
                        
                        <div class="mt-3">
                            <?php if (isset($banner) && $banner['image_url']): ?>
                                <img id="img_preview" src="<?= BASE_URL ?>assets/uploads/banner/<?= $banner['image_url'] ?>" alt="Preview" style="max-width: 100%; height: auto; border-radius: 8px; border: 1px solid #dee2e6;">
                            <?php else: ?>
                                <img id="img_preview" src="" alt="Preview" style="display:none; max-width: 100%; height: auto; border-radius: 8px; border: 1px solid #dee2e6;">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="<?= BASE_URL ?>?action=admin-banners" class="btn btn-outline-secondary px-4">Hủy</a>
                    <button type="submit" class="btn btn-primary px-4">
                        <?= isset($banner) ? 'Lưu thay đổi' : 'Thêm mới' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('img_preview');
        output.src = reader.result;
        output.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
