<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Support\Response;

class AuthController
{
    private array $users;

    public function __construct()
    {
        // Khởi tạo tài khoản demo trực tiếp trong code (không dùng DB)
        // Tài khoản: student@example.com / 123456
        $this->users = [
            'student@example.com' => [
                'id' => 1,
                'name' => 'Sinh viên Mượn thiết bị',
                'role' => 'student',
                'password_hash' => password_hash('123456', PASSWORD_DEFAULT),
            ],
        ];
    }

    public function login(): void
    {
        // Đã đăng nhập rồi thì đá thẳng vào dashboard
        if (is_logged_in()) {
            redirect('/dashboard');
        }

        // Đọc dữ liệu cũ và lỗi từ session flash (nếu đăng nhập sai trước đó)
        Response::view('auth/login', [
            'title' => 'Đăng nhập hệ thống',
            'old' => flash_get('old', []),
            'errors' => flash_get('errors', []),
        ]);
    }

    public function handleLogin(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = ($_POST['remember_me'] ?? '') === '1';

        $errors = [];

        if ($email === '') {
            $errors['email'] = 'Vui lòng nhập email.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không đúng định dạng.';
        }

        if ($password === '') {
            $errors['password'] = 'Vui lòng nhập password.';
        }

        // Kiểm tra user có tồn tại và khớp mật khẩu không
        $user = $this->users[$email] ?? null;
        if (empty($errors) && (!$user || !password_verify($password, $user['password_hash']))) {
            $errors['password'] = 'Email hoặc password không đúng.';
        }

        // Nếu có lỗi -> Trả về form đăng nhập kèm thông báo (PRG)
        if (!empty($errors)) {
            flash_set('errors', $errors);
            flash_set('old', ['email' => $email]);
            redirect('/login');
        }

        // ==========================================
        // BẢO MẬT CỐT LÕI: Chống Session Fixation
        // ==========================================
        session_regenerate_id(true);

        // Lưu thông tin người dùng vào Session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['login_at'] = time();
        $_SESSION['last_activity_at'] = time();
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? '';

        if ($remember) {
            flash_set('success', 'Đăng nhập thành công. (Remember me cần token riêng; Lab 04 không lưu password trong cookie).');
        } else {
            flash_set('success', 'Đăng nhập thành công. Session ID đã được regenerate an toàn.');
        }

        redirect('/dashboard');
    }

    public function logout(): void
    {
        // 1. Dọn dẹp sạch sẽ (Hàm nằm trong helpers.php)
        logout_clean();

        // 2. Mở lại một phiên tạm thời chỉ để chứa câu thông báo flash
        session_start();
        session_regenerate_id(true);
        flash_set('success', 'Đăng xuất thành công. Toàn bộ dữ liệu phiên cũ đã bị tiêu hủy.');

        // 3. Redirect về trang login
        redirect('/login');
    }
}
