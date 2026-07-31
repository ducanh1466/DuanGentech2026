<div class="admin-form-card">
    <div class="card-header-custom">
        <h5>
            <i class="bi bi-person-fill me-2"></i>
            <?= isset($user) && !empty($user) ? 'Cập nhật người dùng' : 'Thêm người dùng' ?>
        </h5>
    </div>
    <div class="card-body">
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
        <form
            method="POST"
            action="<?= BASE_URL . '?action=' . (isset($user) && !empty($user)
                ? 'admin-user-update&id=' . $user['user_id']
                : 'admin-user-store') ?>">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Họ và tên</label>
                    <input
                        type="text"
                        class="form-control"
                        name="full_name"
                        required
                        value="<?= htmlspecialchars($user['full_name'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input
                        type="email"
                        class="form-control"
                        name="email"
                        required
                        value="<?= htmlspecialchars($user['email'] ?? '') ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input
                        type="text"
                        class="form-control"
                        name="phone"
                        value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Địa chỉ</label>
                    <input
                        type="text"
                        class="form-control"
                        name="address"
                        value="<?= htmlspecialchars($user['address'] ?? '') ?>">
                </div>
            </div>
            <?php if (!isset($user) || empty($user)) : ?>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input
                        type="password"
                        class="form-control"
                        name="password"
                        placeholder="Nhập mật khẩu">
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Vai trò</label>
                    <select
                        name="role"
                        class="form-select">
                        <option value="0"<?= (($user['role'] ?? 0) != 1 && ($user['role'] ?? 0) != 2) ? 'selected' : '' ?>>Khách hàng</option>

                        <option value="1"<?= (($user['role'] ?? 0) == 1) ? 'selected' : '' ?>>Admin</option>
                        <option value="2"<?= (($user['role'] ?? 0) == 2) ? 'selected' : '' ?>>Nhân viên</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select
                        name="status"
                        class="form-select">
                        <option
                            value="1"
                            <?= (($user['status'] ?? 1) == 1) ? 'selected' : '' ?>>Hoạt động</option>
                        <option
                            value="0"
                            <?= (($user['status'] ?? 1) == 0) ? 'selected' : '' ?>>Khóa</option>
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a
                    href="<?= BASE_URL ?>?action=admin-users"
                    class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Quay lại</a>
                <button
                    type="submit"
                    class="btn btn-success">
                    <i class="bi bi-check-circle me-1"></i>
                    <?= isset($user) && !empty($user) ? 'Cập nhật' : 'Thêm mới' ?>
                </button>
            </div>
        </form>
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