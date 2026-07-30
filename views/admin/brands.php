<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<div class="admin-table-card">
    <div class="card-header-custom">
        <h6><i class="bi bi-star me-2"></i>Quản lý thương hiệu</h6>
        <button class="btn btn-accent btn-sm" data-bs-toggle="modal" data-bs-target="#brandModal">
            <i class="bi bi-plus-lg me-1"></i> Thêm thương hiệu
        </button>
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
                            <div class="table-actions">
                                <button class="btn btn-sm btn-outline-primary" onclick="editBrand(<?= $brand['brand_id'] ?>, '<?= htmlspecialchars(addslashes($brand['brand_name'])) ?>', '<?= htmlspecialchars(addslashes($brand['description'] ?? '')) ?>', <?= $brand['status'] ?>)" data-bs-toggle="modal" data-bs-target="#brandModal"><i class="bi bi-pencil"></i></button>
                                <form method="POST" action="" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thương hiệu này?');">
                                    <input type="hidden" name="action_type" value="delete">
                                    <input type="hidden" name="brand_id" value="<?= $brand['brand_id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Brand Modal -->
<div class="modal fade" id="brandModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Thêm thương hiệu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="action_type" id="actionType" value="create">
                <input type="hidden" name="brand_id" id="brandId" value="">
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tên thương hiệu <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="brandName" placeholder="Nhập tên thương hiệu..." required
                            style="border:2px solid var(--border-color);border-radius:var(--radius-md);padding:10px 14px;background:var(--bg-primary);color:var(--text-primary);">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mô tả</label>
                        <textarea class="form-control" name="description" id="brandDesc" rows="3" placeholder="Mô tả thương hiệu..."
                            style="border:2px solid var(--border-color);border-radius:var(--radius-md);padding:10px 14px;background:var(--bg-primary);color:var(--text-primary);"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Trạng thái</label>
                        <select class="form-select" name="status" id="brandStatus"
                            style="border:2px solid var(--border-color);border-radius:var(--radius-md);padding:10px 14px;background:var(--bg-primary);color:var(--text-primary);">
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-accent">Lưu thương hiệu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editBrand(id, name, desc, status) {
    document.getElementById('modalTitle').innerText = 'Sửa thương hiệu';
    document.getElementById('actionType').value = 'update';
    document.getElementById('brandId').value = id;
    document.getElementById('brandName').value = name;
    document.getElementById('brandDesc').value = desc;
    document.getElementById('brandStatus').value = status;
}

// Reset modal on close
document.getElementById('brandModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('modalTitle').innerText = 'Thêm thương hiệu';
    document.getElementById('actionType').value = 'create';
    document.getElementById('brandId').value = '';
    document.getElementById('brandName').value = '';
    document.getElementById('brandDesc').value = '';
    document.getElementById('brandStatus').value = '1';
});
</script>
