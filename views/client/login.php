<section class="auth-page">
    <div class="auth-card">
        <div class="text-center mb-3">
            <a href="<?= BASE_URL ?>" class="navbar-brand-custom" style="font-size:1.8rem;">
                <i class="bi bi-cpu"></i> DGENTECH
            </a>
        </div>
        <h2 class="auth-title">Đăng nhập</h2>
        <p class="auth-subtitle">Chào mừng bạn quay trở lại!</p>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'];
            unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'];
            unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>?action=post-login">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"
                        style="background:var(--bg-secondary);border:2px solid var(--border-color);border-right:none;border-radius:var(--radius-md) 0 0 var(--radius-md);color:var(--text-muted);">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="email" class="form-control" name="email" placeholder="email@example.com" required
                        style="border-left:none;border-radius:0 var(--radius-md) var(--radius-md) 0;">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label d-flex justify-content-between">
                    <span>Mật khẩu</span>
                    <a href="#" class="text-accent" style="font-size:0.85rem;">Quên mật khẩu?</a>
                </label>
                <div class="input-group">
                    <span class="input-group-text"
                        style="background:var(--bg-secondary);border:2px solid var(--border-color);border-right:none;border-radius:var(--radius-md) 0 0 var(--radius-md);color:var(--text-muted);">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" class="form-control" name="password" placeholder="••••••••" required
                        style="border-left:none;border-radius:0 var(--radius-md) var(--radius-md) 0;">
                </div>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="rememberMe">
                <label class="form-check-label text-secondary" for="rememberMe" style="font-size:0.9rem;">Ghi nhớ đăng
                    nhập</label>
            </div>
            <button type="submit" class="btn btn-accent btn-auth">
                <i class="bi bi-box-arrow-in-right me-1"></i> Đăng nhập
            </button>
        </form>

        <div class="auth-divider">hoặc</div>

        <button class="btn btn-outline-secondary w-100 rounded-pill py-2 mb-2" style="font-size:0.9rem;">
            <svg viewBox="0 0 24 24" width="18" height="18" class="me-2">
                <path fill="#4285F4"
                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" />
                <path fill="#34A853"
                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                <path fill="#FBBC05"
                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                <path fill="#EA4335"
                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
            </svg>
            Đăng nhập với Google
        </button>

        <p class="text-center mt-3" style="font-size:0.9rem;">
            Chưa có tài khoản? <a href="<?= BASE_URL ?>?action=register" class="fw-bold text-gradient">Đăng ký ngay</a>
        </p>
    </div>
</section>