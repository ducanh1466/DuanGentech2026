<div class="admin-table-card">
    <div class="card-header-custom">
        <h6><i class="bi bi-box-seam me-2"></i>Quản lý sản phẩm</h6>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <form method="GET" class="d-flex gap-3 m-0 p-2 align-items-center flex-grow-1" style="background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                <input type="hidden" name="action" value="admin-products">
                <input type="hidden" name="limit" value="<?= $limit ?? 10 ?>">
                
                <!-- Filter by Category -->
                <div class="input-group input-group-sm" style="flex: 1; min-width: 160px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden;">
                    <span class="input-group-text bg-white border-end-0 border-light text-muted"><i class="bi bi-folder2-open"></i></span>
                    <select name="category_id" class="form-select border-start-0 border-light shadow-none fw-medium" onchange="this.form.submit()" style="color: #475569; cursor: pointer;">
                        <option value="">Tất cả danh mục</option>
                        <?php if(!empty($categories)): foreach($categories as $cat): ?>
                            <option value="<?= $cat['category_id'] ?>" <?= (($category_id ?? '') == $cat['category_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['category_name']) ?>
                            </option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>

                <!-- Filter by Status -->
                <div class="input-group input-group-sm" style="flex: 1; min-width: 150px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden;">
                    <span class="input-group-text bg-white border-end-0 border-light text-muted"><i class="bi bi-funnel"></i></span>
                    <select name="status" class="form-select border-start-0 border-light shadow-none fw-medium" onchange="this.form.submit()" style="color: #475569; cursor: pointer;">
                        <option value="">Tất cả trạng thái</option>
                        <option value="1" <?= (($status ?? '') === '1' || ($status ?? '') === 'active') ? 'selected' : '' ?>>Hiển thị</option>
                        <option value="0" <?= (($status ?? '') === '0' || ($status ?? '') === 'inactive') ? 'selected' : '' ?>>Ẩn</option>
                    </select>
                </div>

                <!-- Search Input -->
                <div class="input-group input-group-sm" style="flex: 2; min-width: 200px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden;">
                    <span class="input-group-text bg-white border-end-0 border-light text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="keyword" class="form-control border-start-0 border-light shadow-none fw-medium" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>" placeholder="Tìm tên, ID sản phẩm..." style="color: #475569;">
                </div>
                <button type="submit" class="btn btn-sm btn-primary shadow-sm text-nowrap px-3" style="border-radius: 8px;"><i class="bi bi-search me-1"></i>Tìm kiếm</button>
            </form>
            <a href="<?= BASE_URL ?>?action=admin-product-create" class="btn btn-accent btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Thêm sản phẩm
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="7" class="text-center">Chưa có sản phẩm nào.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $i => $p): ?>
                        <tr>
                            <td class="fw-semibold"><?= $i + 1 ?></td>
                            <td>
                                <?php if (!empty($p['image'])): ?>
                                    <img src="<?= htmlspecialchars($p['image']) ?>" class="product-thumb" alt=""
                                        style="width:60px; height:60px; object-fit:cover; border-radius:var(--radius-sm);">
                                <?php else: ?>
                                    <img src="https://placehold.co/60x60/e2e8f0/64748b?text=IMG" class="product-thumb" alt="">
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-semibold"><?= htmlspecialchars($p['product_name']) ?></div>
                                <small class="text-muted">ID: #<?= $p['product_id'] ?></small>
                            </td>
                            <td><?= htmlspecialchars($p['category_name'] ?? 'N/A') ?></td>
                            <td class="fw-bold">
                                <span class="text-accent"><?= number_format($p['price'] ?? 0, 0, ',', '.') ?> VNĐ</span>
                            </td>
                        <td><span
                                    class="status-badge <?= ($p['status'] == 1 || $p['status'] === 'active') ? 'active' : 'inactive' ?>"><?= ($p['status'] == 1 || $p['status'] === 'active') ? 'Hiển thị' : 'Ẩn' ?></span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2 action-dropdown position-relative">
                                    <a href="<?= BASE_URL ?>?action=admin-product-edit&id=<?= $p['product_id'] ?>" class="btn-action-detail text-decoration-none">
                                        <i class="bi bi-info-circle"></i> Chi tiết
                                    </a>
                                    <div class="dropdown dropend">
                                        <button class="btn-action-more dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-custom">
                                            <li>
                                                <a class="dropdown-item" href="<?= BASE_URL ?>?action=admin-product-edit&id=<?= $p['product_id'] ?>">Chỉnh sửa</a>
                                            </li>
                                            <li>
                                                <form method="POST" action="<?= BASE_URL ?>?action=admin-product-delete" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                                    <input type="hidden" name="action_type" value="delete">
                                                    <input type="hidden" name="product_id" value="<?= $p['product_id'] ?>">
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
            <select class="form-select form-select-sm" style="width: auto; border-radius: 4px;" onchange="window.location.href='?action=admin-products&keyword=<?= urlencode($keyword ?? '') ?>&status=<?= urlencode($status ?? '') ?>&category_id=<?= urlencode($category_id ?? '') ?>&limit='+this.value">
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
                            <a class="page-link" href="?action=admin-products&keyword=<?= urlencode($keyword ?? '') ?>&status=<?= urlencode($status ?? '') ?>&category_id=<?= urlencode($category_id ?? '') ?>&limit=<?= $limit ?? 10 ?>&page=<?= ($page ?? 1) - 1 ?>">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        
                        <?php 
                        $start = max(1, ($page ?? 1) - 2);
                        $end = min($totalPages, ($page ?? 1) + 2);
                        
                        if ($start > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?action=admin-products&keyword='.urlencode($keyword ?? '').'&status='.urlencode($status ?? '').'&category_id='.urlencode($category_id ?? '').'&limit='.($limit ?? 10).'&page=1">1</a></li>';
                            if ($start > 2) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                        }
                        
                        for ($i = $start; $i <= $end; $i++) {
                            $active = ($i == ($page ?? 1)) ? 'active' : '';
                            echo '<li class="page-item ' . $active . '"><a class="page-link" href="?action=admin-products&keyword='.urlencode($keyword ?? '').'&status='.urlencode($status ?? '').'&category_id='.urlencode($category_id ?? '').'&limit='.($limit ?? 10).'&page='.$i.'">' . $i . '</a></li>';
                        }
                        
                        if ($end < $totalPages) {
                            if ($end < $totalPages - 1) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                            echo '<li class="page-item"><a class="page-link" href="?action=admin-products&keyword='.urlencode($keyword ?? '').'&status='.urlencode($status ?? '').'&category_id='.urlencode($category_id ?? '').'&limit='.($limit ?? 10).'&page='.$totalPages.'">'.$totalPages.'</a></li>';
                        }
                        ?>
                        
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?action=admin-products&keyword=<?= urlencode($keyword ?? '') ?>&status=<?= urlencode($status ?? '') ?>&category_id=<?= urlencode($category_id ?? '') ?>&limit=<?= $limit ?? 10 ?>&page=<?= ($page ?? 1) + 1 ?>">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>