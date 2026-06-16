<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Support\Response;

class DashboardController
{
    public function index(): void
    {
        // Chốt chặn bảo mật: Chưa đăng nhập thì đá văng ra ngoài trang Login
        require_login();

        // Chuẩn bị dữ liệu từ Session để đẩy ra View
        $data = [
            'title' => 'Dashboard',
            'userName' => $_SESSION['user_name'] ?? 'Người dùng',
            'role' => $_SESSION['role'] ?? 'N/A',
            'loginAt' => date('Y-m-d H:i:s', $_SESSION['login_at'] ?? time()),
            'lastActivity' => date('Y-m-d H:i:s', $_SESSION['last_activity_at'] ?? time()),
        ];

        Response::view('dashboard', $data);
    }

    public function sessionDemo(): void
    {
        // Trang này dùng để test/debug xem Session đang chứa những gì
        require_login();

        $sessionData = [
            'user_id' => $_SESSION['user_id'] ?? null,
            'user_name' => $_SESSION['user_name'] ?? null,
            'role' => $_SESSION['role'] ?? null,
            'login_at' => date('Y-m-d H:i:s', $_SESSION['login_at'] ?? time()),
            'last_activity_at' => date('Y-m-d H:i:s', $_SESSION['last_activity_at'] ?? time()),
            'session_name' => session_name(),
        ];

        // Dùng helper Response::json đã có sẵn từ Lab 03
        Response::json(200, $sessionData);
    }
}
