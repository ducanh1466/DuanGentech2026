<section class="container my-5">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Thông tin tài khoản</h4>
                    <a href="<?= BASE_URL ?>?action=change-password" class="btn btn-sm btn-outline-secondary">Đổi mật khẩu</a>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" action="<?= BASE_URL ?>?action=update-profile">
                        <div class="mb-3">
                            <label class="form-label">Email (Tài khoản)</label>
                            <input type="email" class="form-control text-muted" value="<?= htmlspecialchars($_SESSION['user']['email']) ?>" disabled>
                            <small class="form-text text-muted">Không thể thay đổi email đăng nhập.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="full_name" value="<?= htmlspecialchars($_SESSION['user']['full_name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($_SESSION['user']['phone']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ</label>
                            <textarea class="form-control" name="address" rows="3" placeholder="Nhập địa chỉ giao hàng..."><?= htmlspecialchars($_SESSION['user']['address']) ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-save me-1"></i> Lưu thay đổi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
