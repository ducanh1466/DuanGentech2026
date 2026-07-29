<div class="admin-table-card">
    <div class="card-header-custom">
        <h6><i class="bi bi-tags me-2"></i>Quản lý danh mục</h6>
        <button class="btn btn-accent btn-sm" data-bs-toggle="modal" data-bs-target="#categoryModal">
            <i class="bi bi-plus-lg me-1"></i> Thêm danh mục
        </button>
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
                <div class="table-actions">
                    <button class="btn btn-sm btn-outline-primary" onclick="editCategory(<?= $cat['category_id'] ?>, '<?= htmlspecialchars(addslashes($cat['category_name'])) ?>', '<?= htmlspecialchars(addslashes($cat['description'] ?? '')) ?>')" data-bs-toggle="modal" data-bs-target="#categoryModal"><i class="bi bi-pencil"></i></button>
                    <form method="POST" action="" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                     <input type="hidden" name="action_type" value="delete">
                     <input type="hidden" name="category_id" value="<?= $cat['category_id'] ?>">
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

<!-- Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Thêm danh mục</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form method="POST" action="">
            <input type="hidden" name="action_type" id="actionType" value="create">
            <input type="hidden" name="category_id" id="categoryId" value="">
                
            <div class="modal-body">
            <div class="mb-3">
                <label class="form-label fw-semibold">Tên danh mục <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" id="categoryName" placeholder="Nhập tên danh mục..." required
                            style="border:2px solid var(--border-color);border-radius:var(--radius-md);padding:10px 14px;background:var(--bg-primary);color:var(--text-primary);">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Mô tả</label>
                <textarea class="form-control" name="description" id="categoryDesc" rows="3" placeholder="Mô tả danh mục..."
                    style="border:2px solid var(--border-color);border-radius:var(--radius-md);padding:10px 14px;background:var(--bg-primary);color:var(--text-primary);"></textarea>
                </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-accent">Lưu danh mục</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
function editCategory(id, name, desc) {
    document.getElementById('modalTitle').innerText = 'Sửa danh mục';
    document.getElementById('actionType').value = 'update';
    document.getElementById('categoryId').value = id;
    document.getElementById('categoryName').value = name;
    document.getElementById('categoryDesc').value = desc;
}

// Reset modal on close
document.getElementById('categoryModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('modalTitle').innerText = 'Thêm danh mục';
    document.getElementById('actionType').value = 'create';
    document.getElementById('categoryId').value = '';
    document.getElementById('categoryName').value = '';
    document.getElementById('categoryDesc').value = '';
});
</script>
