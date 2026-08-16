<div class="admin-table-card">
    <div class="card-header-custom">
        <h6><i class="bi bi-lightning-charge me-2"></i>Quản lý Flash Sale</h6>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <a href="<?= BASE_URL ?>?action=admin-flash-sale-form" class="btn btn-accent btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Thêm sự kiện
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sự kiện</th>
                    <th>Thời gian bắt đầu</th>
                    <th>Thời gian kết thúc</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($flashSales)): ?>
                    <tr><td colspan="6" class="text-center text-muted">Chưa có sự kiện Flash Sale nào.</td></tr>
                <?php else: ?>
                    <?php foreach ($flashSales as $fs): ?>
                        <tr>
                            <td class="text-muted fw-medium">#<?= $fs['id'] ?></td>
                            <td class="fw-bold text-dark"><?= htmlspecialchars($fs['title']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($fs['start_time'])) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($fs['end_time'])) ?></td>
                            <td>
                                <?php
                                $now = time();
                                $start = strtotime($fs['start_time']);
                                $end = strtotime($fs['end_time']);
                                if ($fs['status'] == 'inactive') {
                                    echo '<span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle px-2 py-1 rounded-pill">Đã tắt</span>';
                                } elseif ($now < $start) {
                                    echo '<span class="badge bg-warning bg-opacity-10 text-warning border border-warning-subtle px-2 py-1 rounded-pill">Sắp tới</span>';
                                } elseif ($now > $end) {
                                    echo '<span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2 py-1 rounded-pill">Đã kết thúc</span>';
                                } else {
                                    echo '<span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-2 py-1 rounded-pill">Đang diễn ra</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2 action-dropdown position-relative">
                                    <a href="<?= BASE_URL ?>?action=admin-flash-sale-items&id=<?= $fs['id'] ?>" class="btn-action-detail text-decoration-none">
                                        <i class="bi bi-box-seam"></i> Sản phẩm
                                    </a>
                                    <div class="dropdown dropend">
                                        <button class="btn-action-more dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-custom">
                                            <li>
                                                <a class="dropdown-item" href="<?= BASE_URL ?>?action=admin-flash-sale-form&id=<?= $fs['id'] ?>">Chỉnh sửa</a>
                                            </li>
                                            <li>
                                                <form method="POST" action="?action=admin-flash-sale-delete" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sự kiện này?');">
                                                    <input type="hidden" name="id" value="<?= $fs['id'] ?>">
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
