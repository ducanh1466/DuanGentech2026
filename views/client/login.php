<section class="split-auth-container">
    <!-- Left Side: Visuals & Slideshow -->
    <div class="split-auth-left">
        <div class="slideshow">
            <div class="slide"></div>
            <div class="slide"></div>
            <div class="slide"></div>
        </div>
        <div class="overlay"></div>
        <div class="content">
            <h1>GENTECH.</h1>
            <p>Trải nghiệm hệ sinh thái công nghệ đỉnh cao.<br>Khám phá giới hạn vô tận của tương lai ngay hôm nay.</p>
        </div>
    </div>

    <!-- Right Side: Form -->
    <div class="split-auth-right">
        <div class="auth-card">
            <div class="d-lg-none text-center mb-5">
                <a href="<?= BASE_URL ?>" class="text-dark text-decoration-none fw-bolder fs-1" style="letter-spacing:-1px;">
                    GENTECH<span style="color:#2563eb;">.</span>
                </a>
            </div>
            
            <h2 class="auth-title">GENTECH xin chào !</h2>
            <p class="auth-subtitle">Đăng nhập tài khoản để tiếp tục mua sắm</p>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger border-0 rounded-3 mb-4 d-flex align-items-center" id="errorAlert" style="background:#fee2e2; color:#b91c1c; font-size:0.95rem; font-weight:500;">
                    <i class="bi bi-exclamation-triangle-fill me-3 fs-5"></i>
                    <div><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success border-0 rounded-3 mb-4 d-flex align-items-center" style="background:#dcfce3; color:#15803d; font-size:0.95rem; font-weight:500;">
                    <i class="bi bi-check-circle-fill me-3 fs-5"></i>
                    <div><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>?action=post-login" id="loginForm">
                
                <div class="form-floating-custom">
                    <input type="email" name="email" id="email" placeholder=" " required>
                    <label for="email">Địa chỉ Email</label>
                    <i class="bi bi-envelope"></i>
                </div>
                
                <div class="form-floating-custom mb-3">
                    <input type="password" name="password" id="password" placeholder=" " required>
                    <label for="password">Mật khẩu</label>
                    <i class="bi bi-shield-lock"></i>
                    <button type="button" class="btn-toggle-pass" onclick="togglePass('password', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 pb-2">
                    <div class="form-check">
                        <input class="form-check-input shadow-none" type="checkbox" id="rememberMe">
                        <label class="form-check-label text-secondary" for="rememberMe" style="font-size:0.9rem; font-weight:500; cursor:pointer;">
                            Ghi nhớ tài khoản
                        </label>
                    </div>
                    <a href="#" class="text-decoration-none fw-semibold" style="color:#2563eb; font-size:0.9rem;">Quên mật khẩu?</a>
                </div>
                
                <button type="submit" class="btn-auth" id="loginBtn">
                    Đăng nhập <i class="bi bi-arrow-right-short fs-4"></i>
                </button>
            </form>

            <div class="auth-divider">Hoặc đăng nhập với</div>

            <button class="btn auth-social-btn w-100 d-flex align-items-center justify-content-center gap-2">
                <svg viewBox="0 0 24 24" width="22" height="22">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Google
            </button>

            <p class="text-center mt-5 mb-0" style="font-size:1rem; color: #64748b; font-weight:500;">
                Chưa có tài khoản? <a href="<?= BASE_URL ?>?action=register" class="fw-bold text-decoration-none" style="color:#2563eb;">Đăng ký ngay</a>
            </p>
        </div>
    </div>
</section>

<script>
    // Toggle Password Visibility
    function togglePass(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }

    // Loading Button effect
    document.getElementById('loginForm').addEventListener('submit', function() {
        const btn = document.getElementById('loginBtn');
        btn.classList.add('loading');
    });
</script>