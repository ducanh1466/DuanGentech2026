<!-- Page Header -->
<div class="bg-gray-100 py-4 border-bottom">
    <div class="container">
        <h2 class="fw-bold mb-2">Thanh Toán Đơn Hàng</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="?action=cart" class="text-decoration-none text-muted hover-primary">Giỏ hàng</a></li>
                <li class="breadcrumb-item active text-dark fw-medium" aria-current="page">Thanh toán</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Checkout Content -->
<div class="container py-5 my-3 mb-5">
    <form method="POST" action="?action=checkout-process">
        <div class="row g-5">
            <!-- Billing & Shipping Details -->
            <div class="col-lg-7" data-aos="fade-right">
                <!-- Shipping Form -->
                <div class="bg-white rounded-4 shadow-sm border p-4 p-md-5 mb-5">
                    
                        <!-- 1. Chi tiết khách hàng -->
                        <h3 class="fw-bold mb-4 text-dark">Thông tin giao hàng</h3>
                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1 fw-bold">Tên người nhận <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <input type="text" name="recipient_name" class="form-control border rounded-3 p-2 shadow-none text-dark bg-white" value="<?= htmlspecialchars($user['full_name'] ?? '') ?>" placeholder="Nhập tên người nhận" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1 fw-bold">Số điện thoại người nhận <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <input type="tel" name="recipient_phone" class="form-control border rounded-3 p-2 shadow-none text-dark bg-white" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="Nhập số điện thoại" required>
                                </div>
                            </div>

                            <div class="col-12 mt-4 mb-0">
                                <h6 class="fw-bold text-dark mb-0">Địa chỉ nhận hàng</h6>
                            </div>

                            <div class="col-md-6 mt-3">
                                <label class="form-label text-muted small mb-1 fw-bold">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                <select name="province" id="province" class="form-select border rounded-3 p-2 shadow-none text-dark bg-white" required>
                                    <option value="">Chọn Tỉnh/Thành phố</option>
                                </select>
                                <input type="hidden" name="province_name" id="province_name">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label text-muted small mb-1 fw-bold">Quận/Huyện <span class="text-danger">*</span></label>
                                <select name="district" id="district" class="form-select border rounded-3 p-2 shadow-none text-dark bg-white" required disabled>
                                    <option value="">Chọn Quận/Huyện</option>
                                </select>
                                <input type="hidden" name="district_name" id="district_name">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1 fw-bold">Phường/Xã <span class="text-danger">*</span></label>
                                <select name="ward" id="ward" class="form-select border rounded-3 p-2 shadow-none text-dark bg-white" required disabled>
                                    <option value="">Chọn Phường/Xã</option>
                                </select>
                                <input type="hidden" name="ward_name" id="ward_name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1 fw-bold">Địa chỉ nhà <span class="text-danger">*</span></label>
                                <input type="text" name="street_address" class="form-control border rounded-3 p-2 shadow-none text-dark bg-white" placeholder="Nhập địa chỉ nhà" required>
                            </div>

                            <div class="col-12 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input border-gray-400 cursor-pointer shadow-none" type="checkbox" name="save_address" value="1" id="saveAddress">
                                    <label class="form-check-label text-primary fw-medium cursor-pointer" for="saveAddress">
                                        Lưu địa chỉ cho lần mua kế tiếp
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <label class="form-label text-muted small mb-2 fw-bold">Ghi chú (nếu có)</label>
                                <textarea name="note" class="form-control border rounded-3 p-3 shadow-none text-dark bg-white" rows="3" placeholder="Nhập ghi chú"></textarea>
                            </div>
                        </div>
                    
                </div>

                <!-- Payment Methods -->
                <h4 class="fw-bold mb-4">Phương Thức Thanh Toán</h4>
                <div class="bg-white rounded-4 shadow-sm border p-4 p-md-5">
                    <div class="d-flex flex-column gap-3">
                        <!-- COD -->
                        <label class="border rounded-3 p-3 cursor-pointer hover-bg-light transition-all position-relative d-flex align-items-center">
                            <input class="form-check-input mt-0 me-3 custom-radio" type="radio" name="payment_method" value="cod" checked style="transform: scale(1.2);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-light rounded p-2 text-dark d-flex justify-content-center align-items-center" style="width:50px;height:50px;">
                                    <i class="bi bi-cash-coin fs-3"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Thanh toán khi nhận hàng (COD)</h6>
                                    <p class="text-muted small mb-0">Thanh toán bằng tiền mặt khi giao hàng tới nơi.</p>
                                </div>
                            </div>
                        </label>
                        <!-- VNPAY (Mock) -->
                        <label class="border rounded-3 p-3 cursor-pointer hover-bg-light transition-all position-relative d-flex align-items-center">
                            <input class="form-check-input mt-0 me-3 custom-radio" type="radio" name="payment_method" value="vnpay" style="transform: scale(1.2);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-light rounded p-2 d-flex justify-content-center align-items-center" style="width:50px;height:50px;">
                                    <img src="https://vnpay.vn/s1/statics.vnpay.vn/2023/6/0oxhzjmxbksr1686814746087.png" alt="VNPay" style="max-width:100%;max-height:100%;object-fit:contain;">
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Thanh toán qua VNPAY</h6>
                                    <p class="text-muted small mb-0">Chuyển hướng đến cổng thanh toán VNPAY.</p>
                                </div>
                            </div>
                        </label>
                        <!-- MoMo (Mock) -->
                        <label class="border rounded-3 p-3 cursor-pointer hover-bg-light transition-all position-relative d-flex align-items-center">
                            <input class="form-check-input mt-0 me-3 custom-radio" type="radio" name="payment_method" value="momo" style="transform: scale(1.2);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-light rounded p-2 d-flex justify-content-center align-items-center" style="width:50px;height:50px;">
                                    <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/10/Logo-MoMo-Square.png" alt="MoMo" style="max-width:100%;max-height:100%;object-fit:contain; border-radius: 8px;">
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Thanh toán qua Ví MoMo</h6>
                                    <p class="text-muted small mb-0">Quét mã QR qua ứng dụng MoMo.</p>
                                </div>
                            </div>
                        </label>
                        <!-- ZaloPay (Mock) -->
                        <label class="border rounded-3 p-3 cursor-pointer hover-bg-light transition-all position-relative d-flex align-items-center">
                            <input class="form-check-input mt-0 me-3 custom-radio" type="radio" name="payment_method" value="zalopay" style="transform: scale(1.2);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-light rounded p-2 d-flex justify-content-center align-items-center" style="width:50px;height:50px;">
                                    <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/10/Logo-ZaloPay-Square.png" alt="ZaloPay" style="max-width:100%;max-height:100%;object-fit:contain;">
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Thanh toán qua ZaloPay</h6>
                                    <p class="text-muted small mb-0">Mở ZaloPay để thanh toán an toàn.</p>
                                </div>
                            </div>
                        </label>
                        <!-- Apple Pay (Mock) -->
                        <label class="border rounded-3 p-3 cursor-pointer hover-bg-light transition-all position-relative d-flex align-items-center">
                            <input class="form-check-input mt-0 me-3 custom-radio" type="radio" name="payment_method" value="applepay" style="transform: scale(1.2);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-light rounded p-2 d-flex justify-content-center align-items-center" style="width:50px;height:50px;">
                                    <i class="bi bi-apple fs-2 text-dark"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Thanh toán bằng Apple Pay</h6>
                                    <p class="text-muted small mb-0">Xác thực nhanh bằng Face ID / Touch ID.</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Order Summary & Checkout Action -->
            <div class="col-lg-5" data-aos="fade-left" data-aos-delay="200">
                <div class="bg-gray-100 rounded-4 shadow-float border p-4 p-md-5 sticky-top" style="top: 100px;">
                    <h4 class="fw-bold mb-4">Tóm Tắt Đơn Hàng</h4>
                    
                    <!-- Product List Minimal -->
                    <div class="d-flex flex-column gap-3 mb-4 pb-4 border-bottom border-gray-300">
                        <?php foreach ($cartItems as $item): ?>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-white rounded-3 p-1 border position-relative" style="width: 60px; height: 60px;">
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark"><?= $item['quantity'] ?></span>
                                <img src="<?= htmlspecialchars($item['image_url'] ?? 'assets/images/default.png') ?>" class="w-100 h-100 object-fit-contain mix-blend-multiply">
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1 fs-6 text-truncate" style="max-width: 150px;"><?= htmlspecialchars($item['product_name']) ?></h6>
                                <p class="text-muted small mb-0"><?= htmlspecialchars($item['variant_name']) ?></p>
                            </div>
                            <div class="fw-bold text-dark"><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ</div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3 text-muted">
                        <span>Tổng tiền hàng</span>
                        <span class="text-dark fw-medium"><?= number_format($totalAmount, 0, ',', '.') ?>đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 text-muted border-bottom border-gray-300 pb-4">
                        <span>Phí vận chuyển</span>
                        <span class="text-success fw-medium">Miễn phí</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-end mt-4 mb-5">
                        <span class="fw-bold fs-5 text-dark">Tổng Cộng</span>
                        <div class="text-end">
                            <span class="fw-bold text-primary d-block" style="font-size: 2.2rem; line-height: 1;"><?= number_format($totalAmount, 0, ',', '.') ?>đ</span>
                            <span class="text-muted small">Đã bao gồm VAT</span>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold fs-5 shadow-sm hover-scale transition-transform d-flex justify-content-center align-items-center gap-2">
                        <i class="bi bi-check-circle"></i> ĐẶT HÀNG NGAY
                    </button>
                    
                    <p class="text-center text-muted small mt-4 mb-0">
                        Bằng việc đặt hàng, bạn đồng ý với <a href="#" class="text-decoration-none">Điều khoản sử dụng</a> và <a href="#" class="text-decoration-none">Chính sách bảo mật</a> của Gentech.
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinceSelect = document.getElementById('province');
    const districtSelect = document.getElementById('district');
    const wardSelect = document.getElementById('ward');
    
    const provinceName = document.getElementById('province_name');
    const districtName = document.getElementById('district_name');
    const wardName = document.getElementById('ward_name');

    // 1. Lấy danh sách Tỉnh/Thành
    fetch('https://esgoo.net/api-tinhthanh/1/0.htm')
        .then(response => response.json())
        .then(data => {
            if (data.error === 0) {
                data.data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.full_name;
                    provinceSelect.appendChild(option);
                });
            }
        })
        .catch(error => console.error('Error fetching provinces:', error));

    // 2. Lắng nghe Tỉnh/Thành thay đổi -> Lấy Quận/Huyện
    provinceSelect.addEventListener('change', function() {
        const idtinh = this.value;
        // Cập nhật tên ẩn
        if(idtinh) {
            provinceName.value = this.options[this.selectedIndex].text;
        } else {
            provinceName.value = '';
        }

        districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
        wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
        wardSelect.disabled = true;
        
        if (idtinh) {
            districtSelect.disabled = false;
            fetch('https://esgoo.net/api-tinhthanh/2/' + idtinh + '.htm')
                .then(response => response.json())
                .then(data => {
                    if (data.error === 0) {
                        data.data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.full_name;
                            districtSelect.appendChild(option);
                        });
                    }
                });
        } else {
            districtSelect.disabled = true;
        }
    });

    // 3. Lắng nghe Quận/Huyện thay đổi -> Lấy Phường/Xã
    districtSelect.addEventListener('change', function() {
        const idquan = this.value;
        if(idquan) {
            districtName.value = this.options[this.selectedIndex].text;
        } else {
            districtName.value = '';
        }

        wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
        
        if (idquan) {
            wardSelect.disabled = false;
            fetch('https://esgoo.net/api-tinhthanh/3/' + idquan + '.htm')
                .then(response => response.json())
                .then(data => {
                    if (data.error === 0) {
                        data.data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.full_name;
                            wardSelect.appendChild(option);
                        });
                    }
                });
        } else {
            wardSelect.disabled = true;
        }
    });

    // 4. Lắng nghe Phường/Xã thay đổi
    wardSelect.addEventListener('change', function() {
        if(this.value) {
            wardName.value = this.options[this.selectedIndex].text;
        } else {
            wardName.value = '';
        }
    });
});
</script>
