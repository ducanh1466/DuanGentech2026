<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success'];
    unset($_SESSION['success']); ?></div>
<?php endif; ?>

<div class="admin-table-card">
    <div class="card-header-custom">
        <h6><i class="bi bi-people me-2"></i>Quản lý người dùng</h6>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <div class="position-relative">
                <i class="bi bi-search position-absolute"
                    style="left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);"></i>
                <input type="text" class="admin-search-input" id="adminTableSearch" placeholder="Tìm người dùng...">
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>SĐT</th>
                    <th>Vai trò</th>
                    <th>Ngày đăng ký</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="8" class="text-center">Chưa có người dùng nào.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $i => $user): ?>
                        <tr>
                            <td class="fw-semibold"><?= $i + 1 ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div
                                        style="width:34px;height:34px;border-radius:50%;background:var(--accent-gradient);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.8rem;">
                                        <?= mb_substr(htmlspecialchars($user['full_name']), 0, 1) ?>
                                    </div>
                                    <span class="fw-semibold"><?= htmlspecialchars($user['full_name']) ?></span>
                                </div>
                            </td>
                            <td class="text-secondary"><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['phone'] ?? '') ?></td>
                            <td>
                                <?php if ($user['role'] == 1): ?>
                                    <span class="badge bg-primary rounded-pill">Admin</span>
                                <?php elseif ($user['role'] == 2): ?>
                                    <span class="badge bg-info rounded-pill text-dark">Nhân viên</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary rounded-pill">Khách hàng</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-secondary">
                                <?= !empty($user['registered_at']) ? date('d/m/Y', strtotime($user['registered_at'])) : 'Không có' ?>
                            </td>
                            <td>
                                <span class="status-badge <?= $user['status'] == 1 ? 'active' : 'inactive' ?>">
                                    <?= $user['status'] == 1 ? 'Hoạt động' : 'Vô hiệu' ?>
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="<?= BASE_URL ?>?action=admin-user-edit&id=<?= $user['user_id'] ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>