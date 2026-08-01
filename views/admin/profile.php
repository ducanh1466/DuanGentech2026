<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card shadow border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Thông tin tài khoản Admin</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" action="<?= BASE_URL ?>?action=admin-update-profile">
                        <div class="mb-3">
                            <label class="form-label">Email đăng nhập</label>
                            <input type="email" class="form-control text-muted" value="<?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="full_name" value="<?= htmlspecialchars($_SESSION['user']['full_name'] ?? '') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($_SESSION['user']['phone'] ?? '') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ</label>
                            <textarea class="form-control" name="address" rows="3"><?= htmlspecialchars($_SESSION['user']['address'] ?? '') ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-save me-1"></i> Lưu thông tin
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
