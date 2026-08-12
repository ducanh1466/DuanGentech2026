<div class="py-5 bg-light">
    <div class="container text-center py-5">
        <div class="mb-4">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
        </div>
        <h1 class="fw-bold mb-3">Đặt Hàng Thành Công!</h1>
        <p class="text-muted fs-5 mb-4">Cảm ơn bạn đã mua sắm tại Gentech. Đơn hàng <strong>#<?= htmlspecialchars($orderId) ?></strong> của bạn đã được ghi nhận và đang chờ xử lý.</p>
        
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="?action=profile" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-medium">Xem Đơn Hàng Của Tôi</a>
            <a href="<?= BASE_URL ?>" class="btn btn-primary rounded-pill px-4 py-2 fw-medium">Tiếp Tục Mua Sắm</a>
        </div>
    </div>
</div>
