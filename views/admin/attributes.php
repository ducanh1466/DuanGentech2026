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
            <form method="GET" class="d-flex gap-2 m-0 p-0 align-items-center">
                <input type="hidden" name="action" value="admin-attributes">
                <input type="hidden" name="limit" value="<?= $limit ?? 10 ?>">
                <div class="position-relative">
                    <i class="bi bi-search position-absolute"
                        style="left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);"></i>
                    <input type="text" name="keyword" class="admin-search-input" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>" placeholder="Tìm thuộc tính...">
                </div>
            </form>
            <button type="button" class="btn btn-accent btn-sm" data-bs-toggle="modal" data-bs-target="#addAttrModal">
                <i class="bi bi-plus-lg me-1"></i> Thêm Thuộc Tính
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 25%">Tên thuộc tính</th>
                    <th style="width: 55%">Các giá trị (Values)</th>
                    <th style="width: 15%">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($attributes)): ?>
                    <tr><td colspan="4" class="text-center">Chưa có thuộc tính nào.</td></tr>
                <?php else: ?>
                    <?php foreach ($attributes as $i => $attr): ?>
                    <tr>
                        <td class="fw-semibold"><?= $i + 1 ?></td>
                        <td class="fw-semibold"><?= htmlspecialchars($attr['attribute_name']) ?></td>
                        <td>
                            <div class="d-flex flex-wrap gap-1 align-items-center">
                                <?php if (empty($attr['values'])): ?>
                                    <span class="text-muted small">Chưa có giá trị</span>
                                <?php else: ?>
                                    <?php 
                                        $vals = array_map(function($v) { return htmlspecialchars($v['attribute_value']); }, $attr['values']);
                                        echo implode(', ', $vals);
                                    ?>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2 action-dropdown position-relative">
                                <a href="<?= BASE_URL ?>?action=admin-attribute-detail&id=<?= $attr['attribute_id'] ?>" class="btn-action-detail text-decoration-none">
                                    <i class="bi bi-info-circle"></i> Chi tiết
                                </a>
                                <div class="dropdown dropend">
                                    <button class="btn-action-more dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-custom">
                                        <li>
                                            <a class="dropdown-item edit-attr-btn" href="#" 
                                               data-id="<?= $attr['attribute_id'] ?>" 
                                               data-name="<?= htmlspecialchars($attr['attribute_name']) ?>"
                                               data-bs-toggle="modal" data-bs-target="#editAttrModal">Chỉnh sửa tên</a>
                                        </li>
                                        <li>
                                            <form method="POST" action="<?= BASE_URL ?>?action=admin-attribute-delete" onsubmit="return confirm('Xóa thuộc tính này sẽ xóa tất cả các giá trị của nó. Bạn có chắc không?');">
                                                <input type="hidden" name="attribute_id" value="<?= $attr['attribute_id'] ?>">
                                                <button type="submit" class="dropdown-item text-danger">Xóa thuộc tính</button>
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
            <select class="form-select form-select-sm" style="width: auto; border-radius: 4px;" onchange="window.location.href='?action=admin-attributes&keyword=<?= urlencode($keyword ?? '') ?>&limit='+this.value">
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
                            <a class="page-link" href="?action=admin-attributes&keyword=<?= urlencode($keyword ?? '') ?>&limit=<?= $limit ?? 10 ?>&page=<?= ($page ?? 1) - 1 ?>">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        
                        <?php 
                        $start = max(1, ($page ?? 1) - 2);
                        $end = min($totalPages, ($page ?? 1) + 2);
                        
                        if ($start > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?action=admin-attributes&keyword='.urlencode($keyword ?? '').'&limit='.($limit ?? 10).'&page=1">1</a></li>';
                            if ($start > 2) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                        }
                        
                        for ($i = $start; $i <= $end; $i++) {
                            $active = ($i == ($page ?? 1)) ? 'active' : '';
                            echo '<li class="page-item ' . $active . '"><a class="page-link" href="?action=admin-attributes&keyword='.urlencode($keyword ?? '').'&limit='.($limit ?? 10).'&page='.$i.'">' . $i . '</a></li>';
                        }
                        
                        if ($end < $totalPages) {
                            if ($end < $totalPages - 1) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                            echo '<li class="page-item"><a class="page-link" href="?action=admin-attributes&keyword='.urlencode($keyword ?? '').'&limit='.($limit ?? 10).'&page='.$totalPages.'">'.$totalPages.'</a></li>';
                        }
                        ?>
                        
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?action=admin-attributes&keyword=<?= urlencode($keyword ?? '') ?>&limit=<?= $limit ?? 10 ?>&page=<?= ($page ?? 1) + 1 ?>">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Add Attribute -->
<div class="modal fade" id="addAttrModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form method="POST" action="<?= BASE_URL ?>?action=admin-attribute-create">
                <div class="modal-header border-bottom-0 pb-0 mt-3 mx-2">
                    <h5 class="modal-title fw-bold">Thêm thuộc tính mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-4 mx-2">
                    <div class="row form-horizontal-row align-items-center">
                        <div class="col-md-4">
                            <label class="form-horizontal-label mb-0">Tên thuộc tính <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="attribute_name" placeholder="VD: Màu sắc, RAM, Bộ nhớ..." required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 mx-2 mb-3">
                    <button type="button" class="btn-form-close text-decoration-none d-inline-flex align-items-center me-2" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i> Hủy
                    </button>
                    <button type="submit" class="btn-form-save d-inline-flex align-items-center">
                        <i class="bi bi-save me-1"></i> Lưu thông tin
                    </button>
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
                <div class="modal-header border-bottom-0 pb-0 mt-3 mx-2">
                    <h5 class="modal-title fw-bold">Chỉnh sửa thuộc tính</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-4 mx-2">
                    <input type="hidden" name="attribute_id" id="edit_attr_id">
                    <div class="row form-horizontal-row align-items-center">
                        <div class="col-md-4">
                            <label class="form-horizontal-label mb-0">Tên thuộc tính <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="attribute_name" id="edit_attr_name" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 mx-2 mb-3">
                    <button type="button" class="btn-form-close text-decoration-none d-inline-flex align-items-center me-2" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i> Hủy
                    </button>
                    <button type="submit" class="btn-form-save d-inline-flex align-items-center">
                        <i class="bi bi-save me-1"></i> Cập nhật
                    </button>
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
