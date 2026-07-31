<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<div class="admin-table-card">
    <div class="card-header-custom">
        <h6><i class="bi bi-star me-2"></i>Quản lý thương hiệu</h6>
        <a href="<?= BASE_URL ?>?action=admin-brand-form" class="btn btn-accent btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Thêm thương hiệu
        </a>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên thương hiệu</th>
                    <th>Mô tả</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($brands)): ?>
                    <tr><td colspan="5" class="text-center">Chưa có thương hiệu nào.</td></tr>
                <?php else: ?>
                    <?php foreach ($brands as $i => $brand): ?>
                    <tr>
                        <td class="fw-semibold"><?= $i + 1 ?></td>
                        <td class="fw-semibold"><?= htmlspecialchars($brand['brand_name']) ?></td>
                        <td class="text-secondary"><?= htmlspecialchars($brand['description'] ?? '') ?></td>
                        <td>
                            <span class="badge <?= $brand['status'] == 1 ? 'bg-success' : 'bg-secondary' ?>">
                                <?= $brand['status'] == 1 ? 'Hiển thị' : 'Ẩn' ?>
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2 action-dropdown position-relative">
                                <a href="<?= BASE_URL ?>?action=admin-brand-detail&id=<?= $brand['brand_id'] ?>" class="btn-action-detail text-decoration-none">
                                    <i class="bi bi-info-circle"></i> Chi tiết
                                </a>
                                <div class="dropdown dropend">
                                    <button class="btn-action-more dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-custom">
                                        <li>
                                            <a class="dropdown-item" href="<?= BASE_URL ?>?action=admin-brand-form&id=<?= $brand['brand_id'] ?>">Chỉnh sửa</a>
                                        </li>
                                        <li>
                                            <form method="POST" action="?action=admin-brand-delete" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thương hiệu này?');">
                                                <input type="hidden" name="action_type" value="delete">
                                                <input type="hidden" name="brand_id" value="<?= $brand['brand_id'] ?>">
                                                <button type="submit" class="dropdown-item text-danger">Xóa</button>
                                            </form>
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
