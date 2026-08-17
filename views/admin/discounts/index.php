<div class="admin-table-card">
    <div class="card-header-custom">
        <h6><i class="bi bi-ticket-perforated me-2"></i>Quản lý Mã Giảm Giá</h6>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <form method="GET" class="d-flex gap-2 m-0 p-0 align-items-center">
                <input type="hidden" name="action" value="admin-discounts">
                <input type="hidden" name="limit" value="<?= $limit ?? 10 ?>">
                <div class="position-relative">
                    <i class="bi bi-search position-absolute"
                        style="left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);"></i>
                    <input type="text" name="keyword" class="admin-search-input" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>" placeholder="Tìm mã giảm giá...">
                </div>
            </form>
            <a href="<?= BASE_URL ?>?action=admin-discount-form" class="btn btn-accent btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Thêm mã giảm giá
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Mã Code</th>
                    <th>Loại & Giá trị</th>
                    <th>Điều kiện</th>
                    <th>Số lượng</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($discounts)): ?>
                    <tr><td colspan="6" class="text-center">Chưa có mã giảm giá nào.</td></tr>
                <?php else: ?>
                    <?php foreach ($discounts as $discount): ?>
                        <tr>
                            <td class="fw-bold text-primary"><?= htmlspecialchars($discount['code']) ?></td>
                            <td>
                                <?php if ($discount['discount_type'] == 'percent'): ?>
                                    Giảm <?= $discount['discount_value'] ?>%
                                    <?= $discount['max_discount'] > 0 ? '<br><small class="text-muted">Tối đa ' . number_format($discount['max_discount'], 0, ',', '.') . 'đ</small>' : '' ?>
                                <?php else: ?>
                                    Giảm <?= number_format($discount['discount_value'], 0, ',', '.') ?>đ
                                <?php endif; ?>
                            </td>
                            <td>
                                Đơn từ: <?= number_format($discount['minimum_order_value'], 0, ',', '.') ?>đ
                            </td>
                            <td>
                                <?= $discount['quantity'] !== null ? $discount['quantity'] : 'Vô hạn' ?>
                            </td>
                            <td>
                                <?php if ($discount['status'] == 'active'): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-2 py-1 rounded-pill">Hoạt động</span>
                                <?php else: ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2 py-1 rounded-pill">Tạm khóa</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2 action-dropdown position-relative">
                                    <a href="<?= BASE_URL ?>?action=admin-discount-detail&id=<?= $discount['discount_id'] ?>" class="btn-action-detail text-decoration-none">
                                        <i class="bi bi-info-circle"></i> Chi tiết
                                    </a>
                                    <div class="dropdown dropend">
                                        <button class="btn-action-more dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-custom">
                                            <li>
                                                <a class="dropdown-item" href="<?= BASE_URL ?>?action=admin-discount-form&id=<?= $discount['discount_id'] ?>">Chỉnh sửa</a>
                                            </li>
                                            <li>
                                                <form method="POST" action="?action=admin-discount-delete" onsubmit="return confirm('Bạn có chắc chắn muốn xóa mã giảm giá này?');">
                                                    <input type="hidden" name="id" value="<?= $discount['discount_id'] ?>">
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
            <select class="form-select form-select-sm" style="width: auto; border-radius: 4px;" onchange="window.location.href='?action=admin-discounts&keyword=<?= urlencode($keyword ?? '') ?>&limit='+this.value">
                <option value="10" <?= ($limit ?? 10) == 10 ? 'selected' : '' ?>>10 / trang</option>
                <option value="20" <?= ($limit ?? 10) == 20 ? 'selected' : '' ?>>20 / trang</option>
                <option value="50" <?= ($limit ?? 10) == 50 ? 'selected' : '' ?>>50 / trang</option>
                <option value="100" <?= ($limit ?? 10) == 100 ? 'selected' : '' ?>>100 / trang</option>
            </select>
        </div>

        <div class="d-flex align-items-center gap-3">
            <span class="text-muted" style="font-size:0.85rem;">Tổng <?= max(0, min((($page ?? 1) * ($limit ?? 10)), ($totalRecords ?? 0)) - ((($page ?? 1) - 1) * ($limit ?? 10))) ?> bản ghi</span>
            
            <?php if (isset($totalPages) && $totalPages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?action=admin-discounts&keyword=<?= urlencode($keyword ?? '') ?>&limit=<?= $limit ?? 10 ?>&page=<?= ($page ?? 1) - 1 ?>">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        
                        <?php 
                        $start = max(1, ($page ?? 1) - 2);
                        $end = min($totalPages, ($page ?? 1) + 2);
                        
                        if ($start > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?action=admin-discounts&keyword='.urlencode($keyword ?? '').'&limit='.($limit ?? 10).'&page=1">1</a></li>';
                            if ($start > 2) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                        }
                        
                        for ($i = $start; $i <= $end; $i++) {
                            $active = ($i == ($page ?? 1)) ? 'active' : '';
                            echo '<li class="page-item ' . $active . '"><a class="page-link" href="?action=admin-discounts&keyword='.urlencode($keyword ?? '').'&limit='.($limit ?? 10).'&page='.$i.'">' . $i . '</a></li>';
                        }
                        
                        if ($end < $totalPages) {
                            if ($end < $totalPages - 1) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                            echo '<li class="page-item"><a class="page-link" href="?action=admin-discounts&keyword='.urlencode($keyword ?? '').'&limit='.($limit ?? 10).'&page='.$totalPages.'">'.$totalPages.'</a></li>';
                        }
                        ?>
                        
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?action=admin-discounts&keyword=<?= urlencode($keyword ?? '') ?>&limit=<?= $limit ?? 10 ?>&page=<?= ($page ?? 1) + 1 ?>">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>
