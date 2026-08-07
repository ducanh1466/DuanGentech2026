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
            <p>Tham gia cùng chúng tôi để trải nghiệm mua sắm công nghệ đỉnh cao.<br>Những ưu đãi độc quyền đang chờ đón bạn.</p>
        </div>
    </div>

    <!-- Right Side: Form -->
    <div class="split-auth-right">
        <div class="auth-card" style="max-width: 480px;">
            <div class="d-lg-none text-center mb-4">
                <a href="<?= BASE_URL ?>" class="text-dark text-decoration-none fw-bolder fs-1" style="letter-spacing:-1px;">
                    GENTECH<span style="color:#2563eb;">.</span>
                </a>
            </div>
            
            <h2 class="auth-title" style="font-size:2rem;">Tạo tài khoản mới</h2>
            <p class="auth-subtitle" style="margin-bottom:1.8rem;">Điền thông tin bên dưới để bắt đầu</p>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger border-0 rounded-3 mb-4 d-flex align-items-center" id="errorAlert" style="background:#fee2e2; color:#b91c1c; font-size:0.95rem; font-weight:500;">
                    <i class="bi bi-exclamation-triangle-fill me-3 fs-5"></i>
                    <div><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>?action=post-register" id="registerForm">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-floating-custom mb-3">
                            <input type="text" name="full_name" id="full_name" placeholder=" " required>
                            <label for="full_name">Họ và tên</label>
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating-custom mb-3">
                            <input type="tel" name="phone" id="phone" placeholder=" " required>
                            <label for="phone">Số điện thoại</label>
                            <i class="bi bi-telephone"></i>
                        </div>
                    </div>
                </div>
                
                <div class="form-floating-custom mb-3">
                    <input type="email" name="email" id="email" placeholder=" " required>
                    <label for="email">Địa chỉ Email</label>
                    <i class="bi bi-envelope"></i>
                </div>

                <div class="form-floating-custom mb-2">
                    <input type="password" name="password" id="password" placeholder=" " required oninput="checkStrength(this.value)">
                    <label for="password">Mật khẩu (Tối thiểu 6 ký tự)</label>
                    <i class="bi bi-shield-lock"></i>
                    <button type="button" class="btn-toggle-pass" onclick="togglePass('password', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>

                <!-- Password Strength Meter -->
                <div class="password-strength-container" id="passStrengthContainer">
                    <div class="strength-bars">
                        <div class="strength-bar" id="strBar1"></div>
                        <div class="strength-bar" id="strBar2"></div>
                        <div class="strength-bar" id="strBar3"></div>
                    </div>
                    <div class="strength-text" id="strText">Mật khẩu quá ngắn</div>
                </div>

                <div class="form-floating-custom mb-4">
                    <input type="password" name="confirm_password" id="confirm_password" placeholder=" " required>
                    <label for="confirm_password">Xác nhận mật khẩu</label>
                    <i class="bi bi-shield-check"></i>
                    <button type="button" class="btn-toggle-pass" onclick="togglePass('confirm_password', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                
                <div class="form-check mb-4 pb-2">
                    <input class="form-check-input shadow-none" type="checkbox" id="agreeTerms" required>
                    <label class="form-check-label text-secondary" for="agreeTerms" style="font-size:0.85rem; font-weight:500;">
                        Tôi đồng ý với <a href="#" class="text-decoration-none fw-semibold" style="color:#2563eb;">Điều khoản dịch vụ</a> và <a href="#" class="text-decoration-none fw-semibold" style="color:#2563eb;">Chính sách bảo mật</a>
                    </label>
                </div>
                
                <button type="submit" class="btn-auth" id="registerBtn">
                    Đăng ký tài khoản <i class="bi bi-person-plus-fill fs-5"></i>
                </button>
            </form>

            <div class="auth-divider">Hoặc đăng ký với</div>

            <button class="btn auth-social-btn w-100 d-flex align-items-center justify-content-center gap-2">
                <svg viewBox="0 0 24 24" width="22" height="22">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Google
            </button>

            <p class="text-center mt-4 mb-0" style="font-size:1rem; color: #64748b; font-weight:500;">
                Đã có tài khoản? <a href="<?= BASE_URL ?>?action=login" class="fw-bold text-decoration-none" style="color:#2563eb;">Đăng nhập</a>
            </p>
        </div>
    </div>
</section>

<script>
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

    function checkStrength(val) {
        const container = document.getElementById('passStrengthContainer');
        const b1 = document.getElementById('strBar1');
        const b2 = document.getElementById('strBar2');
        const b3 = document.getElementById('strBar3');
        const text = document.getElementById('strText');
        
        if (val.length === 0) {
            container.style.display = 'none';
            return;
        }
        
        container.style.display = 'block';
        
        let strength = 0;
        if (val.length >= 6) strength += 1;
        if (val.length >= 8 && val.match(/[A-Z]/) && val.match(/[0-9]/)) strength += 1;
        if (val.length >= 10 && val.match(/[^A-Za-z0-9]/)) strength += 1;

        b1.style.backgroundColor = strength >= 1 ? '#ef4444' : '#e2e8f0';
        b2.style.backgroundColor = strength >= 2 ? '#f59e0b' : '#e2e8f0';
        b3.style.backgroundColor = strength >= 3 ? '#22c55e' : '#e2e8f0';

        if (strength === 0) { text.textContent = 'Mật khẩu quá ngắn'; text.style.color = '#ef4444'; }
        else if (strength === 1) { text.textContent = 'Yếu'; text.style.color = '#ef4444'; b1.style.backgroundColor = '#ef4444'; }
        else if (strength === 2) { text.textContent = 'Trung bình'; text.style.color = '#f59e0b'; b1.style.backgroundColor = '#f59e0b'; }
        else if (strength === 3) { text.textContent = 'Mạnh'; text.style.color = '#22c55e'; b1.style.backgroundColor = '#22c55e'; b2.style.backgroundColor = '#22c55e'; }
    }

    document.getElementById('registerForm').addEventListener('submit', function() {
        const btn = document.getElementById('registerBtn');
        btn.classList.add('loading');
    });
</script>