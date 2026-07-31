<!DOCTYPE html>
<html lang="vi" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?? 'Admin - DGENTECH' ?>
    </title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= BASE_CSS ?>style.css?v=<?= time() ?>" rel="stylesheet">
    <link href="<?= BASE_CSS ?>admin.css?v=<?= time() ?>" rel="stylesheet">
</head>

<body>

    <div class="admin-wrapper">

        <!-- Sidebar Overlay (mobile) -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- ========== SIDEBAR ========== -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <a href="<?= BASE_URL ?>?action=admin" class="sidebar-brand p-2 d-flex justify-content-center">
                    <img src="<?= BASE_URL ?>assets/uploads/logo.jpg" alt="DGENTECH Logo"
                        style="height: 80px; object-fit: contain; max-width: 100%; transform: scale(1.3); margin: 10px 0;">
                </a>
                <button class="sidebar-close" id="sidebarCloseBtn">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <nav class="sidebar-nav">
                <?php if ($_SESSION['user']['role'] == 1): ?>
                    <div class="nav-label">Hệ Thống</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?= ($action ?? '') === 'admin' ? 'active' : '' ?>"
                                href="<?= BASE_URL ?>?action=admin">
                                <i class="bi bi-grid-1x2-fill"></i> Dashboard
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>

                <div class="nav-label">Quản Trị Hệ Thống</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?= in_array($action ?? '', ['admin-products', 'admin-product-create', 'admin-product-edit']) ? 'active' : '' ?>"
                            href="<?= BASE_URL ?>?action=admin-products">
                            <i class="bi bi-box-seam"></i> Sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($action ?? '') === 'admin-categories' ? 'active' : '' ?>"
                            href="<?= BASE_URL ?>?action=admin-categories">
                            <i class="bi bi-tags"></i> Danh mục
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($action ?? '') === 'admin-brands' ? 'active' : '' ?>"
                            href="<?= BASE_URL ?>?action=admin-brands">
                            <i class="bi bi-star"></i> Thương hiệu
                        </a>
                    </li>
                    <?php if ($_SESSION['user']['role'] == 1): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= in_array($action ?? '', ['admin-orders', 'admin-order-detail']) ? 'active' : '' ?>"
                                href="<?= BASE_URL ?>?action=admin-orders">
                                <i class="bi bi-receipt"></i> Đơn hàng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($action ?? '') === 'admin-users' ? 'active' : '' ?>"
                                href="<?= BASE_URL ?>?action=admin-users">
                                <i class="bi bi-people"></i> Tài Khoản
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <?php if ($_SESSION['user']['role'] == 1): ?>
                    <div class="nav-label">Tùy Chọn </div>
                    <ul class="nav flex-column">
                    <?php else: ?>
                        <ul class="nav flex-column">
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>">
                                <i class="bi bi-globe"></i> Xem website
                            </a>
                        </li>
                    </ul>
            </nav>

            <div class="sidebar-footer">
                <div class="admin-user">
                    <div class="admin-avatar">
                        <?= substr($_SESSION['user']['full_name'] ?? 'A', 0, 1) ?>
                    </div>
                    <div class="admin-info">
                        <span>
                            <?= $_SESSION['user']['full_name'] ?? 'Admin' ?>
                        </span>
                        <small>
                            <?= $_SESSION['user']['email'] ?? 'admin@dgentech.vn' ?>
                        </small>
                    </div>
                </div>
            </div>
        </aside>

        <!-- ========== MAIN CONTENT ========== -->
        <div class="admin-main">
            <!-- Top Bar -->
            <header class="admin-topbar">
                <div class="topbar-left">
                    <button class="topbar-toggle" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <div>
                        <h5>
                            <?= $pageTitle ?? 'Dashboard' ?>
                        </h5>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>?action=admin">Admin</a></li>
                                <li class="breadcrumb-item active">
                                    <?= $pageTitle ?? 'Dashboard' ?>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="topbar-right">
                    <button class="theme-toggle" aria-label="Chuyển đổi giao diện">
                        <i class="bi bi-moon-fill icon-moon"></i>
                        <i class="bi bi-sun-fill icon-sun"></i>
                    </button>
                    <a href="<?= BASE_URL ?>?action=logout" class="btn btn-sm btn-outline-danger rounded-pill">
                        <i class="bi bi-box-arrow-right me-1"></i> Đăng xuất
                    </a>
                </div>
            </header>

            <!-- Content -->
            <div class="admin-content">
                <?php
                if (isset($view)) {
                    require_once PATH_VIEW . $view . '.php';
                }
                ?>
            </div>
        </div>

    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="<?= BASE_JS ?>admin.js"></script>
    <script>
        // Auto-dismiss alerts after 2 seconds
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function (alert) {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(function () {
                        alert.remove();
                    }, 500);
                });
            }, 2000);
        });
    </script>

</body>

</html>