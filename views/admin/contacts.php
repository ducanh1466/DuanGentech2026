<?php
$pageTitle = 'Quản lý yêu cầu phản ánh';
?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle-fill me-2"></i> <?= $_SESSION['success'];
        unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $_SESSION['error'];
        unset($_SESSION['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="admin-table-card">
    <div class="card-header-custom d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold"><i class="bi bi-headset me-2"></i>Danh sách yêu cầu phản ánh</h6>
    </div>

    <div class="p-3 border-bottom bg-light">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <!-- Filter Form -->
            <form method="GET" class="d-flex align-items-center gap-2 flex-grow-1" style="max-width: 850px;">
                <input type="hidden" name="action" value="admin-contacts">

                <div class="position-relative" style="width: 220px;">
                    <i class="bi bi-search position-absolute"
                        style="left:10px;top:50%;transform:translateY(-50%);color:var(--text-muted); font-size: 0.875rem;"></i>
                    <input type="text" name="keyword" class="form-control form-control-sm ps-4"
                        value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>"
                        placeholder="Tìm ID, SĐT, Tên...">
                </div>

                <select name="status" class="form-select form-select-sm" style="width: 140px;">
                    <option value="">Tất cả trạng thái</option>
                    <option value="pending" <?= ($status ?? '') === 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
                    <option value="processing" <?= ($status ?? '') === 'processing' ? 'selected' : '' ?>>Đang xử lý</option>
                    <option value="resolved" <?= ($status ?? '') === 'resolved' ? 'selected' : '' ?>>Đã xử lý</option>
                    <option value="reprocess" <?= ($status ?? '') === 'reprocess' ? 'selected' : '' ?>>Xử lý lại</option>
                    <option value="closed" <?= ($status ?? '') === 'closed' ? 'selected' : '' ?>>Đã đóng</option>
                    <option value="rejected" <?= ($status ?? '') === 'rejected' ? 'selected' : '' ?>>Từ chối</option>
                </select>
                
                <?php if ($_SESSION['user']['role'] == 1): ?>
                <select name="department" class="form-select form-select-sm" style="width: 130px;">
                    <option value="">Phòng ban</option>
                    <option value="CSKH" <?= ($_GET['department'] ?? '') === 'CSKH' ? 'selected' : '' ?>>CSKH</option>
                    <option value="KyThuat" <?= ($_GET['department'] ?? '') === 'KyThuat' ? 'selected' : '' ?>>Kỹ Thuật</option>
                </select>
                <?php endif; ?>

                <div class="d-flex align-items-center gap-1">
                    <input type="date" name="start_date" class="form-control form-control-sm"
                        value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>" title="Từ ngày">
                    <span class="text-muted small">-</span>
                    <input type="date" name="end_date" class="form-control form-control-sm"
                        value="<?= htmlspecialchars($_GET['end_date'] ?? '') ?>" title="Đến ngày">
                </div>

                <button type="submit" class="btn btn-sm btn-primary text-nowrap px-3"><i class="bi bi-search me-1"></i> Tìm kiếm</button>
            </form>

            <!-- Bulk Actions Toolbar -->
            <div class="d-flex align-items-center gap-2">
                <button type="button" onclick="submitBulk('processing')" class="btn btn-sm btn-info text-white shadow-sm">Tiếp nhận</button>
                <button type="button" onclick="submitBulk('resolved')" class="btn btn-sm btn-success text-white shadow-sm">Đã xử lý</button>
                <button type="button" onclick="submitBulk('rejected')" class="btn btn-sm btn-danger text-white shadow-sm">Từ chối</button>
            </div>
        </div>
    </div>

    <form id="bulkForm" action="?action=admin-contact-bulk" method="POST">
        <input type="hidden" name="bulk_action" id="bulkActionInput" value="">
        <div class="table-responsive">
            <table class="table admin-table mb-0 align-middle table-hover">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40px;"><input class="form-check-input" type="checkbox" id="checkAll"></th>
                        <th>ID</th>
                        <th>Người phản ánh</th>
                        <th>Loại phản ánh</th>
                        <th>Sản phẩm</th>
                        <th>Phòng ban</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($contacts)): ?>
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">Không tìm thấy yêu cầu phản ánh nào.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($contacts as $contact): ?>
                            <tr>
                                <td><input class="form-check-input contact-checkbox" type="checkbox" name="contact_ids[]" value="<?= $contact['id'] ?>"></td>
                                <td class="text-muted">#<?= htmlspecialchars($contact['id']) ?></td>
                                <td>
                                    <div class="fw-medium"><?= htmlspecialchars($contact['fullname']) ?></div>
                                    <small class="text-muted"><i class="bi bi-telephone"></i> <?= htmlspecialchars($contact['phone']) ?></small>
                                </td>
                                <td><?= htmlspecialchars($contact['type']) ?></td>
                                <td>
                                    <div class="text-truncate" style="max-width: 150px;" title="<?= htmlspecialchars($contact['product_model'] ?? '') ?>">
                                        <?= htmlspecialchars($contact['product_model'] ?: 'N/A') ?>
                                    </div>
                                    <small class="text-muted">SN: <?= htmlspecialchars($contact['serial_number'] ?: 'N/A') ?></small>
                                </td>
                                <td>
                                    <?php if (($contact['assigned_department'] ?? 'CSKH') === 'CSKH'): ?>
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary">CSKH</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning">Kỹ Thuật</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($contact['status'] === 'pending'): ?>
                                        <span class="badge bg-secondary text-white">Chờ xử lý</span>
                                    <?php elseif ($contact['status'] === 'rejected'): ?>
                                        <span class="badge bg-danger text-white">Từ chối</span>
                                    <?php elseif ($contact['status'] === 'processing'): ?>
                                        <span class="badge bg-info text-dark">Đang xử lý</span>
                                    <?php elseif ($contact['status'] === 'resolved'): ?>
                                        <span class="badge bg-success text-white">Đã xử lý</span>
                                    <?php elseif ($contact['status'] === 'closed'): ?>
                                        <span class="badge bg-dark text-white">Đã đóng</span>
                                    <?php elseif ($contact['status'] === 'reprocess'): ?>
                                        <span class="badge bg-warning text-dark">Xử lý lại</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($contact['created_at'])) ?></td>
                                <td>
                                    <button type="button" class="btn-action-detail" onclick="openDetailModal(<?= $contact['id'] ?>)">
                                        <i class="bi bi-info-circle"></i> Chi tiết
                                    </button>
                                </td>
                            </tr>

                            <!-- Detail Modal & Data Storage -->
                            <div id="contactData<?= $contact['id'] ?>" class="d-none">
                                <?= htmlspecialchars(json_encode($contact)) ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </form>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center p-3 border-top" style="border-color:var(--border-light)!important">
        <!-- Chỉnh số lượng hiển thị -->
        <div class="d-flex align-items-center gap-2">
            <?php
                $queryParamsLimit = $_GET;
                unset($queryParamsLimit['limit']);
                unset($queryParamsLimit['page']);
                $queryStringLimit = http_build_query($queryParamsLimit);
                $queryStringLimit = $queryStringLimit ? '&' . $queryStringLimit : '';
            ?>
            <select class="form-select form-select-sm" style="width: auto; border-radius: 4px;" onchange="window.location.href='?<?= $queryStringLimit ?>&limit='+this.value">
                <option value="10" <?= ($limit ?? 10) == 10 ? 'selected' : '' ?>>10 / trang</option>
                <option value="20" <?= ($limit ?? 10) == 20 ? 'selected' : '' ?>>20 / trang</option>
                <option value="50" <?= ($limit ?? 10) == 50 ? 'selected' : '' ?>>50 / trang</option>
                <option value="100" <?= ($limit ?? 10) == 100 ? 'selected' : '' ?>>100 / trang</option>
            </select>
        </div>

        <div class="d-flex align-items-center gap-3">
            <span class="text-muted" style="font-size:0.85rem;">Tổng <?= $totalContacts ?? 0 ?> bản ghi</span>
            
            <?php if (isset($totalPages) && $totalPages > 1): ?>
                <?php
                    $queryParamsPage = $_GET;
                    unset($queryParamsPage['page']);
                    $queryStringPage = http_build_query($queryParamsPage);
                    $queryStringPage = $queryStringPage ? '&' . $queryStringPage : '';
                ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?<?= $queryStringPage ?>&page=<?= ($page ?? 1) - 1 ?>">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        
                        <?php 
                        $start = max(1, ($page ?? 1) - 2);
                        $end = min($totalPages, ($page ?? 1) + 2);
                        
                        if ($start > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?'.$queryStringPage.'&page=1">1</a></li>';
                            if ($start > 2) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                        }
                        
                        for ($i = $start; $i <= $end; $i++) {
                            $active = ($i == ($page ?? 1)) ? 'active' : '';
                            echo '<li class="page-item ' . $active . '"><a class="page-link" href="?'.$queryStringPage.'&page='.$i.'">' . $i . '</a></li>';
                        }
                        
                        if ($end < $totalPages) {
                            if ($end < $totalPages - 1) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                            echo '<li class="page-item"><a class="page-link" href="?'.$queryStringPage.'&page='.$totalPages.'">'.$totalPages.'</a></li>';
                        }
                        ?>
                        
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?<?= $queryStringPage ?>&page=<?= ($page ?? 1) + 1 ?>">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- SINGLE DETAIL MODAL (Image 2 representation) -->
<div class="modal fade" id="mainDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header border-bottom bg-light">
                <h5 class="modal-title fw-bold" id="modalTitle">Chi tiết yêu cầu phản ánh</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" style="background-color: #f8f9fa;">
                <div class="row g-4">
                    <!-- Column 1: Info -->
                    <div class="col-md-8">
                        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 border-bottom pb-2">Thông tin chung</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <small class="text-muted d-block">ID</small>
                                        <div class="fw-medium" id="det_id"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted d-block">Người phản ánh</small>
                                        <div class="fw-medium" id="det_fullname"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted d-block">Số điện thoại</small>
                                        <div class="fw-medium text-primary" id="det_phone"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted d-block">Loại phản ánh</small>
                                        <div class="fw-medium" id="det_type"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted d-block">Tên máy / Model</small>
                                        <div class="fw-medium" id="det_model"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted d-block">Số Serial / IMEI</small>
                                        <div class="fw-medium" id="det_serial"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 border-bottom pb-2">Nội dung phản ánh</h6>
                                <div id="det_message" class="bg-light p-3 rounded" style="white-space: pre-wrap;"></div>
                                
                                <div class="mt-3" id="det_attachment_container" style="display:none;">
                                    <small class="text-muted d-block mb-2">File đính kèm:</small>
                                    <a href="#" id="det_attachment_link" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-file-earmark-image"></i> Xem đính kèm
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Actions & History -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                            <div class="card-body bg-white rounded-3">
                                <h6 class="fw-bold mb-3 border-bottom pb-2">Quản lý trạng thái</h6>
                                
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Phòng ban xử lý</label>
                                    <select class="form-select" id="det_department_select" onchange="openNoteModal('department', this.value)">
                                        <option value="CSKH">Chăm sóc khách hàng (CSKH)</option>
                                        <option value="KyThuat">Phòng Kỹ Thuật</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label text-muted small">Trạng thái hiện tại</label>
                                    <select class="form-select" id="det_status_select" onchange="openNoteModal('status', this.value)">
                                        <option value="pending">Chờ xử lý</option>
                                        <option value="processing">Đang xử lý</option>
                                        <option value="resolved">Đã xử lý</option>
                                        <option value="closed">Đã đóng</option>
                                        <option value="reprocess">Xử lý lại</option>
                                        <option value="rejected">Từ chối</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Full width Logs -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 border-bottom pb-2">Lịch sử xử lý</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Thời gian</th>
                                                <th>Người xử lý</th>
                                                <th>Hành động</th>
                                                <th>Nội dung / Ghi chú</th>
                                            </tr>
                                        </thead>
                                        <tbody id="logs_tbody">
                                            <tr><td colspan="4" class="text-center text-muted">Đang tải...</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- NOTE MODAL (Image 4 representation) -->
