<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<div class="admin-table-card">
    <div class="card-header-custom d-flex justify-content-between align-items-center">
        <h6><i class="bi bi-newspaper me-2"></i>Quản lý Tin Tức</h6>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <form method="GET" class="d-flex gap-2 m-0 p-0 align-items-center">
                <input type="hidden" name="action" value="admin-news">
                <input type="hidden" name="limit" value="<?= $limit ?? 10 ?>">
                <input type="hidden" name="status" id="statusFilter" value="<?= htmlspecialchars($status ?? '') ?>">
                <div class="dropdown">
                    <button class="btn admin-filter-select" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="min-width: 160px; text-align: left;">
                        <?php 
                            if (($status ?? '') === '1') echo 'Xuất bản';
                            elseif (($status ?? '') === '0') echo 'Bản nháp';
                            else echo 'Tất cả trạng thái';
                        ?>
                    </button>
                    <ul class="dropdown-menu shadow border-0" style="border-radius: 16px; min-width: 160px; padding: 8px; margin-top: 6px;">
                        <li><a class="dropdown-item py-2 rounded mb-1 <?= ($status ?? '') === '' ? 'active text-white' : '' ?>" style="<?= ($status ?? '') === '' ? 'background-color: var(--accent);' : '' ?>" href="#" onclick="document.getElementById('statusFilter').value=''; this.closest('form').submit(); return false;">Tất cả trạng thái</a></li>
                        <li><a class="dropdown-item py-2 rounded mb-1 <?= ($status ?? '') === '1' ? 'active text-white' : '' ?>" style="<?= ($status ?? '') === '1' ? 'background-color: var(--accent);' : '' ?>" href="#" onclick="document.getElementById('statusFilter').value='1'; this.closest('form').submit(); return false;">Xuất bản</a></li>
                        <li><a class="dropdown-item py-2 rounded <?= ($status ?? '') === '0' ? 'active text-white' : '' ?>" style="<?= ($status ?? '') === '0' ? 'background-color: var(--accent);' : '' ?>" href="#" onclick="document.getElementById('statusFilter').value='0'; this.closest('form').submit(); return false;">Bản nháp</a></li>
                    </ul>
                </div>
                <div class="position-relative">
                    <i class="bi bi-search position-absolute"
                        style="left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);"></i>
                    <input type="text" name="keyword" class="admin-search-input" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>" placeholder="Tìm bài viết...">
                </div>
            </form>
            <a href="?action=admin-news-categories" class="btn btn-secondary btn-sm">
                <i class="bi bi-tags me-1"></i> Danh mục
            </a>
            <a href="?action=admin-news-form" class="btn btn-accent btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Thêm bài viết mới
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hình ảnh</th>
                    <th>Tiêu đề</th>
                    <th>Danh mục</th>
                    <th>Lượt xem</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($newsList)): ?>
                    <tr><td colspan="8" class="text-center">Chưa có bài viết nào.</td></tr>
                <?php else: ?>
                    <?php foreach ($newsList as $item): ?>
                    <tr>
                        <td class="fw-semibold"><?= htmlspecialchars($item['id']) ?></td>
                        <td>
                            <?php if ($item['image_url']): ?>
                                <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="thumbnail" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-light);">
                            <?php else: ?>
                                <span class="text-muted" style="font-size: 0.85rem;">Không có</span>
                            <?php endif; ?>
                        </td>
                        <td class="fw-semibold" style="max-width: 200px;">
                            <div class="d-flex flex-column">
                                <span class="text-truncate" title="<?= htmlspecialchars($item['title']) ?>"><?= htmlspecialchars($item['title']) ?></span>
                                <?php if ($item['is_featured']): ?>
                                    <span class="badge bg-warning text-dark mt-1" style="width: fit-content; font-size: 0.7rem;"><i class="bi bi-star-fill"></i> Nổi bật</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="text-secondary"><?= htmlspecialchars($item['category_name'] ?? 'Không có') ?></td>
                        <td class="text-secondary"><?= number_format($item['views']) ?></td>
                        <td>
                            <span class="badge <?= $item['status'] == 1 ? 'bg-success' : 'bg-secondary' ?>">
                                <?= $item['status'] == 1 ? 'Xuất bản' : 'Bản nháp' ?>
                            </span>
                        </td>
                        <td class="text-secondary"><?= date('d/m/Y', strtotime($item['created_at'])) ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2 action-dropdown position-relative justify-content-center">
                                <a href="<?= BASE_URL ?>?action=news-detail&slug=<?= $item['slug'] ?>" target="_blank" class="btn-action-detail text-decoration-none">
                                    <i class="bi bi-info-circle"></i> Chi tiết
                                </a>
                                <div class="dropdown dropend">
                                    <button class="btn-action-more dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-custom">
                                        <li>
                                            <a class="dropdown-item" href="<?= BASE_URL ?>?action=admin-news-form&id=<?= $item['id'] ?>">Chỉnh sửa</a>
                                        </li>
                                        <li>
                                            <form method="POST" action="?action=admin-news-delete" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này?');">
                                                <input type="hidden" name="news_id" value="<?= $item['id'] ?>">
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
            <select class="form-select form-select-sm" style="width: auto; border-radius: 4px;" onchange="window.location.href='?action=admin-news&keyword=<?= urlencode($keyword ?? '') ?>&status=<?= urlencode($status ?? '') ?>&limit='+this.value">
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
                            <a class="page-link" href="?action=admin-news&keyword=<?= urlencode($keyword ?? '') ?>&status=<?= urlencode($status ?? '') ?>&limit=<?= $limit ?? 10 ?>&page=<?= ($page ?? 1) - 1 ?>">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        
                        <?php 
                        $start = max(1, ($page ?? 1) - 2);
                        $end = min($totalPages, ($page ?? 1) + 2);
                        
                        if ($start > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?action=admin-news&keyword='.urlencode($keyword ?? '').'&status='.urlencode($status ?? '').'&limit='.($limit ?? 10).'&page=1">1</a></li>';
                            if ($start > 2) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                        }
                        
                        for ($i = $start; $i <= $end; $i++) {
                            $active = ($i == ($page ?? 1)) ? 'active' : '';
                            echo '<li class="page-item ' . $active . '"><a class="page-link" href="?action=admin-news&keyword='.urlencode($keyword ?? '').'&status='.urlencode($status ?? '').'&limit='.($limit ?? 10).'&page='.$i.'">' . $i . '</a></li>';
                        }
                        
                        if ($end < $totalPages) {
                            if ($end < $totalPages - 1) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                            echo '<li class="page-item"><a class="page-link" href="?action=admin-news&keyword='.urlencode($keyword ?? '').'&status='.urlencode($status ?? '').'&limit='.($limit ?? 10).'&page='.$totalPages.'">'.$totalPages.'</a></li>';
                        }
                        ?>
                        
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?action=admin-news&keyword=<?= urlencode($keyword ?? '') ?>&status=<?= urlencode($status ?? '') ?>&limit=<?= $limit ?? 10 ?>&page=<?= ($page ?? 1) + 1 ?>">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>
