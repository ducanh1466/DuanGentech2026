<div class="admin-table-card">
    <div class="card-header-custom">
        <h6>
            <i class="bi bi-people-fill me-2"></i>Quản lý người dùng
        </h6>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <form method="GET" class="d-flex">
                <input type="hidden" name="action" value="admin-users">
                <input type="hidden" name="limit" value="<?= $limit ?? 10 ?>">
                <div class="position-relative">
                    <i class="bi bi-search position-absolute"
                        style="left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);"></i>
                    <input
                        type="text"
                        name="keyword"
                        class="admin-search-input"
                        placeholder="Tìm người dùng..."
                        value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                </div>
            </form>
            <a
                href="<?= BASE_URL ?>?action=admin-user-create"
                class="btn btn-accent btn-sm">
                <i class="bi bi-plus-lg me-1"></i>
                Thêm người dùng
            </a>
        </div>
    </div>
    <?php if (!empty($_SESSION['success'])) : ?>
        <div class="alert alert-success m-3">
            <?= $_SESSION['success']; ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])) : ?>
        <div class="alert alert-danger m-3">
            <?= $_SESSION['error']; ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>SĐT</th>
                    <th>Vai trò</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)) : ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            Không có người dùng nào.
                        </td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($users as $index => $user) : ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <div class="fw-semibold">
                                    <?= htmlspecialchars($user['full_name']) ?>
                                </div>
                            </td>
                            <td>
                                <?= htmlspecialchars($user['email']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($user['phone']) ?>
                            </td>
                            <td>
                                <?php if ($user['role'] == 1) : ?>
                                    <span class="badge bg-danger">
                                        Admin
                                    </span>
                                <?php elseif ($user['role'] == 2) : ?>
                                    <span class="badge bg-success">
                                        Nhân viên
                                    </span>
                                <?php else : ?>
                                    <span class="badge bg-primary">
                                        Khách hàng
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($user['status'] == 1) : ?>
                                    <span class="status-badge active">
                                        Hoạt động
                                    </span>
                                <?php else : ?>
                                    <span class="status-badge inactive">
                                        Đã khóa
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2 action-dropdown position-relative">
                                    <a href="<?= BASE_URL ?>?action=admin-user-edit&id=<?= $user['user_id'] ?>" class="btn-action-detail text-decoration-none">
                                        <i class="bi bi-info-circle"></i> Chi tiết
                                    </a>
                                    <div class="dropdown dropend">
                                        <button class="btn-action-more dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-custom">
                                            <li>
                                                <a class="dropdown-item" href="<?= BASE_URL ?>?action=admin-user-edit&id=<?= $user['user_id'] ?>">Chỉnh sửa</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="<?= BASE_URL ?>?action=admin-user-delete&id=<?= $user['user_id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');">Xóa</a>
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
            <select class="form-select form-select-sm" style="width: auto; border-radius: 4px;" onchange="window.location.href='?action=admin-users&keyword=<?= urlencode($keyword ?? '') ?>&limit='+this.value">
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
                            <a class="page-link" href="?action=admin-users&keyword=<?= urlencode($keyword ?? '') ?>&limit=<?= $limit ?? 10 ?>&page=<?= ($page ?? 1) - 1 ?>">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        
                        <?php 
                        $start = max(1, ($page ?? 1) - 2);
                        $end = min($totalPages, ($page ?? 1) + 2);
                        
                        if ($start > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?action=admin-users&keyword='.urlencode($keyword ?? '').'&limit='.($limit ?? 10).'&page=1">1</a></li>';
                            if ($start > 2) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                        }
                        
                        for ($i = $start; $i <= $end; $i++) {
                            $active = ($i == ($page ?? 1)) ? 'active' : '';
                            echo '<li class="page-item ' . $active . '"><a class="page-link" href="?action=admin-users&keyword='.urlencode($keyword ?? '').'&limit='.($limit ?? 10).'&page='.$i.'">' . $i . '</a></li>';
                        }
                        
                        if ($end < $totalPages) {
                            if ($end < $totalPages - 1) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                            echo '<li class="page-item"><a class="page-link" href="?action=admin-users&keyword='.urlencode($keyword ?? '').'&limit='.($limit ?? 10).'&page='.$totalPages.'">'.$totalPages.'</a></li>';
                        }
                        ?>
                        
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?action=admin-users&keyword=<?= urlencode($keyword ?? '') ?>&limit=<?= $limit ?? 10 ?>&page=<?= ($page ?? 1) + 1 ?>">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>