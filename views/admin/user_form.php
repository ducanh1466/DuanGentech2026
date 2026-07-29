<div class="row g-4">
    <div class="col-lg-8 mx-auto">
        <form method="POST" action="">
            <div class="admin-form-card">
                <h6 class="fw-bold mb-4"><i class="bi bi-person me-2"></i>Sửa thông tin người dùng</h6>

                <div class="mb-3">
                    <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="full_name" value="<?= htmlspecialchars($user['full_name'] ?? '') ?>" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '') ?>" disabled>
                        <small class="text-muted">Không thể thay đổi email</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Vai trò</label>
                        <select class="form-select" name="role">
                            <option value="0" <?= $user['role'] == 0 ? 'selected' : '' ?>>Khách hàng</option>
                            <option value="2" <?= $user['role'] == 2 ? 'selected' : '' ?>>Nhân viên</option>
                            <option value="1" <?= $user['role'] == 1 ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-select" name="status">
                            <option value="1" <?= $user['status'] == 1 ? 'selected' : '' ?>>Hoạt động</option>
                            <option value="0" <?= $user['status'] == 0 ? 'selected' : '' ?>>Vô hiệu</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Đổi mật khẩu</label>
                    <input type="password" class="form-control" name="new_password" placeholder="Nhập mật khẩu mới (Để trống nếu không đổi)">
                </div>

                <hr class="my-4">
                
                <div class="d-flex justify-content-end gap-2">
                    <a href="<?= BASE_URL ?>?action=admin-users" class="btn btn-outline-secondary rounded-pill">
                        <i class="bi bi-x-lg me-1"></i> Hủy
                    </a>
                    <button type="submit" class="btn btn-accent">
                        <i class="bi bi-check-lg me-1"></i> Lưu thay đổi
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
