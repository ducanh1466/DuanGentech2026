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
                        <label class="form-horizontal-label">Vai trò (Phòng ban)</label>
                    </div>
                    <div class="col-md-9">
                        <select name="role" id="roleSelect" class="form-select">
                            <option value="0" <?= (($user['role'] ?? 0) == 0) ? 'selected' : '' ?>>Khách hàng (Chỉ truy cập Client)</option>
                            <option value="1" <?= (($user['role'] ?? 0) == 1) ? 'selected' : '' ?>>CNTT (Quản trị toàn quyền)</option>
                            <option value="2" <?= (($user['role'] ?? 0) == 2) ? 'selected' : '' ?>>CSKH</option>
                            <option value="3" <?= (($user['role'] ?? 0) == 3) ? 'selected' : '' ?>>Vận hành dịch vụ</option>
                            <option value="4" <?= (($user['role'] ?? 0) == 4) ? 'selected' : '' ?>>Marketing</option>
                        </select>
                    </div>
                </div>

                <?php 
                $userPermissions = [];
                if (!empty($user['permissions'])) {
                    $userPermissions = json_decode($user['permissions'], true) ?? [];
                }
                ?>
                <div class="row form-horizontal-row" id="permissionsGroup" style="<?= (($user['role'] ?? 0) == 0) ? 'display: none;' : '' ?>">
                    <div class="col-md-3">
                        <label class="form-horizontal-label mt-2">Vai trò nghiệp vụ (Quyền hạn)</label>
                    </div>
                    <div class="col-md-9">
                        <div class="p-3 border rounded bg-light">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input perm-checkbox" type="checkbox" name="permissions[]" value="products" id="perm_products" <?= in_array('products', $userPermissions) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="perm_products">Quản lý Sản phẩm</label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input perm-checkbox" type="checkbox" name="permissions[]" value="categories" id="perm_categories" <?= in_array('categories', $userPermissions) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="perm_categories">Quản lý Danh mục</label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input perm-checkbox" type="checkbox" name="permissions[]" value="brands" id="perm_brands" <?= in_array('brands', $userPermissions) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="perm_brands">Quản lý Thương hiệu</label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input perm-checkbox" type="checkbox" name="permissions[]" value="attributes" id="perm_attributes" <?= in_array('attributes', $userPermissions) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="perm_attributes">Quản lý Thuộc tính</label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input perm-checkbox" type="checkbox" name="permissions[]" value="orders" id="perm_orders" <?= in_array('orders', $userPermissions) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="perm_orders">Quản lý Đơn hàng</label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input perm-checkbox" type="checkbox" name="permissions[]" value="contacts_cskh" id="perm_contacts_cskh" <?= in_array('contacts_cskh', $userPermissions) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="perm_contacts_cskh">Quản lý Phản ánh (CSKH)</label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input perm-checkbox" type="checkbox" name="permissions[]" value="contacts_kythuat" id="perm_contacts_kythuat" <?= in_array('contacts_kythuat', $userPermissions) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="perm_contacts_kythuat">Quản lý Phản ánh (Kỹ thuật)</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input perm-checkbox" type="checkbox" name="permissions[]" value="news" id="perm_news" <?= in_array('news', $userPermissions) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="perm_news">Quản lý Tin tức</label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input perm-checkbox" type="checkbox" name="permissions[]" value="banners" id="perm_banners" <?= in_array('banners', $userPermissions) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="perm_banners">Quản lý Banner</label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input perm-checkbox" type="checkbox" name="permissions[]" value="reviews" id="perm_reviews" <?= in_array('reviews', $userPermissions) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="perm_reviews">Quản lý Đánh giá</label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input perm-checkbox" type="checkbox" name="permissions[]" value="flash_sales" id="perm_flash_sales" <?= in_array('flash_sales', $userPermissions) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="perm_flash_sales">Quản lý Flash Sale</label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input perm-checkbox" type="checkbox" name="permissions[]" value="discounts" id="perm_discounts" <?= in_array('discounts', $userPermissions) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="perm_discounts">Quản lý Mã giảm giá</label>
                                    </div>
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block"><i class="bi bi-info-circle"></i> Tùy chỉnh quyền hạn riêng cho tài khoản này. Hệ thống sẽ tự động check theo phòng ban khi bạn thay đổi Vai trò.</small>
                        </div>
                    </div>
                </div>

                <div class="row form-horizontal-row align-items-center">
                    <div class="col-md-3">
                        <label class="form-horizontal-label mb-0">Trạng thái</label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-check form-switch d-flex align-items-center" style="font-size: 1.1rem;">
                            <input type="hidden" name="status" value="0">
                            <input class="form-check-input mt-0" type="checkbox" role="switch" id="statusSwitch" name="status" value="1" <?= (($user['status'] ?? 1) == 1) ? 'checked' : '' ?> style="cursor: pointer; width: 2.5em; height: 1.25em;">
                            <label class="form-check-label ms-3 mb-0" for="statusSwitch" style="cursor: pointer;">Hoạt động</label>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-actions mt-5">
                    <?php if ($id): ?>
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
    const roleSelect = document.getElementById("roleSelect");
    const permissionsGroup = document.getElementById("permissionsGroup");
    const permCheckboxes = document.querySelectorAll(".perm-checkbox");

    const rolePermissions = {
        1: ["products", "categories", "brands", "attributes", "orders", "contacts_cskh", "contacts_kythuat", "news", "banners", "reviews", "flash_sales", "discounts"], // CNTT (All)
        2: ["orders", "contacts_cskh", "reviews"], // CSKH
        3: ["products", "categories", "brands", "attributes", "orders", "contacts_kythuat", "reviews"], // Vận hành
        4: ["news", "banners", "flash_sales", "discounts"] // Marketing
    };

    roleSelect.addEventListener("change", function() {
        const val = parseInt(this.value);
        if (val === 0) {
            permissionsGroup.style.display = "none";
            permCheckboxes.forEach(cb => cb.checked = false);
        } else {
            permissionsGroup.style.display = "flex";
            const perms = rolePermissions[val] || [];
            permCheckboxes.forEach(cb => {
                cb.checked = perms.includes(cb.value);
            });
        }
    });

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
            alert("Số điện thoại phải là số, bắt đầu bằng 0 và có 10 chữ số");
            e.preventDefault();
            return;
        }
    });
});
</script>