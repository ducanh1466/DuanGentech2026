<!-- Page Header -->
<div class="py-5 bg-gray-100">
    <div class="container text-center">
        <h1 class="fw-bold mb-3" style="letter-spacing: -1px; font-size: 2.5rem;">Giỏ hàng của bạn.</h1>
        <p class="text-muted fs-5">Lựa chọn sản phẩm và tiến hành thanh toán</p>
    </div>
</div>

<?php 
// Lấy ID tự động tick từ URL nếu có (từ nút Mua ngay)
$autoTickId = $_GET['tick'] ?? null;
?>

<!-- Cart Content -->
<div class="container mb-5 pb-5 mt-4">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger border-0 bg-danger-subtle rounded-3 mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    <?php if (empty($cartItems)): ?>
        <div class="text-center py-5 bg-white rounded-4 shadow-sm border border-gray-200">
            <i class="bi bi-cart-x text-muted mb-3 d-block" style="font-size: 4rem;"></i>
            <h4 class="fw-bold text-dark">Giỏ hàng của bạn đang trống</h4>
            <p class="text-muted">Hãy tiếp tục mua sắm để tìm những sản phẩm tuyệt vời nhé!</p>
            <a href="?action=products" class="btn btn-primary rounded-pill px-4 mt-3">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <form method="POST" action="?action=checkout" id="cartForm">
            <div class="row justify-content-center g-4">
                
                <!-- Cart Items List -->
                <div class="col-lg-8" data-aos="fade-right">
                    
                    <div class="bg-white rounded-4 shadow-sm p-4 mb-4 d-flex align-items-center justify-content-between border border-gray-200">
                        <div class="form-check d-flex align-items-center mb-0 gap-2">
                            <input class="form-check-input mt-0 fs-5 border-gray-400 cursor-pointer shadow-none" type="checkbox" id="selectAll">
                            <label class="form-check-label fw-bold fs-6 pt-1 cursor-pointer select-none" for="selectAll">
                                Tất cả (<span id="totalItemsCount"><?= count($cartItems) ?></span> sản phẩm)
                            </label>
                        </div>
                        <span class="text-muted small"><i class="bi bi-shield-check text-success"></i> Hàng chính hãng 100%</span>
                    </div>

                    <div class="bg-white rounded-4 shadow-sm overflow-hidden p-0 mb-4 border border-gray-200">
                        <?php foreach ($cartItems as $index => $item): 
                            $isChecked = ($autoTickId && $autoTickId == $item['cart_item_id']) ? 'checked' : '';
                        ?>
                        <!-- Cart Item -->
                        <div class="cart-item-row row align-items-center py-4 border-bottom position-relative mx-0 px-3 <?= $isChecked ? 'bg-light bg-opacity-50' : '' ?>" data-price="<?= $item['price'] ?>" data-item-id="<?= $item['cart_item_id'] ?>">
                            <!-- Checkbox -->
                            <div class="col-1 text-center pe-0">
                                <input class="form-check-input item-checkbox fs-5 border-gray-400 cursor-pointer shadow-none" type="checkbox" name="selected_items[]" value="<?= $item['cart_item_id'] ?>" <?= $isChecked ?>>
                            </div>
                            
                            <!-- Product Image -->
                            <div class="col-3 col-md-2 px-2">
                                <img src="<?= htmlspecialchars($item['image_url'] ?? 'assets/images/default.png') ?>" class="img-fluid bg-gray-100 rounded-3 p-2 border" alt="<?= htmlspecialchars($item['product_name']) ?>">
                            </div>
                            
                            <!-- Product Info -->
                            <div class="col-8 col-md-4 ps-2">
                                <h6 class="fw-bold mb-1 text-truncate" style="max-width: 100%;">
                                    <a href="?action=product-detail&id=<?= $item['variant_id'] ?>" class="text-dark text-decoration-none hover-primary"><?= htmlspecialchars($item['product_name']) ?></a>
                                </h6>
                                <p class="text-muted small mb-2 bg-gray-100 d-inline-block px-2 py-1 rounded"><?= htmlspecialchars($item['variant_name']) ?></p>
                                
                                <div class="fw-bold fs-6 text-danger d-md-none mb-2"><?= number_format($item['price'], 0, ',', '.') ?>đ</div>
                                
                                <!-- Nút Xóa (Mobile) -->
                                <button type="button" class="btn btn-link text-muted p-0 hover-danger d-md-none remove-item-btn text-decoration-none" data-id="<?= $item['cart_item_id'] ?>">
                                    <i class="bi bi-trash3"></i> Xóa
                                </button>
                            </div>
                            
                            <!-- Price (Desktop) -->
                            <div class="col-md-2 text-center d-none d-md-block">
                                <span class="fw-bold text-danger fs-5"><?= number_format($item['price'], 0, ',', '.') ?>đ</span>
                            </div>

                            <!-- Quantity -->
                            <div class="col-md-2 d-none d-md-flex justify-content-center">
                                <div class="input-group input-group-sm bg-white border border-gray-300 rounded-3 p-1" style="width: 110px;">
                                    <button class="btn btn-light px-2 border-0 shadow-none qty-btn minus" type="button"><i class="bi bi-dash"></i></button>
                                    <input type="text" class="form-control border-0 text-center px-1 fw-bold qty-input shadow-none bg-white" value="<?= $item['quantity'] ?>" data-max="<?= $item['stock_quantity'] ?>" readonly>
                                    <button class="btn btn-light px-2 border-0 shadow-none qty-btn plus" type="button"><i class="bi bi-plus"></i></button>
                                </div>
                            </div>

                            <!-- Total & Delete (Desktop) -->
                            <div class="col-md-1 text-end d-none d-md-block">
                                <button type="button" class="btn btn-light rounded-circle text-muted hover-danger transition-all align-items-center justify-content-center d-inline-flex remove-item-btn" style="width: 35px; height: 35px;" data-id="<?= $item['cart_item_id'] ?>" title="Xóa sản phẩm">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                            
                            <!-- Hidden input lưu số lượng gửi lên server khi submit form checkout -->
                            <input type="hidden" name="quantities[<?= $item['cart_item_id'] ?>]" class="hidden-qty" value="<?= $item['quantity'] ?>">
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4" data-aos="fade-left" data-aos-delay="100">
                    <div class="bg-white p-4 p-md-4 rounded-4 shadow-sm border border-gray-200 sticky-top" style="top: 100px;">
                        <h5 class="fw-bold mb-4">Thông tin đơn hàng</h5>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-gray-50 rounded-3 border border-gray-200">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-ticket-perforated-fill text-danger fs-5"></i>
                                <span class="fw-medium text-dark">Áp dụng mã giảm giá</span>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-medium">Chọn</button>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>Số lượng sản phẩm</span>
                            <span class="text-dark fw-bold" id="summaryCount">-</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>Tổng tiền hàng</span>
                            <span class="text-dark fw-bold" id="summarySubTotal">-</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-3 text-muted border-bottom pb-3">
                            <span>Giảm giá trực tiếp</span>
                            <span class="text-success fw-bold">-</span>
                        </div>
                        
                        <div class="mb-4 pt-1">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold fs-6 text-dark">TỔNG TIỀN</span>
                                <span class="fw-bold text-danger" style="font-size: 1.6rem; letter-spacing: -1px;" id="summaryTotal">-</span>
                            </div>
                            <div class="text-end text-muted" style="font-size: 0.75rem;">(Đã bao gồm VAT và được làm tròn)</div>
                        </div>
                        
                        <button type="submit" class="btn btn-secondary w-100 rounded-3 py-3 fw-bold fs-5 shadow-sm transition-all" id="btnCheckout" disabled>
                            MUA NGAY <span id="btnCheckoutCount"></span>
                            <small class="d-block fw-normal mt-1 text-white-50" style="font-size: 0.8rem;">Giao nhanh từ 2 giờ hoặc nhận tại cửa hàng</small>
                        </button>
                    </div>
                </div>
                
            </div>
        </form>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const summaryCount = document.getElementById('summaryCount');
    const summarySubTotal = document.getElementById('summarySubTotal');
    const summaryTotal = document.getElementById('summaryTotal');
    const btnCheckout = document.getElementById('btnCheckout');
    const btnCheckoutCount = document.getElementById('btnCheckoutCount');

    // Cập nhật lại UI dựa trên các checkbox được chọn
    function updateCartSummary() {
        let totalQty = 0;
        let totalPrice = 0;
        let checkedCount = 0;

        itemCheckboxes.forEach(cb => {
            const row = cb.closest('.cart-item-row');
            if (cb.checked) {
                checkedCount++;
                row.classList.add('bg-light', 'bg-opacity-50');
                
                const price = parseFloat(row.getAttribute('data-price'));
                const qty = parseInt(row.querySelector('.qty-input').value);
                
                totalQty += qty;
                totalPrice += (price * qty);
            } else {
                row.classList.remove('bg-light', 'bg-opacity-50');
            }
        });

        // Update Select All Checkbox state
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = (checkedCount > 0 && checkedCount === itemCheckboxes.length);
        }

        // Update Text
        if (checkedCount === 0) {
            summaryCount.innerText = '-';
            summarySubTotal.innerText = '-';
            summaryTotal.innerText = '-';
            
            btnCheckout.classList.remove('btn-danger', 'bg-danger');
            btnCheckout.classList.add('btn-secondary');
            btnCheckout.disabled = true;
            btnCheckoutCount.innerText = '';
        } else {
            summaryCount.innerText = totalQty;
            summarySubTotal.innerText = new Intl.NumberFormat('vi-VN').format(totalPrice) + 'đ';
            summaryTotal.innerText = new Intl.NumberFormat('vi-VN').format(totalPrice) + 'đ';
            
            btnCheckout.classList.remove('btn-secondary');
            btnCheckout.classList.add('btn-danger', 'bg-danger');
            btnCheckout.disabled = false;
            btnCheckoutCount.innerText = `(${checkedCount})`;
        }
    }

    // Gắn sự kiện cho Checkbox Select All
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            itemCheckboxes.forEach(cb => {
                cb.checked = isChecked;
            });
            updateCartSummary();
        });
    }

    // Gắn sự kiện cho các Checkbox Item
    itemCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateCartSummary);
    });

    // Xử lý nút tăng giảm số lượng
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const row = this.closest('.cart-item-row');
            const input = row.querySelector('.qty-input');
            const hiddenInput = row.querySelector('.hidden-qty');
            let val = parseInt(input.value);
            const max = parseInt(input.getAttribute('data-max'));
            
            if (this.classList.contains('plus')) {
                if (val < max) val++;
            } else {
                if (val > 1) val--;
            }
            
            input.value = val;
            hiddenInput.value = val;
            
            // Xử lý gọi AJAX để lưu số lượng vào DB ngầm
            const itemId = row.getAttribute('data-item-id');
            const formData = new FormData();
            formData.append('cart_item_id', itemId);
            formData.append('quantity', val);
            formData.append('action_type', 'update'); // Fake post type if needed or just use current logic
            
            // We should ideally send this to an ajax endpoint. Currently the ?action=cart-update redirects.
            // Let's just update the UI for now, we'll implement full AJAX quantity update later if needed.
            // Actually, we can fetch it silently.
            
            // fetch('?action=cart-update-ajax', {
            //     method: 'POST',
            //     body: formData
            // });
            
            // Tính lại tiền
            const cb = row.querySelector('.item-checkbox');
            if (cb.checked) {
                updateCartSummary();
            }
        });
    });

    // Xử lý nút Xóa
    document.querySelectorAll('.remove-item-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                const itemId = this.getAttribute('data-id');
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '?action=cart-remove';
                
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'cart_item_id';
                input.value = itemId;
                
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    // Khởi tạo lần đầu chạy trang
    updateCartSummary();
});
</script>
