<?php

declare(strict_types=1);

namespace App\Support;

class Response
{
    public static function view(string $view, array $data = [], int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: text/html; charset=UTF-8');

        // Giải nén mảng data thành các biến riêng biệt để dùng trong View
        extract($data, EXTR_SKIP);

        // Đường dẫn tới view con (ví dụ: views/equipment/create.php)
        $viewPath = dirname(__DIR__, 2) . '/views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            self::notFound('View not found: ' . $view);
        }

        // BẮT BỘC LÀM Ở LAB 04:
        // Nạp layout chung. Bên trong layout.php sẽ có lệnh `require $viewPath;` để nhúng nội dung trang con vào.
        require dirname(__DIR__, 2) . '/views/layout.php';
        exit;
    }

    public static function json(int $status, array $data): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=UTF-8');

        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    public static function redirect(string $url, int $status = 302): void
    {
        http_response_code($status);
        header('Location: ' . $url);
        exit;
    }

    public static function text(int $status, string $message): void
    {
        http_response_code($status);
        header('Content-Type: text/plain; charset=UTF-8');

        echo $message;
        exit;
    }

    public static function notFound(string $message = '404 Not Found'): void
    {
        self::text(404, $message);
    }

    public static function methodNotAllowed(array $allowedMethods = []): void
    {
        if (!empty($allowedMethods)) {
            header('Allow: ' . implode(', ', $allowedMethods));
        }

        self::text(405, '405 Method Not Allowed');
    }
}
