<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="admin-table-card">
    <div class="card-header-custom">
        <h6><i class="bi bi-tags me-2"></i>Quản lý Thuộc tính Sản phẩm</h6>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <button type="button" class="btn btn-accent btn-sm" data-bs-toggle="modal" data-bs-target="#addAttrModal">
                <i class="bi bi-plus-lg me-1"></i> Thêm Thuộc Tính
            </button>
        </div>
    </div>

    <div class="p-4">
        <div class="row g-4">
            <?php foreach ($attributes as $attr): ?>
                <div class="col-md-6">
                    <div class="card shadow-sm h-100 border-0" style="background: #f8fafc;">
                        <div class="card-header bg-transparent border-bottom-0 d-flex justify-content-between align-items-center pt-4 px-4 pb-0">
                            <h5 class="mb-0 fw-bold" style="color: #1e293b;"><?= htmlspecialchars($attr['attribute_name']) ?></h5>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" style="background: white; border: 1px solid #e2e8f0;">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li>
                                        <a class="dropdown-item edit-attr-btn" href="#" 
                                           data-id="<?= $attr['attribute_id'] ?>" 
                                           data-name="<?= htmlspecialchars($attr['attribute_name']) ?>"
                                           data-bs-toggle="modal" data-bs-target="#editAttrModal"><i class="bi bi-pencil me-2"></i> Chỉnh sửa tên</a>
                                    </li>
                                    <li>
                                        <form method="POST" action="<?= BASE_URL ?>?action=admin-attribute-delete" onsubmit="return confirm('Xóa thuộc tính này sẽ xóa tất cả các giá trị của nó. Bạn có chắc không?');">
                                            <input type="hidden" name="attribute_id" value="<?= $attr['attribute_id'] ?>">
                                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i> Xóa thuộc tính</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex flex-wrap gap-2 mb-4">
                                <?php foreach ($attr['values'] as $val): ?>
                                    <div class="badge bg-white text-dark border p-2 d-flex align-items-center shadow-sm" style="font-weight: 500;">
                                        <span class="me-2"><?= htmlspecialchars($val['attribute_value']) ?></span>
                                        <form method="POST" action="<?= BASE_URL ?>?action=admin-attribute-value-delete" class="d-inline m-0 p-0" onsubmit="return confirm('Bạn có chắc chắn muốn xóa giá trị này?');">
                                            <input type="hidden" name="attribute_value_id" value="<?= $val['attribute_value_id'] ?>">
                                            <button type="submit" class="btn-close" style="font-size: 0.5rem;"></button>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                                <?php if (empty($attr['values'])): ?>
                                    <span class="text-muted small italic">Chưa có giá trị nào.</span>
                                <?php endif; ?>
                            </div>
                            <form method="POST" action="<?= BASE_URL ?>?action=admin-attribute-value-create" class="d-flex gap-2 mt-auto">
                                <input type="hidden" name="attribute_id" value="<?= $attr['attribute_id'] ?>">
                                <input type="text" class="form-control form-control-sm" name="attribute_value" placeholder="Thêm giá trị mới (VD: Đỏ, 8GB...)" required style="border: 1px solid #cbd5e1;">
                                <button type="submit" class="btn btn-sm btn-outline-primary whitespace-nowrap">Thêm</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($attributes)): ?>
                <div class="col-12 text-center py-5">
                    <div class="text-muted mb-3"><i class="bi bi-tags" style="font-size: 3rem;"></i></div>
                    <h5 class="text-secondary fw-semibold">Chưa có thuộc tính nào được tạo.</h5>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Add Attribute -->
<div class="modal fade" id="addAttrModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form method="POST" action="<?= BASE_URL ?>?action=admin-attribute-create">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold">Thêm Thuộc Tính Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="mb-2">
                        <label class="form-label fw-semibold text-secondary">Tên Thuộc Tính <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="attribute_name" placeholder="VD: Màu sắc, RAM, Bộ nhớ..." required>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary px-4">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Attribute -->
<div class="modal fade" id="editAttrModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form method="POST" action="<?= BASE_URL ?>?action=admin-attribute-update">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold">Sửa Tên Thuộc Tính</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-4">
                    <input type="hidden" name="attribute_id" id="edit_attr_id">
                    <div class="mb-2">
                        <label class="form-label fw-semibold text-secondary">Tên Thuộc Tính <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="attribute_name" id="edit_attr_name" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary px-4">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editBtns = document.querySelectorAll('.edit-attr-btn');
    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('edit_attr_id').value = this.dataset.id;
            document.getElementById('edit_attr_name').value = this.dataset.name;
        });
    });
});
</script>
