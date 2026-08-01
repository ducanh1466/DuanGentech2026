<?php

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if (isset($_SESSION['user'])) {
            header('Location: ' . ($_SESSION['user']['role'] == 1 ? BASE_URL . '?action=admin' : BASE_URL));
            exit;
        }

        $title = 'Đăng nhập - DGENTECH';
        $view = 'client/login';
        require_once PATH_VIEW_MAIN;
    }

    public function postLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->getUserByEmail($email);

            if ($user) {
                if ($user['status'] == 0) {
                    $_SESSION['error'] = 'Tài khoản của bạn đã bị khóa!';
                } elseif (password_verify($password, $user['password'])) {
                    unset($_SESSION['login_attempts'][$email]);
                    $_SESSION['user'] = $user;
                    if ($user['role'] == 1) {
                        header('Location: ' . BASE_URL . '?action=admin');
                    } else {
                        header('Location: ' . BASE_URL);
                    }
                    exit;
                } else {
                    if (!isset($_SESSION['login_attempts'][$email])) {
                        $_SESSION['login_attempts'][$email] = 1;
                    } else {
                        $_SESSION['login_attempts'][$email]++;
                    }

                    if ($_SESSION['login_attempts'][$email] >= 5) {
                        $this->userModel->changeStatus($user['user_id'], 0);
                        $_SESSION['error'] = 'Tài khoản của bạn đã bị khóa do nhập sai mật khẩu quá 5 lần!';
                        unset($_SESSION['login_attempts'][$email]);
                    } else {
                        $remaining = 5 - $_SESSION['login_attempts'][$email];
                        $_SESSION['error'] = "Mật khẩu không chính xác! Bạn còn $remaining lần thử.";
                    }
                }
            } else {
                $_SESSION['error'] = 'Email hoặc mật khẩu không chính xác!';
            }
        }
        
        header('Location: ' . BASE_URL . '?action=login');
        exit;
    }

    public function register()
    {
        if (isset($_SESSION['user'])) {
            header('Location: ' . ($_SESSION['user']['role'] == 1 ? BASE_URL . '?action=admin' : BASE_URL));
            exit;
        }

        $title = 'Đăng ký - DGENTECH';
        $view = 'client/register';
        require_once PATH_VIEW_MAIN;
    }

    public function postRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = $_POST['full_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($full_name) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin!';
            } elseif ($password !== $confirm_password) {
                $_SESSION['error'] = 'Mật khẩu xác nhận không khớp!';
            } else {
                $existingUser = $this->userModel->getUserByEmail($email);
                if ($existingUser) {
                    $_SESSION['error'] = 'Email đã được sử dụng!';
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $result = $this->userModel->insertUser($full_name, $email, $hashed_password, $phone, '', 0, 1);
                    if ($result) {
                        $_SESSION['success'] = 'Đăng ký thành công! Bạn có thể đăng nhập.';
                        header('Location: ' . BASE_URL . '?action=login');
                        exit;
                    } else {
                        $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại!';
                    }
                }
            }
        }
        
        header('Location: ' . BASE_URL . '?action=register');
        exit;
    }

    public function logout()
    {
        unset($_SESSION['user']);
        header('Location: ' . BASE_URL);
        exit;
    }
}
