<div class="admin-table-card">
    <div class="card-header-custom">
        <h6><i class="bi bi-box-seam me-2"></i>Quản lý sản phẩm</h6>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <div class="position-relative">
                <i class="bi bi-search position-absolute"
                    style="left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);"></i>
                <input type="text" class="admin-search-input" id="adminTableSearch" placeholder="Tìm sản phẩm...">
            </div>
            <a href="<?= BASE_URL ?>?action=admin-product-create" class="btn btn-accent btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Thêm sản phẩm
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="7" class="text-center">Chưa có sản phẩm nào.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $i => $p): ?>
                        <tr>
                            <td class="fw-semibold"><?= $i + 1 ?></td>
                            <td>
                                <?php if (!empty($p['image'])): ?>
                                    <img src="<?= htmlspecialchars($p['image']) ?>" class="product-thumb" alt=""
                                        style="width:60px; height:60px; object-fit:cover; border-radius:var(--radius-sm);">
                                <?php else: ?>
                                    <img src="https://placehold.co/60x60/e2e8f0/64748b?text=IMG" class="product-thumb" alt="">
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-semibold"><?= htmlspecialchars($p['product_name']) ?></div>
                                <small class="text-muted">ID: #<?= $p['product_id'] ?></small>
                            </td>
                            <td><?= htmlspecialchars($p['category_name'] ?? 'N/A') ?></td>
                            <td class="fw-bold">
                                <span class="text-accent"><?= number_format($p['price'] ?? 0, 0, ',', '.') ?> VNĐ</span>
                            </td>
                        <td><span
                                    class="status-badge <?= ($p['status'] == 1 || $p['status'] === 'active') ? 'active' : 'inactive' ?>"><?= ($p['status'] == 1 || $p['status'] === 'active') ? 'Hiển thị' : 'Ẩn' ?></span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="<?= BASE_URL ?>?action=admin-product-edit&id=<?= $p['product_id'] ?>"
                                        class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                    <form method="POST" action="" style="display:inline-block;"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                        <input type="hidden" name="action_type" value="delete">
                                        <input type="hidden" name="product_id" value="<?= $p['product_id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                                class="bi bi-trash3"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center p-3 border-top"
        style="border-color:var(--border-light)!important">
        <span class="text-muted" style="font-size:0.85rem;">Hiển thị 1-6 trên 324 sản phẩm</span>
        <nav>
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a></li>
            </ul>
        </nav>
    </div>
</div>