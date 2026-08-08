<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<div class="admin-table-card">
    <div class="card-header-custom">
        <h6><i class="bi bi-images me-2"></i>Quản lý Banner</h6>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <a href="<?= BASE_URL ?>?action=admin-banner-form" class="btn btn-accent btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Thêm banner mới
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Tiêu đề</th>
                    <th>Hình ảnh</th>
                    <th>Vị trí</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($banners)): ?>
                    <tr><td colspan="6" class="text-center">Chưa có banner nào.</td></tr>
                <?php else: ?>
                    <?php foreach ($banners as $banner): ?>
                    <tr>
                        <td class="fw-semibold"><?= $banner['id'] ?></td>
                        <td class="fw-semibold"><?= htmlspecialchars($banner['title']) ?></td>
                        <td>
                            <?php $imgUrl = BASE_URL . 'assets/uploads/banner/' . $banner['image_url']; ?>
                            <img src="<?= $imgUrl ?>" alt="banner" style="width: 150px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #dee2e6;">
                        </td>
                        <td>
                            <?php if ($banner['position'] === 'hero_slider'): ?>
                                <span class="badge bg-primary">Hero Slider</span>
                            <?php else: ?>
                                <span class="badge bg-info text-dark">Khuyến Mãi</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge <?= $banner['status'] == 1 ? 'bg-success' : 'bg-secondary' ?>">
                                <?= $banner['status'] == 1 ? 'Hiển thị' : 'Ẩn' ?>
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2 action-dropdown position-relative">
                                <a href="<?= BASE_URL ?>?action=admin-banner-form&id=<?= $banner['id'] ?>" class="btn-action-detail text-decoration-none">
                                    <i class="bi bi-info-circle"></i> Chi tiết
                                </a>
                                <div class="dropdown dropend">
                                    <button class="btn-action-more dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-custom">
                                        <li>
                                            <a class="dropdown-item" href="<?= BASE_URL ?>?action=admin-banner-form&id=<?= $banner['id'] ?>">Chỉnh sửa</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="<?= BASE_URL ?>?action=admin-banner-delete&id=<?= $banner['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa banner này?')">Xóa</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
