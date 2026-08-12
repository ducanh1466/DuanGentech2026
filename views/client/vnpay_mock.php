<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cổng thanh toán VNPAY (MOCK)</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f4f6f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .vnpay-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 500px;
            overflow: hidden;
        }
        .vnpay-header {
            background: #0054A6; /* Màu xanh đặc trưng VNPAY */
            color: white;
            padding: 20px;
            text-align: center;
        }
        .vnpay-logo {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .vnpay-body {
            padding: 30px;
        }
        .order-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
            border: 1px dashed #ced4da;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .info-row:last-child {
            margin-bottom: 0;
        }
        .amount-highlight {
            font-size: 24px;
            font-weight: bold;
            color: #0054A6;
        }
        .qr-placeholder {
            width: 200px;
            height: 200px;
            background: #eee;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            border: 2px solid #0054A6;
            color: #666;
            flex-direction: column;
        }
        .btn-confirm {
            background: #0054A6;
            border-color: #0054A6;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            margin-bottom: 15px;
        }
        .btn-confirm:hover {
            background: #004080;
            border-color: #004080;
        }
        .btn-cancel {
            background: #e9ecef;
            color: #495057;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            border: none;
        }
        .btn-cancel:hover {
            background: #dee2e6;
        }
    </style>
</head>
<body>

    <div class="vnpay-card">
        <div class="vnpay-header">
            <div class="vnpay-logo">
                <i class="bi bi-wallet2"></i> VNPAY<span style="color: #ffc107;">QR</span>
            </div>
            <div class="small opacity-75">Cổng thanh toán an toàn</div>
        </div>

        <div class="vnpay-body text-center">
            
            <div class="order-info text-start">
                <div class="info-row">
                    <span class="text-muted">Mã đơn hàng:</span>
                    <span class="fw-bold text-dark">#<?= htmlspecialchars($order['order_id']) ?></span>
                </div>
                <div class="info-row">
                    <span class="text-muted">Khách hàng:</span>
                    <span class="fw-medium text-dark"><?= htmlspecialchars($order['recipient_name']) ?></span>
                </div>
                <hr>
                <div class="info-row align-items-center">
                    <span class="text-muted">Tổng tiền:</span>
                    <span class="amount-highlight"><?= number_format($order['total_amount'], 0, ',', '.') ?> VND</span>
                </div>
            </div>

            <div class="qr-placeholder">
                <i class="bi bi-qr-code-scan fs-1 mb-2 text-primary"></i>
                <span class="small fw-medium">Quét mã để thanh toán</span>
            </div>

            <form action="?action=vnpay-process" method="POST">
                <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['order_id']) ?>">
                <button type="submit" class="btn btn-primary btn-confirm shadow-sm">
                    <i class="bi bi-check-circle me-1"></i> Xác nhận Thanh toán Thành công
                </button>
            </form>

            <a href="?action=cart" class="btn btn-cancel">
                Hủy giao dịch
            </a>
            
        </div>
    </div>

</body>
</html>
