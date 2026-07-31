<div class="admin-table-card">
    <div class="card-header-custom">
        <h6>
            <i class="bi bi-people-fill me-2"></i>Quản lý người dùng
        </h6>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <form method="GET" class="d-flex">
                <input type="hidden" name="action" value="admin-users">
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
    <div class="d-flex justify-content-between align-items-center p-3 border-top"
        style="border-color:var(--border-light)!important">
        <span class="text-muted" style="font-size:0.85rem;">
            Hiển thị <?= count($users) ?> người dùng
        </span>
    </div>
</div>