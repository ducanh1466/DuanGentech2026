<div class="admin-table-card">
    <div class="card-header-custom">
        <h6><i class="bi bi-boxes me-2"></i>Quản lý kho</h6>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <form method="GET" class="d-flex gap-3 m-0 p-2 align-items-center flex-grow-1"
                style="background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                <input type="hidden" name="action" value="admin-inventory">
                <input type="hidden" name="limit" value="<?= $limit ?? 10 ?>">

                <!-- Filter by Category -->
                <div class="input-group input-group-sm"
                    style="flex: 1; min-width: 160px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden;">
                    <span class="input-group-text bg-white border-end-0 border-light text-muted"><i
                            class="bi bi-folder2-open"></i></span>
                    <select name="category_id" class="form-select border-start-0 border-light shadow-none fw-medium"
                        onchange="this.form.submit()" style="color: #475569; cursor: pointer;">
                        <option value="">Tất cả danh mục</option>
                        <?php if (!empty($categories)):
                            foreach ($categories as $cat): ?>
                                <option value="<?= $cat['category_id'] ?>" <?= (($category_id ?? '') == $cat['category_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['category_name']) ?>
                                </option>
                            <?php endforeach; endif; ?>
                    </select>
                </div>

                <!-- Filter by Stock Status -->
                <div class="input-group input-group-sm"
                    style="flex: 1; min-width: 160px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden;">
                    <span class="input-group-text bg-white border-end-0 border-light text-muted"><i
                            class="bi bi-funnel"></i></span>
                    <select name="stock_filter" class="form-select border-start-0 border-light shadow-none fw-medium"
                        onchange="this.form.submit()" style="color: #475569; cursor: pointer;">
                        <option value="">Tất cả trạng thái</option>
                        <option value="in" <?= (isset($_GET['stock_filter']) && $_GET['stock_filter'] == 'in') ? 'selected' : '' ?>>Còn hàng </option>
                        <option value="low" <?= (isset($_GET['stock_filter']) && $_GET['stock_filter'] == 'low') ? 'selected' : '' ?>>Sắp hết </option>
                        <option value="out" <?= (isset($_GET['stock_filter']) && $_GET['stock_filter'] == 'out') ? 'selected' : '' ?>>Hết hàng </option>
                    </select>
                </div>

                <!-- Search Input -->
                <div class="input-group input-group-sm"
                    style="flex: 2; min-width: 200px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden;">
                    <span class="input-group-text bg-white border-end-0 border-light text-muted"><i
                            class="bi bi-search"></i></span>
                    <input type="text" name="keyword"
                        class="form-control border-start-0 border-light shadow-none fw-medium"
                        value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>" placeholder="Tìm tên SP, SKU..."
                        style="color: #475569;">
                </div>
                <button type="submit" class="btn btn-sm btn-primary shadow-sm text-nowrap px-3"
                    style="border-radius: 8px;"><i class="bi bi-search me-1"></i>Tìm kiếm</button>

                <a href="<?= BASE_URL ?>?action=admin-inventory"
                    class="btn btn-white btn-sm border border-light text-muted shadow-sm"
                    style="border-radius: 8px; height: 31px; display: flex; align-items: center; justify-content: center;"
                    title="Làm mới">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </form>
        </div>
    </div>

    <!-- Hiển thị thông báo -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success m-3">
            <?= $_SESSION['success'];
            unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger m-3">
            <?= $_SESSION['error'];
            unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="8%">Ảnh</th>
                    <th width="25%">Sản phẩm</th>
                    <th width="20%">Phân loại</th>
                    <th width="15%">Mã SKU</th>
                    <th width="15%" class="text-center">Tồn kho hiện tại</th>
                    <th width="12%" class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($inventory)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Không tìm thấy sản phẩm nào trong kho.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($inventory as $item): ?>
                        <tr>
                            <td class="fw-semibold">#<?= $item['variant_id'] ?></td>
                            <td>
                                <?php 
                                    $imgUrl = !empty($item['image']) ? $item['image'] : 'https://placehold.co/45x45/e2e8f0/64748b?text=IMG';
                                ?>
                                <img src="<?= htmlspecialchars($imgUrl) ?>"
                                    class="img-thumbnail border-0"
                                    style="width: 45px; height: 45px; object-fit: cover; border-radius: 6px;" alt="">
                            </td>
                            <td>
                                <div class="fw-semibold text-dark" style="font-size: 0.95rem;">
                                    <?= htmlspecialchars($item['product_name']) ?>
                                </div>
                                <div class="text-muted" style="font-size: 0.85rem;">PID: <?= $item['product_id'] ?></div>
                            </td>
                            <td class="text-secondary">
                                <?= htmlspecialchars($item['attributes'] ?: 'Mặc định') ?>
                            </td>
                            <td>
                                <span
                                    class="badge bg-light text-dark border"><?= htmlspecialchars($item['sku'] ?: 'N/A') ?></span>
                            </td>
                            <td class="text-center">
                                <?php if ($item['stock'] == 0): ?>
                                    <span class="badge bg-danger stock-display" data-variant-id="<?= $item['variant_id'] ?>">Hết
                                        hàng (0)</span>
                                <?php elseif ($item['stock'] <= 10): ?>
                                    <span class="badge bg-warning text-dark stock-display"
                                        data-variant-id="<?= $item['variant_id'] ?>">Sắp hết (<?= $item['stock'] ?>)</span>
                                <?php else: ?>
                                    <span class="badge bg-success stock-display" data-variant-id="<?= $item['variant_id'] ?>">Còn
                                        hàng (<?= $item['stock'] ?>)</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <button class="btn-action-detail text-decoration-none btn-edit-stock"
                                        data-variant-id="<?= $item['variant_id'] ?>" data-stock="<?= $item['stock'] ?>"
                                        data-name="<?= htmlspecialchars($item['product_name']) ?>"
                                        data-attrs="<?= htmlspecialchars($item['attributes'] ?: 'Mặc định') ?>"
                                        title="Chi tiết & Nhập kho">
                                        <i class="bi bi-info-circle"></i> Chi tiết
                                    </button>
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
        <div class="d-flex align-items-center gap-2">
            <select class="form-select form-select-sm" style="width: auto; border-radius: 4px;"
                onchange="window.location.href='?action=admin-inventory&keyword=<?= urlencode($keyword ?? '') ?>&stock_filter=<?= urlencode($_GET['stock_filter'] ?? '') ?>&category_id=<?= urlencode($category_id ?? '') ?>&limit='+this.value">
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
                            <a class="page-link"
                                href="?action=admin-inventory&keyword=<?= urlencode($keyword ?? '') ?>&stock_filter=<?= urlencode($_GET['stock_filter'] ?? '') ?>&category_id=<?= urlencode($category_id ?? '') ?>&limit=<?= $limit ?? 10 ?>&page=<?= ($page ?? 1) - 1 ?>">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        <?php
                        $start = max(1, ($page ?? 1) - 2);
                        $end = min($totalPages, ($page ?? 1) + 2);

                        if ($start > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?action=admin-inventory&keyword=' . urlencode($keyword ?? '') . '&stock_filter=' . urlencode($_GET['stock_filter'] ?? '') . '&category_id=' . urlencode($category_id ?? '') . '&limit=' . ($limit ?? 10) . '&page=1">1</a></li>';
                            if ($start > 2) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                        }

                        for ($i = $start; $i <= $end; $i++): ?>
                            <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                <a class="page-link"
                                    href="?action=admin-inventory&keyword=<?= urlencode($keyword ?? '') ?>&stock_filter=<?= urlencode($_GET['stock_filter'] ?? '') ?>&category_id=<?= urlencode($category_id ?? '') ?>&limit=<?= $limit ?? 10 ?>&page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor;

                        if ($end < $totalPages) {
                            if ($end < $totalPages - 1) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                            echo '<li class="page-item"><a class="page-link" href="?action=admin-inventory&keyword=' . urlencode($keyword ?? '') . '&stock_filter=' . urlencode($_GET['stock_filter'] ?? '') . '&category_id=' . urlencode($category_id ?? '') . '&limit=' . ($limit ?? 10) . '&page=' . $totalPages . '">' . $totalPages . '</a></li>';
                        }
                        ?>

                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link"
                                href="?action=admin-inventory&keyword=<?= urlencode($keyword ?? '') ?>&stock_filter=<?= urlencode($_GET['stock_filter'] ?? '') ?>&category_id=<?= urlencode($category_id ?? '') ?>&limit=<?= $limit ?? 10 ?>&page=<?= ($page ?? 1) + 1 ?>">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Nhập Kho -->
<div class="modal fade" id="stockModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title" id="stockModalLabel">Chi tiết & Nhập kho</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="fw-bold" id="modalProductName">Tên sản phẩm</div>
                    <div class="text-muted" style="font-size:0.85rem;" id="modalProductAttrs">Thuộc tính</div>
                </div>

                <form id="stockForm">
                    <input type="hidden" id="modalVariantId">
                    <div class="mb-3">
                        <label class="form-label text-muted">Số lượng tồn kho hiện tại</label>
                        <div class="h4 fw-bold text-primary" id="modalCurrentStock">0</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số lượng nhập thêm</label>
                        <input type="number" class="form-control" id="modalAddStock" min="1" value="1" required>
                        <div class="form-text">Nhập số lượng bạn vừa nhập thêm vào kho. Tổng số lượng sẽ được cộng dồn.
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="btnSaveStockModal">Cộng vào kho</button>
            </div>
        </div>
    </div>
</div>

<!-- Toast Thông báo AJAX -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1060">
    <div id="liveToast" class="toast align-items-center text-white bg-success border-0" role="alert"
        aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">
                Cập nhật thành công!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stockModal = new bootstrap.Modal(document.getElementById('stockModal'));

        const toastElList = [].slice.call(document.querySelectorAll('.toast'));
        const toastList = toastElList.map(function (toastEl) {
            return new bootstrap.Toast(toastEl, { delay: 3000 });
        });

        // Mở Modal
        document.querySelectorAll('.btn-edit-stock').forEach(btn => {
            btn.addEventListener('click', function () {
                const variantId = this.getAttribute('data-variant-id');
                const stock = this.getAttribute('data-stock');
                const name = this.getAttribute('data-name');
                const attrs = this.getAttribute('data-attrs');

                document.getElementById('modalVariantId').value = variantId;
                document.getElementById('modalCurrentStock').textContent = stock;
                document.getElementById('modalCurrentStock').setAttribute('data-current', stock); // Store current
                document.getElementById('modalAddStock').value = 1; // Default to adding 1
                document.getElementById('modalProductName').textContent = name;
                document.getElementById('modalProductAttrs').textContent = attrs;

                stockModal.show();
            });
        });

        // Lưu kho
        document.getElementById('btnSaveStockModal').addEventListener('click', function () {
            const variantId = document.getElementById('modalVariantId').value;
            const currentStock = parseInt(document.getElementById('modalCurrentStock').getAttribute('data-current'));
            const addStock = parseInt(document.getElementById('modalAddStock').value);

            if (isNaN(addStock) || addStock < 1) {
                alert('Vui lòng nhập số lượng nhập thêm hợp lệ (>= 1)');
                return;
            }

            const newStock = currentStock + addStock;

            const btnSave = this;
            const originalHTML = btnSave.innerHTML;
            btnSave.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang cộng...';
            btnSave.disabled = true;

            const formData = new FormData();
            formData.append('variant_id', variantId);
            formData.append('stock', newStock); // Backend will update absolute stock to current + add

            fetch('<?= BASE_URL ?>?action=admin-update-stock-quick', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI without reload
                        stockModal.hide();

                        const toastMsg = document.getElementById('toastMessage');
                        toastMsg.textContent = 'Đã cộng thêm ' + addStock + ' vào kho. Tồn kho mới: ' + newStock;

                        const toastDiv = document.getElementById('liveToast');
                        toastDiv.className = 'toast align-items-center text-white bg-success border-0';
                        toastList[0].show();

                        // Update Badge in table
                        const badgeEl = document.querySelector('.stock-display[data-variant-id="' + variantId + '"]');
                        if (badgeEl) {
                            badgeEl.className = 'badge stock-display'; // reset class
                            if (newStock == 0) {
                                badgeEl.classList.add('bg-danger');
                                badgeEl.textContent = 'Hết hàng (0)';
                            } else if (newStock <= 10) {
                                badgeEl.classList.add('bg-warning', 'text-dark');
                                badgeEl.textContent = 'Sắp hết (' + newStock + ')';
                            } else {
                                badgeEl.classList.add('bg-success');
                                badgeEl.textContent = 'Còn hàng (' + newStock + ')';
                            }
                        }

                        // Update data-stock on button
                        const btnEl = document.querySelector('.btn-edit-stock[data-variant-id="' + variantId + '"]');
                        if (btnEl) {
                            btnEl.setAttribute('data-stock', newStock);
                        }

                    } else {
                        alert('Lỗi: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Đã xảy ra lỗi khi kết nối!');
                })
                .finally(() => {
                    btnSave.innerHTML = originalHTML;
                    btnSave.disabled = false;
                });
        });
    });
</script>