<div class="modal fade" id="noteModal" tabindex="-1" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 12px;">
            <form id="actionForm" method="POST" action="">
                <input type="hidden" name="contact_id" id="note_contact_id">
                <input type="hidden" name="status" id="note_status_val">
                <input type="hidden" name="department" id="note_department_val">
                
                <div class="modal-header bg-primary text-white" style="border-radius: 12px 12px 0 0;">
                    <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Nhập nội dung xử lý</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">Bạn đang thay đổi <span id="note_action_desc" class="fw-bold text-dark"></span>. Vui lòng nhập nội dung xử lý để lưu vào lịch sử.</p>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nội dung <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="note" rows="4" required placeholder="Ví dụ: Khách gọi báo lỗi màn hình, đã chuyển kỹ thuật kiểm tra..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Lưu xác nhận</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentContactId = 0;
    
    document.getElementById('checkAll').addEventListener('change', function() {
        document.querySelectorAll('.contact-checkbox').forEach(cb => cb.checked = this.checked);
    });

    function submitBulk(action) {
        let checked = document.querySelectorAll('.contact-checkbox:checked');
        if(checked.length === 0) {
            alert('Vui lòng chọn ít nhất 1 phản ánh để thao tác!');
            return;
        }
        document.getElementById('bulkActionInput').value = action;
        document.getElementById('bulkForm').submit();
    }

    function openDetailModal(id) {
        currentContactId = id;
        const dataStr = document.getElementById('contactData' + id).innerText;
        const data = JSON.parse(dataStr);
        
        document.getElementById('det_id').innerText = '#' + data.id;
        document.getElementById('det_fullname').innerText = data.fullname;
        document.getElementById('det_phone').innerText = data.phone;
        document.getElementById('det_type').innerText = data.type;
        document.getElementById('det_model').innerText = data.product_model || 'Không có';
        document.getElementById('det_serial').innerText = data.serial_number || 'Không có';
        document.getElementById('det_message').innerText = data.message;
        
        document.getElementById('det_department_select').value = data.assigned_department || 'CSKH';
        document.getElementById('det_status_select').value = data.status;

        if (data.attached_file) {
            document.getElementById('det_attachment_container').style.display = 'block';
            document.getElementById('det_attachment_link').href = '<?= BASE_URL ?>assets/uploads/supports/' + data.attached_file;
        } else {
            document.getElementById('det_attachment_container').style.display = 'none';
        }

        document.getElementById('logs_tbody').innerHTML = '<tr><td colspan="4" class="text-center text-muted">Đang tải...</td></tr>';
        fetch('<?= BASE_URL ?>?action=admin-contact-logs&id=' + id)
            .then(res => res.json())
            .then(logs => {
                let html = '';
                if(logs.length === 0) {
                    html = '<tr><td colspan="4" class="text-center text-muted">Chưa có lịch sử xử lý</td></tr>';
                } else {
                    logs.forEach(log => {
                        let date = new Date(log.created_at).toLocaleString('vi-VN');
                        html += `
                            <tr>
                                <td><small class="text-muted">${date}</small></td>
                                <td><span class="badge bg-light text-dark border"><i class="bi bi-person"></i> ${log.user_name || 'Khách/System'}</span></td>
                                <td><span class="badge bg-info bg-opacity-10 text-info border border-info">${log.action}</span></td>
                                <td>${log.note || ''}</td>
                            </tr>
                        `;
                    });
                }
                document.getElementById('logs_tbody').innerHTML = html;
            });

        new bootstrap.Modal(document.getElementById('mainDetailModal')).show();
    }

    function openNoteModal(type, value) {
        const form = document.getElementById('actionForm');
        document.getElementById('note_contact_id').value = currentContactId;
        
        if(type === 'department') {
            document.getElementById('note_action_desc').innerText = 'Phòng ban sang ' + value;
            document.getElementById('note_department_val').value = value;
            form.action = '?action=admin-contact-department';
        } else if (type === 'status') {
            document.getElementById('note_action_desc').innerText = 'Trạng thái sang ' + value;
            document.getElementById('note_status_val').value = value;
            form.action = '?action=admin-contact-status';
        }
        
        bootstrap.Modal.getInstance(document.getElementById('mainDetailModal')).hide();
        new bootstrap.Modal(document.getElementById('noteModal')).show();
    }
</script>