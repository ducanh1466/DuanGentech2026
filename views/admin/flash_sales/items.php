<div class="row g-4">
    <div class="col-lg-4">
        <div class="admin-form-card mb-4">
            <div class="card-header-custom">
                <h6 class="mb-0">
                    <a href="?action=admin-flash-sales" class="text-muted me-2"><i class="bi bi-arrow-left"></i></a>
                    Thông tin chiến dịch
                </h6>
            </div>
            <div class="card-body p-4">
                <p class="mb-1 text-muted small">Tên chiến dịch:</p>
                <h6 class="mb-3 text-dark fw-bold"><?= htmlspecialchars($flashSale['title']) ?></h6>
                
                <p class="mb-1 text-muted small">Thời gian diễn ra:</p>
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-light text-dark border"><?= date('d/m/Y H:i', strtotime($flashSale['start_time'])) ?></span>
                    <i class="bi bi-arrow-right text-muted"></i>
                    <span class="badge bg-light text-dark border"><?= date('d/m/Y H:i', strtotime($flashSale['end_time'])) ?></span>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="card-header-custom">
                <h6 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Thêm sản phẩm</h6>
            </div>
            <div class="card-body p-4">
                <form action="?action=admin-flash-sale-item-save" method="POST">
                    <input type="hidden" name="flash_sale_id" value="<?= $flashSale['id'] ?>">
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small">Sản phẩm <span class="text-danger">*</span></label>
                        <select name="product_id" class="form-select select2" required>
                            <option value="">-- Chọn sản phẩm --</option>
                            <?php foreach ($products as $p): ?>
                                <option value="<?= $p['product_id'] ?>"><?= htmlspecialchars($p['product_name']) ?> (Gốc: <?= number_format($p['price'], 0, ',', '.') ?>đ)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small">Giá Flash Sale (VNĐ) <span class="text-danger">*</span></label>
                        <input type="text" id="flash_price_display" class="form-control" required placeholder="Nhập giá khuyến mãi...">
                        <input type="hidden" name="flash_price" id="flash_price_raw">
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted small">Số lượng giới hạn</label>
                        <input type="number" name="quantity" class="form-control" min="1" placeholder="Để trống nếu không giới hạn">
                        <small class="text-muted d-block mt-1">Số lượng tối đa có thể mua ở mức giá này.</small>
                    </div>

                    <button type="submit" class="btn btn-accent w-100">
                        <i class="bi bi-plus-lg me-1"></i> Thêm vào sự kiện
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="admin-table-card">
            <div class="card-header-custom">
                <h6><i class="bi bi-list-ul me-2"></i>Sản phẩm trong chiến dịch</h6>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá Flash / Giá gốc</th>
                            <th>Đã bán / Tối đa</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($items)): ?>
                            <tr><td colspan="4" class="text-center text-muted">Chưa có sản phẩm nào trong chiến dịch này.</td></tr>
                        <?php else: ?>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded border" style="width: 45px; height: 45px; overflow: hidden;">
                                                <?php 
                                                    $img = $item['image'] ?? '';
                                                    $imgUrl = !empty($img) ? (str_starts_with($img, 'http') ? $img : BASE_ASSETS_UPLOADS . 'products/' . basename($img)) : 'assets/images/placeholder.png';
                                                ?>
                                                <img src="<?= htmlspecialchars($imgUrl) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                            <div class="fw-bold text-dark text-truncate" style="max-width: 250px;">
                                                <?= htmlspecialchars($item['product_name']) ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-danger fw-bold"><?= number_format($item['flash_price'], 0, ',', '.') ?>đ</div>
                                        <small class="text-muted text-decoration-line-through"><?= number_format($item['price'], 0, ',', '.') ?>đ</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="text-dark fw-medium"><?= $item['sold'] ?></span>
                                            <span class="text-muted">/</span>
                                            <span class="text-muted"><?= $item['quantity'] ?: '&infin;' ?></span>
                                        </div>
                                        <?php if ($item['quantity']): ?>
                                            <div class="progress mt-1" style="height: 4px;">
                                                <div class="progress-bar bg-accent" style="width: <?= min(100, ($item['sold'] / $item['quantity']) * 100) ?>%"></div>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form method="POST" action="?action=admin-flash-sale-item-delete" class="d-inline" onsubmit="return confirm('Loại bỏ sản phẩm này khỏi Flash Sale?');">
                                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                            <input type="hidden" name="flash_sale_id" value="<?= $item['flash_sale_id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const priceDisplay = document.getElementById('flash_price_display');
    const priceRaw = document.getElementById('flash_price_raw');

    if (priceDisplay && priceRaw) {
        priceDisplay.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            priceRaw.value = value;
            if (value) {
                this.value = parseInt(value, 10).toLocaleString('vi-VN');
            } else {
                this.value = '';
            }
        });
    }
});
</script>
