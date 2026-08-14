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
                <a href="<?= BASE_URL ?>?action=admin"
                    class="sidebar-brand p-3 d-flex justify-content-center align-items-center text-decoration-none">
                    <div
                        style="background-color: #ffffff; padding: 10px 15px; border-radius: 12px; width: 90%; display: flex; justify-content: center; align-items: center; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                        <img src="<?= BASE_URL ?>assets/uploads/logo1.png?v=<?= time() ?>" alt="Brand Logo"
                            style="max-height: 42px; width: auto; object-fit: contain; transition: transform 0.3s ease;"
                            onmouseover="this.style.transform='scale(1.05)'"
                            onmouseout="this.style.transform='scale(1)'">
                    </div>
                </a>
                <button class="sidebar-close" id="sidebarCloseBtn">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <nav class="sidebar-nav">
                    <div class="nav-label">Hệ Thống</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?= ($action ?? '') === 'admin' ? 'active' : '' ?>"
                                href="<?= BASE_URL ?>?action=admin">
                                <i class="bi bi-grid-1x2-fill"></i> Dashboard
                            </a>
                        </li>
                    </ul>

                <div class="nav-label">Quản Trị Hệ Thống</div>
                <ul class="nav flex-column">
                    <?php 
                        $role = $_SESSION['user']['role']; 
                        $permissionsStr = $_SESSION['user']['permissions'] ?? '[]';
                        $permissions = json_decode($permissionsStr, true);
                        if (!is_array($permissions)) $permissions = [];
                    ?>
                    
                    <?php if ($role == 1 || in_array('products', $permissions)): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= in_array($action ?? '', ['admin-products', 'admin-product-create', 'admin-product-edit']) ? 'active' : '' ?>"
                                href="<?= BASE_URL ?>?action=admin-products">
                                <i class="bi bi-box-seam"></i> Sản phẩm
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php if ($role == 1 || in_array('categories', $permissions)): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($action ?? '') === 'admin-categories' ? 'active' : '' ?>"
                                href="<?= BASE_URL ?>?action=admin-categories">
                                <i class="bi bi-tags"></i> Danh mục
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php if ($role == 1 || in_array('brands', $permissions)): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($action ?? '') === 'admin-brands' ? 'active' : '' ?>"
                                href="<?= BASE_URL ?>?action=admin-brands">
                                <i class="bi bi-star"></i> Thương hiệu
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php if ($role == 1 || in_array('attributes', $permissions)): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos($action ?? '', 'admin-attribute') !== false ? 'active' : '' ?>"
                                href="<?= BASE_URL ?>?action=admin-attributes">
                                <i class="bi bi-sliders"></i> Thuộc tính
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($role == 1 || in_array('orders', $permissions)): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= in_array($action ?? '', ['admin-orders', 'admin-order-detail']) ? 'active' : '' ?>"
                                href="<?= BASE_URL ?>?action=admin-orders">
                                <i class="bi bi-receipt"></i> Đơn hàng
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($role == 1 || in_array('contacts', $permissions)): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos($action ?? '', 'admin-contact') !== false ? 'active' : '' ?>"
                                href="<?= BASE_URL ?>?action=admin-contacts">
                                <i class="bi bi-headset"></i> Phản ánh
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($role == 1 || in_array('banners', $permissions)): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= in_array($action ?? '', ['admin-banners', 'admin-banner-form']) ? 'active' : '' ?>"
                                href="<?= BASE_URL ?>?action=admin-banners">
                                <i class="bi bi-images"></i> Banner
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($role == 1 || in_array('news', $permissions)): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos($action ?? '', 'admin-news') !== false ? 'active' : '' ?>"
                                href="<?= BASE_URL ?>?action=admin-news">
                                <i class="bi bi-newspaper"></i> Tin tức
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($role == 1): ?>
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
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>">
                                <i class="bi bi-globe"></i> Xem website
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>
            </nav>

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
                <div class="topbar-right d-flex align-items-center gap-3">
                    <button class="theme-toggle" aria-label="Chuyển đổi giao diện">
                        <i class="bi bi-moon-fill icon-moon"></i>
                        <i class="bi bi-sun-fill icon-sun"></i>
                    </button>

                    <div class="dropdown">
                        <div class="cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                            <div
                                style="width: 38px; height: 38px; border-radius: 50%; background-color: #0d6efd; color: white; display: flex; align-items: center; justify-content: center; font-weight: 500; font-size: 1.1rem;">
                                <?= strtoupper(substr($_SESSION['user']['full_name'] ?? 'A', 0, 1)) ?>
                            </div>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0"
                            style="border-radius: 8px; margin-top: 10px; min-width: 200px;">
                            <li><a class="dropdown-item py-2 text-secondary"
                                    href="<?= BASE_URL ?>?action=admin-profile">Thông tin tài khoản</a></li>
                            <li><a class="dropdown-item py-2 text-secondary"
                                    href="<?= BASE_URL ?>?action=admin-change-password">Đổi mật khẩu</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item py-2 text-secondary" href="<?= BASE_URL ?>?action=logout">Đăng
                                    xuất</a></li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="admin-content">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $_SESSION['success'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $_SESSION['error'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

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