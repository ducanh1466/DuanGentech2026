<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="admin-form-card">
            <div class="card-header-custom">
                <h6 class="mb-0">
                    <a href="?action=admin-flash-sales" class="text-muted me-2"><i class="bi bi-arrow-left"></i></a>
                    <?= $flashSale ? 'Chỉnh sửa Flash Sale' : 'Thêm Flash Sale mới' ?>
                </h6>
            </div>
            
            <div class="card-body p-4">
                <form action="?action=admin-flash-sale-save" method="POST">
                    <?php if ($flashSale): ?>
                        <input type="hidden" name="id" value="<?= $flashSale['id'] ?>">
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Tên chiến dịch <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($flashSale['title'] ?? '') ?>" required placeholder="Ví dụ: Siêu Sale Giữa Tháng">
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Thời gian bắt đầu <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" name="start_time" value="<?= isset($flashSale['start_time']) ? date('Y-m-d\TH:i', strtotime($flashSale['start_time'])) : '' ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Thời gian kết thúc <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" name="end_time" value="<?= isset($flashSale['end_time']) ? date('Y-m-d\TH:i', strtotime($flashSale['end_time'])) : '' ?>" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= ($flashSale['status'] ?? 'active') == 'active' ? 'selected' : '' ?>>Kích hoạt</option>
                            <option value="inactive" <?= ($flashSale['status'] ?? '') == 'inactive' ? 'selected' : '' ?>>Tạm khóa</option>
                        </select>
                        <small class="text-muted d-block mt-1">Trạng thái "Kích hoạt" kết hợp với thời gian sẽ quyết định Flash Sale có đang chạy hay không.</small>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="?action=admin-flash-sales" class="btn btn-light">Hủy</a>
                        <button type="submit" class="btn btn-accent px-4">Lưu thông tin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
