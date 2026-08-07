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
    <div class="row g-5">
        <!-- Billing & Shipping Details -->
        <div class="col-lg-7" data-aos="fade-right">
            <!-- Account Notice -->
            <div class="alert alert-primary bg-primary-subtle border-0 rounded-4 d-flex align-items-center mb-5" role="alert">
                <i class="bi bi-info-circle-fill fs-4 me-3 text-primary"></i>
                <div>
                    Bạn đã có tài khoản? <a href="?action=login" class="alert-link text-decoration-none">Nhấn vào đây để đăng nhập</a> để tích điểm thành viên.
                </div>
            </div>

            <!-- Shipping Form -->
            <div class="bg-white rounded-4 shadow-sm border p-4 p-md-5 mb-5">
                <form>
                    <!-- 1. Chi tiết khách hàng -->
                    <h3 class="fw-bold mb-4 text-dark">1. Chi tiết khách hàng</h3>
                    <div class="row g-4 mb-5">
                        <div class="col-12">
                            <label class="form-label text-muted small mb-1">E-mail <span class="text-danger">*</span></label>
                            <input type="email" class="form-control border-0 border-bottom rounded-0 px-0 shadow-none fw-medium text-dark" placeholder="phamducanh14a@gmail.com" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted small mb-1">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 px-0 shadow-none fw-medium text-dark" placeholder="Phạm Đức Anh" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small mb-1">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control border-0 border-bottom rounded-0 px-0 shadow-none fw-medium text-dark" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small mb-1">Số điện thoại (tùy chọn)</label>
                            <input type="tel" class="form-control border-0 border-bottom rounded-0 px-0 shadow-none fw-medium text-dark">
                        </div>
                    </div>

                    <!-- 2. Địa chỉ giao hàng -->
                    <h3 class="fw-bold mb-3 text-dark">Địa chỉ giao hàng</h3>
                    <p class="fw-bold text-dark mb-4" style="font-size: 0.9rem;">
                        Chúng tôi đang trong quá trình cập nhật địa chỉ giao hàng theo đơn vị hành chính mới, vui lòng chọn địa chỉ giao hàng theo đơn vị hành chính cũ trong thời gian cập nhật hệ thống.
                    </p>
                    
                    <h5 class="fw-bold mb-4 text-dark">Địa chỉ mới</h5>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label text-muted small mb-1">Số nhà <span class="text-danger">*</span></label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 px-0 shadow-none fw-medium text-dark" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small mb-1">Đường phố <span class="text-danger">*</span></label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 px-0 shadow-none fw-medium text-dark" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label text-muted small mb-1">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y text-muted"></i>
                                <select class="form-select border-0 border-bottom rounded-0 ps-4 shadow-none fw-medium text-dark" required>
                                    <option value=""></option>
                                    <option value="1">Hà Nội</option>
                                    <option value="2">Hồ Chí Minh</option>
                                </select>
                            </div>
                            <small class="text-danger d-block mt-2">Tỉnh/Thành phố không đúng. Vui lòng nhập Tỉnh/Thành phố đúng.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small mb-1">Huyện <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y text-muted"></i>
                                <select class="form-select border-0 border-bottom rounded-0 ps-4 shadow-none fw-medium text-dark" required>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small mb-1">Phường <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y text-muted"></i>
                                <select class="form-select border-0 border-bottom rounded-0 ps-4 shadow-none fw-medium text-dark" required>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small mb-1">Làng/Khu phố (tùy chọn)</label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 px-0 shadow-none fw-medium text-dark">
                        </div>

                        <div class="col-12 mt-5">
                            <label class="form-label text-muted small mb-2">Phiếu giao hàng (tùy chọn)</label>
                            <textarea class="form-control border rounded-3 p-3 shadow-none text-muted" rows="4" placeholder="Vui lòng nhập tiếng Việt không dấu. Ghi rõ tòa nhà, tên căn hộ, số tầng, số phòng (nếu có)"></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Payment Methods -->
            <h4 class="fw-bold mb-4">Phương Thức Thanh Toán</h4>
            <div class="bg-white rounded-4 shadow-sm border p-4 p-md-5">
                <div class="d-flex flex-column gap-3">
                    <!-- COD -->
                    <label class="border rounded-3 p-3 cursor-pointer hover-bg-light transition-all position-relative d-flex align-items-center">
                        <input class="form-check-input mt-0 me-3 custom-radio" type="radio" name="payment_method" value="cod" checked style="transform: scale(1.2);">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light rounded p-2 text-dark"><i class="bi bi-cash-coin fs-4"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Thanh toán khi nhận hàng (COD)</h6>
                                <p class="text-muted small mb-0">Thanh toán bằng tiền mặt khi giao hàng tới nơi.</p>
                            </div>
                        </div>
                    </label>

                    <!-- Banking -->
                    <label class="border rounded-3 p-3 cursor-pointer hover-bg-light transition-all position-relative d-flex align-items-center">
                        <input class="form-check-input mt-0 me-3 custom-radio" type="radio" name="payment_method" value="banking" style="transform: scale(1.2);">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light rounded p-2 text-primary"><i class="bi bi-bank fs-4"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Chuyển khoản ngân hàng (Quét mã QR)</h6>
                                <p class="text-muted small mb-0">Xác nhận thanh toán tự động, nhanh chóng.</p>
                            </div>
                        </div>
                    </label>

                    <!-- VNPAY -->
                    <label class="border rounded-3 p-3 cursor-pointer hover-bg-light transition-all position-relative d-flex align-items-center">
                        <input class="form-check-input mt-0 me-3 custom-radio" type="radio" name="payment_method" value="vnpay" style="transform: scale(1.2);">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light rounded p-2 text-info"><i class="bi bi-credit-card-2-front fs-4"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Thanh toán qua VNPAY</h6>
                                <p class="text-muted small mb-0">Sử dụng thẻ ATM, thẻ tín dụng hoặc ứng dụng ngân hàng.</p>
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
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white rounded-3 p-1 border position-relative" style="width: 60px; height: 60px;">
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">1</span>
                            <img src="DUONG_DAN_ANH_CART_1.jpg" class="w-100 h-100 object-fit-contain mix-blend-multiply">
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1 fs-6">iPhone 15 Pro Max</h6>
                            <p class="text-muted small mb-0">Titan Tự Nhiên - 256GB</p>
                        </div>
                        <div class="fw-bold text-dark">29.990.000đ</div>
                    </div>
                    
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white rounded-3 p-1 border position-relative" style="width: 60px; height: 60px;">
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">1</span>
                            <img src="DUONG_DAN_ANH_CART_2.jpg" class="w-100 h-100 object-fit-contain mix-blend-multiply">
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1 fs-6">AirPods Pro 2</h6>
                            <p class="text-muted small mb-0">Trắng</p>
                        </div>
                        <div class="fw-bold text-dark">5.890.000đ</div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mb-3 text-muted">
                    <span>Tổng tiền hàng</span>
                    <span class="text-dark fw-medium">35.880.000đ</span>
                </div>
                <div class="d-flex justify-content-between mb-3 text-muted">
                    <span>Phí vận chuyển (Hỏa tốc)</span>
                    <span class="text-dark fw-medium">50.000đ</span>
                </div>
                <div class="d-flex justify-content-between mb-3 text-muted border-bottom border-gray-300 pb-4">
                    <span>Giảm giá</span>
                    <span class="text-danger fw-medium">- 50.000đ</span>
                </div>
                
                <div class="d-flex justify-content-between align-items-end mt-4 mb-5">
                    <span class="fw-bold fs-5 text-dark">Tổng Cộng</span>
                    <div class="text-end">
                        <span class="fw-bold text-primary d-block" style="font-size: 2.2rem; line-height: 1;">35.880.000đ</span>
                        <span class="text-muted small">Đã bao gồm VAT</span>
                    </div>
                </div>
                
                <button type="button" class="btn btn-primary w-100 rounded-pill py-3 fw-bold fs-5 shadow-sm hover-scale transition-transform d-flex justify-content-center align-items-center gap-2">
                    <i class="bi bi-lock-fill"></i> ĐẶT HÀNG NGAY
                </button>
                
                <p class="text-center text-muted small mt-4 mb-0">
                    Bằng việc đặt hàng, bạn đồng ý với <a href="#" class="text-decoration-none">Điều khoản sử dụng</a> và <a href="#" class="text-decoration-none">Chính sách bảo mật</a> của Gentech.
                </p>
            </div>
        </div>
    </div>
</div>
