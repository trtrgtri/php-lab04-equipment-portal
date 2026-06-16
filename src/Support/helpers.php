<?php

// 1. Chống XSS (Cross-Site Scripting)
function h(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

// 2. Hàm điều hướng (Dùng cho PRG)
function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

// 3. Set Flash Message (Lưu thông báo tạm thời vào session)
function flash_set(string $key, mixed $value): void
{
    $_SESSION['_flash'][$key] = $value;
}

// 4. Get Flash Message (Đọc xong xóa ngay để không hiện mãi)
function flash_get(string $key, mixed $default = null): mixed
{
    $value = $_SESSION['_flash'][$key] ?? $default;
    unset($_SESSION['_flash'][$key]);
    return $value;
}

// 5. Kiểm tra trạng thái đăng nhập
function is_logged_in(): bool
{
    return isset($_SESSION['user_id']);
}

// 6. Middleware bảo vệ các trang yêu cầu đăng nhập (Dashboard)
function require_login(): void
{
    if (!is_logged_in()) {
        flash_set('error', 'Vui lòng đăng nhập để truy cập trang này.');
        redirect('/login');
    }
}

// 7. Kiểm tra Timeout (15 phút nhàn rỗi)
function check_session_timeout(): void
{
    $idleLimit = 15 * 60; // 15 phút

    if (!isset($_SESSION['user_id'])) {
        return;
    }

    $last = $_SESSION['last_activity_at'] ?? time();
    if (time() - $last > $idleLimit) {
        logout_clean();
        session_start();
        flash_set('error', 'Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.');
        redirect('/login');
    }

    $_SESSION['last_activity_at'] = time();
}

// 8. Chống Session Hijacking cơ bản (Kiểm tra User-Agent)
function check_session_context(): void
{
    if (!isset($_SESSION['user_id'])) {
        return;
    }

    $currentAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $savedAgent = $_SESSION['user_agent'] ?? '';

    if ($savedAgent !== '' && $savedAgent !== $currentAgent) {
        logout_clean();
        session_start();
        flash_set('error', 'Phiên có dấu hiệu bất thường. Vui lòng đăng nhập lại.');
        redirect('/login');
    }
}

// 9. Đăng xuất sạch (Xóa data, hủy cookie, tiêu diệt session)
function logout_clean(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();
}
