<?php
$id = isset($user['user_id']) ? $user['user_id'] : 0;
?>
<div class="row g-4 justify-content-center">
    <div class="col-lg-8">
        <div class="admin-form-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">
                    <?= $id ? 'Cập nhật người dùng' : 'Thêm người dùng mới' ?>
                </h5>
            </div>
            
            <?php if (!empty($_SESSION['error'])) : ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            <?php if (!empty($_SESSION['success'])) : ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL . '?action=' . ($id ? 'admin-user-update&id=' . $id : 'admin-user-store') ?>">
                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Họ và tên <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="full_name" required value="<?= htmlspecialchars($user['full_name'] ?? '') ?>">
                    </div>
                </div>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Email <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="email" class="form-control" name="email" required value="<?= htmlspecialchars($user['email'] ?? '') ?>">
                    </div>
                </div>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Số điện thoại <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="phone" required value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                    </div>
                </div>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Địa chỉ</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
                    </div>
                </div>

                <?php if (!$id) : ?>
                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Mật khẩu <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu" required>
                    </div>
                </div>
                <?php endif; ?>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Vai trò</label>
                    </div>
                    <div class="col-md-9">
                        <select name="role" class="form-select">
                            <option value="0" <?= (($user['role'] ?? 0) != 1 && ($user['role'] ?? 0) != 2) ? 'selected' : '' ?>>Khách hàng</option>
                            <option value="1" <?= (($user['role'] ?? 0) == 1) ? 'selected' : '' ?>>Admin</option>
                            <option value="2" <?= (($user['role'] ?? 0) == 2) ? 'selected' : '' ?>>Nhân viên</option>
                        </select>
                    </div>
                </div>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label">Trạng thái</label>
                    </div>
                    <div class="col-md-9">
                        <select name="status" class="form-select">
                            <option value="1" <?= (($user['status'] ?? 1) == 1) ? 'selected' : '' ?>>Hoạt động</option>
                            <option value="0" <?= (($user['status'] ?? 1) == 0) ? 'selected' : '' ?>>Khóa</option>
                        </select>
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-actions mt-5">
                    <?php if ($id): ?>
                        <a href="<?= BASE_URL ?>?action=admin-user-status&id=<?= $id ?>&status=<?= $user['status'] == 1 ? 0 : 1 ?>"
                           class="btn btn-<?= $user['status'] == 1 ? 'warning' : 'success' ?> me-2 d-inline-flex align-items-center text-white"
                           style="border-radius: 8px; padding: 10px 24px; font-weight: 500;"
                           onclick="return confirm('Bạn có chắc chắn muốn <?= $user['status'] == 1 ? 'khóa' : 'mở khóa' ?> tài khoản này?');">
                            <i class="bi bi-<?= $user['status'] == 1 ? 'lock-fill' : 'unlock-fill' ?> me-1"></i>
                            <?= $user['status'] == 1 ? 'Khóa tài khoản' : 'Mở khóa tài khoản' ?>
                        </a>
                        
                        <button type="button" class="btn-form-delete me-auto"
                            onclick="if(confirm('Bạn có chắc chắn muốn xóa người dùng này?')) { document.getElementById('deleteForm').submit(); }">
                            <i class="bi bi-trash me-1"></i> Xóa
                        </button>
                    <?php endif; ?>

                    <a href="<?= BASE_URL ?>?action=admin-users" class="btn-form-close text-decoration-none d-inline-flex align-items-center">
                        <i class="bi bi-x-lg me-1"></i> Đóng
                    </a>

                    <button type="submit" class="btn-form-save d-inline-flex align-items-center">
                        <i class="bi bi-save me-1"></i> Lưu
                    </button>
                </div>
            </form>

            <?php if ($id): ?>
            <form id="deleteForm" method="GET" action="<?= BASE_URL ?>">
                <input type="hidden" name="action" value="admin-user-delete">
                <input type="hidden" name="id" value="<?= $id ?>">
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    form.addEventListener("submit", function (e) {
        let fullName = document.querySelector("[name='full_name']").value.trim();
        let email = document.querySelector("[name='email']").value.trim();
        let phone = document.querySelector("[name='phone']").value.trim();
        if (fullName === "") {
            alert("Họ tên không được để trống");
            e.preventDefault();
            return;
        }

        if (fullName.length > 100) {
            alert("Họ tên không được vượt quá 100 ký tự");
            e.preventDefault();
            return;
        }

        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert("Email không đúng định dạng");
            e.preventDefault();
            return;
        }

        let phoneRegex = /^0\d{9}$/;
        if (!phoneRegex.test(phone)) {
            alert("Số điện thoại phải bắt đầu bằng số 0 và gồm đúng 10 chữ số");
            e.preventDefault();
            return;
        }
    });
});
</script>