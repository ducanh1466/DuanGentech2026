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
    <style>
        .menu-toggle-icon {
            transition: transform 0.3s ease;
            font-size: 0.8rem;
        }
        [data-bs-toggle="collapse"]:not(.collapsed) .menu-toggle-icon {
            transform: rotate(180deg);
        }
    </style>
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
                    <div class="d-flex justify-content-center align-items-center"
                        style="width: 100%; min-height: 68px;">
                        <img src="<?= BASE_URL ?>assets/uploads/logo1.png?v=<?= time() ?>" alt="Brand Logo"
                            style="height: 56px; width: auto; object-fit: contain; transition: transform 0.3s ease; filter: drop-shadow(0 2px 8px rgba(15, 23, 42, 0.15));"
                            onmouseover="this.style.transform='scale(1.08)'"
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
                    if (!is_array($permissions))
                        $permissions = [];
                    ?>

                    <!-- QUẢN LÝ CATALOG -->
                    <?php if ($role == 1 || in_array('products', $permissions) || in_array('categories', $permissions) || in_array('brands', $permissions) || in_array('attributes', $permissions)): ?>
                        <?php 
                            $catalogActive = in_array($action ?? '', ['admin-products', 'admin-product-create', 'admin-product-edit', 'admin-inventory', 'admin-categories', 'admin-brands', 'admin-attributes']) || strpos($action ?? '', 'admin-attribute') !== false;
                        ?>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center <?= $catalogActive ? '' : 'collapsed' ?>" data-bs-toggle="collapse" href="#collapseCatalog" role="button" aria-expanded="<?= $catalogActive ? 'true' : 'false' ?>">
                                <i class="bi bi-box-seam me-2"></i> Catalog
                                <i class="bi bi-chevron-down ms-auto menu-toggle-icon"></i>
                            </a>
                            <div class="collapse <?= $catalogActive ? 'show' : '' ?>" id="collapseCatalog">
                                <ul class="nav flex-column ms-3 mt-1" style="border-left: 2px solid var(--border-light);">
                                    <?php if ($role == 1 || in_array('products', $permissions)): ?>
                                        <li class="nav-item">
                                            <a class="nav-link py-2 <?= in_array($action ?? '', ['admin-products', 'admin-product-create', 'admin-product-edit']) ? 'active' : '' ?>" href="<?= BASE_URL ?>?action=admin-products">
                                                <i class="bi bi-dot"></i> Sản phẩm
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link py-2 <?= ($action ?? '') === 'admin-inventory' ? 'active' : '' ?>" href="<?= BASE_URL ?>?action=admin-inventory">
                                                <i class="bi bi-dot"></i> Kho Hàng
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($role == 1 || in_array('categories', $permissions)): ?>
                                        <li class="nav-item">
                                            <a class="nav-link py-2 <?= ($action ?? '') === 'admin-categories' ? 'active' : '' ?>" href="<?= BASE_URL ?>?action=admin-categories">
                                                <i class="bi bi-dot"></i> Danh mục
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($role == 1 || in_array('brands', $permissions)): ?>
                                        <li class="nav-item">
                                            <a class="nav-link py-2 <?= ($action ?? '') === 'admin-brands' ? 'active' : '' ?>" href="<?= BASE_URL ?>?action=admin-brands">
                                                <i class="bi bi-dot"></i> Thương hiệu
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($role == 1 || in_array('attributes', $permissions)): ?>
                                        <li class="nav-item">
                                            <a class="nav-link py-2 <?= strpos($action ?? '', 'admin-attribute') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>?action=admin-attributes">
                                                <i class="bi bi-dot"></i> Thuộc tính
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>

                    <!-- QUẢN LÝ BÁN HÀNG -->
                    <?php if ($role == 1 || in_array('orders', $permissions) || in_array('reviews', $permissions) || in_array('contacts', $permissions)): ?>
                        <?php 
                            $salesActive = in_array($action ?? '', ['admin-orders', 'admin-order-detail', 'admin-reviews', 'admin-contacts']) || strpos($action ?? '', 'admin-review') !== false || strpos($action ?? '', 'admin-contact') !== false;
                        ?>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center <?= $salesActive ? '' : 'collapsed' ?>" data-bs-toggle="collapse" href="#collapseSales" role="button" aria-expanded="<?= $salesActive ? 'true' : 'false' ?>">
                                <i class="bi bi-cart me-2"></i> Bán Hàng
                                <i class="bi bi-chevron-down ms-auto menu-toggle-icon"></i>
                            </a>
                            <div class="collapse <?= $salesActive ? 'show' : '' ?>" id="collapseSales">
                                <ul class="nav flex-column ms-3 mt-1" style="border-left: 2px solid var(--border-light);">
                                    <?php if ($role == 1 || in_array('orders', $permissions)): ?>
                                        <li class="nav-item">
                                            <a class="nav-link py-2 <?= in_array($action ?? '', ['admin-orders', 'admin-order-detail']) ? 'active' : '' ?>" href="<?= BASE_URL ?>?action=admin-orders">
                                                <i class="bi bi-dot"></i> Đơn hàng
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($role == 1 || in_array('reviews', $permissions)): ?>
                                        <li class="nav-item">
                                            <a class="nav-link py-2 <?= strpos($action ?? '', 'admin-review') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>?action=admin-reviews">
                                                <i class="bi bi-dot"></i> Đánh giá
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($role == 1 || in_array('contacts', $permissions)): ?>
                                        <?php $contactActive = strpos($action ?? '', 'admin-contact') !== false; ?>
                                        <li class="nav-item">
                                            <a class="nav-link py-2 d-flex align-items-center <?= $contactActive ? '' : 'collapsed' ?>" data-bs-toggle="collapse" href="#collapseContacts" role="button" aria-expanded="<?= $contactActive ? 'true' : 'false' ?>">
                                                <i class="bi bi-dot"></i> Phản ánh
                                                <i class="bi bi-chevron-down ms-auto menu-toggle-icon" style="font-size: 0.75rem;"></i>
                                            </a>
                                            <div class="collapse <?= $contactActive ? 'show' : '' ?>" id="collapseContacts">
                                                <ul class="nav flex-column ms-3 mt-1" style="border-left: 2px solid var(--border-light);">
                                                    <?php if ($role == 1 || $role == 2): ?>
                                                    <li class="nav-item">
                                                        <a class="nav-link py-1 <?= ($action == 'admin-contacts' && ($_GET['department'] ?? '') == 'CSKH') ? 'active' : '' ?>" href="<?= BASE_URL ?>?action=admin-contacts&department=CSKH" style="font-size: 0.85rem;">
                                                            CSKH
                                                        </a>
                                                    </li>
                                                    <?php endif; ?>
                                                    <?php if ($role == 1 || $role == 3): ?>
                                                    <li class="nav-item">
                                                        <a class="nav-link py-1 <?= ($action == 'admin-contacts' && ($_GET['department'] ?? '') == 'KyThuat') ? 'active' : '' ?>" href="<?= BASE_URL ?>?action=admin-contacts&department=KyThuat" style="font-size: 0.85rem;">
                                                            Kỹ thuật
                                                        </a>
                                                    </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>

                    <!-- MARKETING & TIN TỨC -->
                    <?php if ($role == 1 || in_array('banners', $permissions) || in_array('discounts', $permissions ?? []) || in_array('flash_sales', $permissions ?? []) || in_array('news', $permissions)): ?>
                        <?php 
                            $marketingActive = in_array($action ?? '', ['admin-banners', 'admin-banner-form', 'admin-discounts', 'admin-flash-sales', 'admin-news']) || strpos($action ?? '', 'admin-discount') !== false || strpos($action ?? '', 'admin-flash-sale') !== false || strpos($action ?? '', 'admin-news') !== false;
                        ?>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center <?= $marketingActive ? '' : 'collapsed' ?>" data-bs-toggle="collapse" href="#collapseMarketing" role="button" aria-expanded="<?= $marketingActive ? 'true' : 'false' ?>">
                                <i class="bi bi-megaphone me-2"></i> Marketing
                                <i class="bi bi-chevron-down ms-auto menu-toggle-icon"></i>
                            </a>
                            <div class="collapse <?= $marketingActive ? 'show' : '' ?>" id="collapseMarketing">
                                <ul class="nav flex-column ms-3 mt-1" style="border-left: 2px solid var(--border-light);">
                                    <?php if ($role == 1 || in_array('banners', $permissions)): ?>
                                        <li class="nav-item">
                                            <a class="nav-link py-2 <?= in_array($action ?? '', ['admin-banners', 'admin-banner-form']) ? 'active' : '' ?>" href="<?= BASE_URL ?>?action=admin-banners">
                                                <i class="bi bi-dot"></i> Banner
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($role == 1 || in_array('discounts', $permissions ?? [])): ?>
                                        <li class="nav-item">
                                            <a class="nav-link py-2 <?= strpos($action ?? '', 'admin-discount') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>?action=admin-discounts">
                                                <i class="bi bi-dot"></i> Mã giảm giá
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($role == 1 || in_array('flash_sales', $permissions ?? [])): ?>
                                        <li class="nav-item">
                                            <a class="nav-link py-2 <?= strpos($action ?? '', 'admin-flash-sale') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>?action=admin-flash-sales">
                                                <i class="bi bi-dot"></i> Flash Sale
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($role == 1 || in_array('news', $permissions)): ?>
                                        <li class="nav-item">
                                            <a class="nav-link py-2 <?= strpos($action ?? '', 'admin-news') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>?action=admin-news">
                                                <i class="bi bi-dot"></i> Tin tức
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>

                    <!-- TÀI KHOẢN -->
                    <?php if ($role == 1): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($action ?? '') === 'admin-users' ? 'active' : '' ?>" href="<?= BASE_URL ?>?action=admin-users">
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