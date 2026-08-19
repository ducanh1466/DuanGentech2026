<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['success'];
        unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<div class="admin-table-card">
    <div class="card-header-custom">
        <h6><i class="bi bi-receipt me-2"></i>Quản lý đơn hàng</h6>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <form action="" method="GET" class="d-flex gap-2 m-0 p-0 align-items-center">
                <input type="hidden" name="action" value="admin-orders">
                <input type="hidden" name="limit" value="<?= $limit ?? 10 ?>">
                <input type="hidden" name="status" id="statusFilter" value="<?= htmlspecialchars($status ?? '') ?>">
                <div class="dropdown">
                    <button class="btn admin-filter-select" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="min-width: 160px; text-align: left;">
                        <?php 
                            if (($status ?? '') === 'pending') echo 'Chờ xử lý';
                            elseif (($status ?? '') === 'processing') echo 'Chờ lấy hàng';
                            elseif (($status ?? '') === 'confirmed') echo 'Đã xác nhận';
                            elseif (($status ?? '') === 'shipping') echo 'Đang giao';
                            elseif (($status ?? '') === 'completed') echo 'Hoàn thành';
                            elseif (($status ?? '') === 'return_requested') echo 'Yêu cầu trả hàng';
                            elseif (($status ?? '') === 'return_processing') echo 'Đang xử lý trả hàng';
                            elseif (($status ?? '') === 'returned') echo 'Đã hoàn trả';
                            elseif (($status ?? '') === 'return_rejected') echo 'Từ chối trả hàng';
                            elseif (($status ?? '') === 'cancelled') echo 'Đã hủy';
                            else echo 'Tất cả trạng thái';
                        ?>
                    </button>
                    <ul class="dropdown-menu shadow border-0" style="border-radius: 16px; min-width: 160px; padding: 8px; margin-top: 6px;">
                        <li><a class="dropdown-item py-2 rounded mb-1 <?= ($status ?? '') === '' ? 'active text-white' : '' ?>" style="<?= ($status ?? '') === '' ? 'background-color: var(--accent);' : '' ?>" href="#" onclick="document.getElementById('statusFilter').value=''; this.closest('form').submit(); return false;">Tất cả trạng thái</a></li>
                        <li><a class="dropdown-item py-2 rounded mb-1 <?= ($status ?? '') === 'pending' ? 'active text-white' : '' ?>" style="<?= ($status ?? '') === 'pending' ? 'background-color: var(--accent);' : '' ?>" href="#" onclick="document.getElementById('statusFilter').value='pending'; this.closest('form').submit(); return false;">Chờ xử lý</a></li>
                        <li><a class="dropdown-item py-2 rounded mb-1 <?= ($status ?? '') === 'processing' ? 'active text-white' : '' ?>" style="<?= ($status ?? '') === 'processing' ? 'background-color: var(--accent);' : '' ?>" href="#" onclick="document.getElementById('statusFilter').value='processing'; this.closest('form').submit(); return false;">Chờ lấy hàng</a></li>
                        <li><a class="dropdown-item py-2 rounded mb-1 <?= ($status ?? '') === 'confirmed' ? 'active text-white' : '' ?>" style="<?= ($status ?? '') === 'confirmed' ? 'background-color: var(--accent);' : '' ?>" href="#" onclick="document.getElementById('statusFilter').value='confirmed'; this.closest('form').submit(); return false;">Đã xác nhận</a></li>
                        <li><a class="dropdown-item py-2 rounded mb-1 <?= ($status ?? '') === 'shipping' ? 'active text-white' : '' ?>" style="<?= ($status ?? '') === 'shipping' ? 'background-color: var(--accent);' : '' ?>" href="#" onclick="document.getElementById('statusFilter').value='shipping'; this.closest('form').submit(); return false;">Đang giao</a></li>
                        <li><a class="dropdown-item py-2 rounded mb-1 <?= ($status ?? '') === 'completed' ? 'active text-white' : '' ?>" style="<?= ($status ?? '') === 'completed' ? 'background-color: var(--accent);' : '' ?>" href="#" onclick="document.getElementById('statusFilter').value='completed'; this.closest('form').submit(); return false;">Hoàn thành</a></li>
                        <li><a class="dropdown-item py-2 rounded mb-1 <?= ($status ?? '') === 'return_requested' ? 'active text-white' : '' ?>" style="<?= ($status ?? '') === 'return_requested' ? 'background-color: var(--accent);' : '' ?>" href="#" onclick="document.getElementById('statusFilter').value='return_requested'; this.closest('form').submit(); return false;">Yêu cầu trả hàng</a></li>
                        <li><a class="dropdown-item py-2 rounded mb-1 <?= ($status ?? '') === 'return_processing' ? 'active text-white' : '' ?>" style="<?= ($status ?? '') === 'return_processing' ? 'background-color: var(--accent);' : '' ?>" href="#" onclick="document.getElementById('statusFilter').value='return_processing'; this.closest('form').submit(); return false;">Đang xử lý trả hàng</a></li>
                        <li><a class="dropdown-item py-2 rounded mb-1 <?= ($status ?? '') === 'returned' ? 'active text-white' : '' ?>" style="<?= ($status ?? '') === 'returned' ? 'background-color: var(--accent);' : '' ?>" href="#" onclick="document.getElementById('statusFilter').value='returned'; this.closest('form').submit(); return false;">Đã hoàn trả</a></li>
                        <li><a class="dropdown-item py-2 rounded mb-1 <?= ($status ?? '') === 'return_rejected' ? 'active text-white' : '' ?>" style="<?= ($status ?? '') === 'return_rejected' ? 'background-color: var(--accent);' : '' ?>" href="#" onclick="document.getElementById('statusFilter').value='return_rejected'; this.closest('form').submit(); return false;">Từ chối trả hàng</a></li>
                        <li><a class="dropdown-item py-2 rounded <?= ($status ?? '') === 'cancelled' ? 'active text-white' : '' ?>" style="<?= ($status ?? '') === 'cancelled' ? 'background-color: var(--accent);' : '' ?>" href="#" onclick="document.getElementById('statusFilter').value='cancelled'; this.closest('form').submit(); return false;">Đã hủy</a></li>
                    </ul>
                </div>
                <div class="position-relative">
                    <i class="bi bi-search position-absolute" style="left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);"></i>
                    <input type="text" class="admin-search-input" name="keyword" value="<?= htmlspecialchars($keyword ?? '') ?>" placeholder="Tìm mã đơn, tên, sđt...">
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Khách hàng</th>
                    <th>Sản phẩm</th>
                    <th>Tổng tiền</th>
                    <th>Thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="7" class="text-center">Chưa có đơn hàng nào.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td class="fw-bold">#
                                <?= $order['order_id'] ?>
                            </td>
                            <td>
                                <div class="fw-semibold">
                                    <?= htmlspecialchars($order['recipient_name']) ?>
                                </div>
                                <small class="text-muted">
                                    <?= htmlspecialchars($order['recipient_phone']) ?>
                                </small>
                            </td>
                            <td>...</td> <!-- Items count needs detail fetch -->
                            <td class="fw-bold">
                                <?= number_format($order['total_amount'], 0, ',', '.') ?>₫
                            </td>
                            <td>
                                <?php 
                                    $pm = $order['payment_method'] ?? 'cod';
                                    if ($pm === 'bank'): 
                                ?>
                                    <span class="badge bg-info text-dark"><i class="bi bi-bank"></i> Chuyển khoản</span>
                                <?php elseif ($pm === 'vnpay'): ?>
                                    <span class="badge bg-primary"><i class="bi bi-credit-card"></i> VNPay</span>
                                <?php elseif ($pm === 'momo'): ?>
                                    <span class="badge" style="background-color: #A50064; color: white;"><i class="bi bi-wallet2"></i> MoMo</span>
                                <?php elseif ($pm === 'zalopay'): ?>
                                    <span class="badge" style="background-color: #0068FF; color: white;"><i class="bi bi-wallet2"></i> ZaloPay</span>
                                <?php elseif ($pm === 'applepay'): ?>
                                    <span class="badge bg-dark text-white"><i class="bi bi-apple"></i> Apple Pay</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><i class="bi bi-cash"></i> COD</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                $statusMap = [
                                    'pending' => 'Chờ xử lý',
                                    'processing' => 'Chờ lấy hàng',
                                    'confirmed' => 'Đã xác nhận',
                                    'shipping' => 'Đang giao',
                                    'completed' => 'Hoàn thành',
                                    'cancelled' => 'Đã hủy',
                                    'return_requested' => 'Yêu cầu trả hàng',
                                    'return_processing' => 'Đang xử lý hoàn trả',
                                    'returned' => 'Đã hoàn trả',
                                    'return_rejected' => 'Từ chối trả hàng'
                                ];
                                $stText = $statusMap[$order['status']] ?? 'Không rõ';
                                ?>
                                <span class="status-badge <?= htmlspecialchars($order['status']) ?>">
                                    <?= $stText ?>
                                </span>
                            </td>
                            <td class="text-secondary">
                                <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2 action-dropdown position-relative">
                                    <a href="<?= BASE_URL ?>?action=admin-order-detail&id=<?= $order['order_id'] ?>" class="btn-action-detail text-decoration-none">
                                        <i class="bi bi-info-circle"></i> Chi tiết
                                    </a>
                                    <div class="dropdown dropend">
                                        <button class="btn-action-more dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-custom">
                                            <li>
                                                <button class="dropdown-item" onclick="editOrderStatus(<?= $order['order_id'] ?>, '<?= $order['status'] ?>')" data-bs-toggle="modal" data-bs-target="#orderModal">Cập nhật trạng thái</button>
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
            <select class="form-select form-select-sm" style="width: auto; border-radius: 4px;" onchange="window.location.href='?action=admin-orders&keyword=<?= urlencode($keyword ?? '') ?>&status=<?= urlencode($status ?? '') ?>&limit='+this.value">
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
                            <a class="page-link" href="?action=admin-orders&keyword=<?= urlencode($keyword ?? '') ?>&status=<?= urlencode($status ?? '') ?>&limit=<?= $limit ?? 10 ?>&page=<?= ($page ?? 1) - 1 ?>">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        
                        <?php 
                        $start = max(1, ($page ?? 1) - 2);
                        $end = min($totalPages, ($page ?? 1) + 2);
                        
                        if ($start > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?action=admin-orders&keyword='.urlencode($keyword ?? '').'&status='.urlencode($status ?? '').'&limit='.($limit ?? 10).'&page=1">1</a></li>';
                            if ($start > 2) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                        }
                        
                        for ($i = $start; $i <= $end; $i++) {
                            $active = ($i == ($page ?? 1)) ? 'active' : '';
                            echo '<li class="page-item ' . $active . '"><a class="page-link" href="?action=admin-orders&keyword='.urlencode($keyword ?? '').'&status='.urlencode($status ?? '').'&limit='.($limit ?? 10).'&page='.$i.'">' . $i . '</a></li>';
                        }
                        
                        if ($end < $totalPages) {
                            if ($end < $totalPages - 1) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                            echo '<li class="page-item"><a class="page-link" href="?action=admin-orders&keyword='.urlencode($keyword ?? '').'&status='.urlencode($status ?? '').'&limit='.($limit ?? 10).'&page='.$totalPages.'">'.$totalPages.'</a></li>';
                        }
                        ?>
                        
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?action=admin-orders&keyword=<?= urlencode($keyword ?? '') ?>&status=<?= urlencode($status ?? '') ?>&limit=<?= $limit ?? 10 ?>&page=<?= ($page ?? 1) + 1 ?>">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Order Status Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cập nhật trạng thái đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="order_id" id="modalOrderId" value="">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Trạng thái mới</label>
                        <select class="form-select" name="status" id="modalOrderStatus" onchange="toggleCancelReason()"
                            style="border:2px solid var(--border-color);border-radius:var(--radius-md);padding:10px 14px;background:var(--bg-primary);color:var(--text-primary);">
                            <option value="pending">Chờ xử lý</option>
                            <option value="confirmed">Đã xác nhận</option>
                            <option value="processing">Chờ lấy hàng</option>
                            <option value="shipping">Đang giao</option>
                            <option value="completed">Hoàn thành</option>
                            <option value="cancelled">Đã hủy</option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="cancelReasonDiv" style="display: none;">
                        <label class="form-label fw-semibold text-danger">Lý do hủy đơn *</label>
                        <textarea class="form-control" name="cancel_reason" id="cancelReason" rows="3" placeholder="Nhập lý do hủy đơn hàng..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-pill"
                        data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-accent" id="btnSaveStatus">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editOrderStatus(id, currentStatus) {
        document.getElementById('modalOrderId').value = id;
        
        let select = document.getElementById('modalOrderStatus');
        let options = select.options;
        
        // Define allowed transitions
        let allowed = [];
        if (currentStatus === 'pending') allowed = ['pending', 'confirmed', 'cancelled'];
        else if (currentStatus === 'confirmed') allowed = ['confirmed', 'processing', 'cancelled'];
        else if (currentStatus === 'processing') allowed = ['processing', 'shipping', 'cancelled'];
        else if (currentStatus === 'shipping') allowed = ['shipping', 'completed', 'cancelled'];
        else allowed = [currentStatus]; // completed or cancelled -> locked
        
        // Hide/disable options not in allowed list
        let firstAllowed = null;
        for (let i = 0; i < options.length; i++) {
            if (allowed.includes(options[i].value)) {
                options[i].disabled = false;
                options[i].style.display = 'block';
                if (!firstAllowed) firstAllowed = options[i].value;
            } else {
                options[i].disabled = true;
                options[i].style.display = 'none';
            }
        }
        
        // Set the value to current if allowed, else first allowed
        if (allowed.includes(currentStatus)) {
            select.value = currentStatus;
        } else if (firstAllowed) {
            select.value = firstAllowed;
        }
        
        toggleCancelReason();
        
        // Disable save button if final state
        if (currentStatus === 'completed' || currentStatus === 'cancelled') {
            document.getElementById('btnSaveStatus').disabled = true;
        } else {
            document.getElementById('btnSaveStatus').disabled = false;
        }
    }
    
    function toggleCancelReason() {
        let status = document.getElementById('modalOrderStatus').value;
        let reasonDiv = document.getElementById('cancelReasonDiv');
        let reasonInput = document.getElementById('cancelReason');
        
        if (status === 'cancelled') {
            reasonDiv.style.display = 'block';
            reasonInput.required = true;
        } else {
            reasonDiv.style.display = 'none';
            reasonInput.required = false;
        }
    }
</script>