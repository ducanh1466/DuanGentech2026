<?php
$methodName = 'Cổng thanh toán';
$color = '#333';
$icon = 'bi-credit-card';

switch ($method) {
    case 'vnpay':
        $methodName = 'VNPAY';
        $color = '#0054A6';
        $icon = 'bi-wallet2';
        break;
    case 'momo':
        $methodName = 'MoMo';
        $color = '#A50064';
        $icon = 'bi-wallet2';
        break;
    case 'zalopay':
        $methodName = 'ZaloPay';
        $color = '#0068FF';
        $icon = 'bi-wallet2';
        break;
    case 'applepay':
        $methodName = 'Apple Pay';
        $color = '#000000';
        $icon = 'bi-apple';
        break;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cổng thanh toán <?= $methodName ?> (MOCK)</title>
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
        .payment-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 500px;
            overflow: hidden;
        }
        .payment-header {
            background: <?= $color ?>;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .payment-logo {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .payment-body {
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
            color: <?= $color ?>;
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
            border: 2px solid <?= $color ?>;
            color: #666;
            flex-direction: column;
        }
        .btn-confirm {
            background: <?= $color ?>;
            border-color: <?= $color ?>;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            margin-bottom: 15px;
            color: #fff;
        }
        .btn-confirm:hover {
            opacity: 0.9;
            color: #fff;
        }
        .btn-cancel {
            background: #e9ecef;
            color: #495057;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            border: none;
            display: block;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-cancel:hover {
            background: #dee2e6;
            color: #495057;
        }
    </style>
</head>
<body>

    <div class="payment-card">
        <div class="payment-header">
            <div class="payment-logo">
                <i class="bi <?= $icon ?>"></i> <?= $methodName ?>
            </div>
            <div class="small opacity-75">Cổng thanh toán an toàn</div>
        </div>

        <div class="payment-body text-center">
            
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
                <?php if ($method === 'applepay'): ?>
                    <i class="bi bi-fingerprint fs-1 mb-2" style="color: <?= $color ?>"></i>
                    <span class="small fw-medium">Xác thực Touch ID / Face ID</span>
                <?php else: ?>
                    <i class="bi bi-qr-code-scan fs-1 mb-2" style="color: <?= $color ?>"></i>
                    <span class="small fw-medium">Quét mã để thanh toán</span>
                <?php endif; ?>
            </div>

            <form action="?action=payment-process" method="POST">
                <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['order_id']) ?>">
                <button type="submit" class="btn btn-confirm shadow-sm">
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
