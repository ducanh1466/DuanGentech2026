<div class="admin-table-card">
    <div class="card-header-custom">
        <h6><i class="bi bi-tags me-2"></i>Quản lý danh mục</h6>
        <a href="<?= BASE_URL ?>?action=admin-category-form" class="btn btn-accent btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Thêm danh mục
        </a>
    </div>

    <div class="table-responsive">
    <table class="admin-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Tên danh mục</th>
            <th>Mô tả</th>
            <th>Hành động</th>
        </tr>
    </thead>
        <tbody>
            <?php if (empty($categories)): ?>
                tr><td colspan="4" class="text-center">Chưa có danh mục nào.</td></tr>
            <?php else: ?>
            <?php foreach ($categories as $i => $cat): ?>
            <tr>
                <td class="fw-semibold"><?= $i + 1 ?></td>
                <td class="fw-semibold"><?= htmlspecialchars($cat['category_name']) ?></td>
                <td class="text-secondary"><?= htmlspecialchars($cat['description'] ?? '') ?></td>
                <td>
                    <div class="d-flex align-items-center gap-2 action-dropdown position-relative">
                        <a href="<?= BASE_URL ?>?action=admin-category-detail&id=<?= $cat['category_id'] ?>" class="btn-action-detail text-decoration-none">
                            <i class="bi bi-info-circle"></i> Chi tiết
                        </a>
                        <div class="dropdown dropend">
                            <button class="btn-action-more dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-custom">
                                <li>
                                    <a class="dropdown-item" href="<?= BASE_URL ?>?action=admin-category-form&id=<?= $cat['category_id'] ?>">Chỉnh sửa</a>
                                </li>
                                <li>
                                    <form method="POST" action="?action=admin-category-delete" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                        <input type="hidden" name="action_type" value="delete">
                                        <input type="hidden" name="category_id" value="<?= $cat['category_id'] ?>">
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
