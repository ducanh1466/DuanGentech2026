<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<div class="admin-table-card">
    <div class="card-header-custom">
        <h6><i class="bi bi-star me-2"></i>Quản lý thương hiệu</h6>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <form method="GET" class="d-flex">
                <input type="hidden" name="action" value="admin-brands">
                <input type="hidden" name="limit" value="<?= $limit ?? 10 ?>">
                <div class="position-relative">
                    <i class="bi bi-search position-absolute"
                        style="left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);"></i>
                    <input type="text" name="keyword" class="admin-search-input" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>" placeholder="Tìm thương hiệu...">
                </div>
            </form>
            <a href="<?= BASE_URL ?>?action=admin-brand-form" class="btn btn-accent btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Thêm thương hiệu
            </a>
        </div>
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

    <!-- Phân trang -->
    <div class="d-flex justify-content-between align-items-center p-3 border-top" style="border-color:var(--border-light)!important">
        <!-- Chỉnh số lượng hiển thị -->
        <div class="d-flex align-items-center gap-2">
            <select class="form-select form-select-sm" style="width: auto; border-radius: 4px;" onchange="window.location.href='?action=admin-brands&keyword=<?= urlencode($keyword ?? '') ?>&limit='+this.value">
                <option value="10" <?= ($limit ?? 10) == 10 ? 'selected' : '' ?>>10 / trang</option>
                <option value="20" <?= ($limit ?? 10) == 20 ? 'selected' : '' ?>>20 / trang</option>
                <option value="50" <?= ($limit ?? 10) == 50 ? 'selected' : '' ?>>50 / trang</option>
                <option value="100" <?= ($limit ?? 10) == 100 ? 'selected' : '' ?>>100 / trang</option>
            </select>
        </div>

        <div class="d-flex align-items-center gap-3">
            <span class="text-muted" style="font-size:0.85rem;">Tổng <?= $totalRecords ?? 0 ?> bản ghi</span>
            
            <?php if (isset($totalPages) && $totalPages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?action=admin-brands&keyword=<?= urlencode($keyword ?? '') ?>&limit=<?= $limit ?? 10 ?>&page=<?= ($page ?? 1) - 1 ?>">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        
                        <?php 
                        $start = max(1, ($page ?? 1) - 2);
                        $end = min($totalPages, ($page ?? 1) + 2);
                        
                        if ($start > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?action=admin-brands&keyword='.urlencode($keyword ?? '').'&limit='.($limit ?? 10).'&page=1">1</a></li>';
                            if ($start > 2) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                        }
                        
                        for ($i = $start; $i <= $end; $i++) {
                            $active = ($i == ($page ?? 1)) ? 'active' : '';
                            echo '<li class="page-item ' . $active . '"><a class="page-link" href="?action=admin-brands&keyword='.urlencode($keyword ?? '').'&limit='.($limit ?? 10).'&page='.$i.'">' . $i . '</a></li>';
                        }
                        
                        if ($end < $totalPages) {
                            if ($end < $totalPages - 1) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                            echo '<li class="page-item"><a class="page-link" href="?action=admin-brands&keyword='.urlencode($keyword ?? '').'&limit='.($limit ?? 10).'&page='.$totalPages.'">'.$totalPages.'</a></li>';
                        }
                        ?>
                        
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?action=admin-brands&keyword=<?= urlencode($keyword ?? '') ?>&limit=<?= $limit ?? 10 ?>&page=<?= ($page ?? 1) + 1 ?>">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>
