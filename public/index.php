<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\HealthController;
use App\Controllers\HomeController;
use App\Controllers\EquipmentController;
use App\Controllers\DashboardController; // Thêm controller này
use App\Core\Router;
use App\Controllers\AboutController;
use App\Controllers\Api\EquipmentApiController;
use App\Controllers\ContactController;

require_once dirname(__DIR__) . '/vendor/autoload.php';

// =============== BẮT ĐẦU LAB 04: CẤU HÌNH SESSION ===============
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');

session_name('LAB04SESSID');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => $isHttps,
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

// Chạy middleware bảo vệ và kiểm tra timeout
check_session_timeout();
check_session_context();
// =============== KẾT THÚC CẤU HÌNH SESSION ===============

if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $file = __DIR__ . $path;

    if ($path !== '/' && is_file($file)) {
        return false;
    }
}

$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/go-home', [HomeController::class, 'goHome']);

$router->get('/health', [HealthController::class, 'index']);

$router->get('/equipment', [EquipmentController::class, 'index']);
$router->get('/equipment/create', [EquipmentController::class, 'create']);
$router->post('/equipment', [EquipmentController::class, 'store']);

$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'handleLogin']);
$router->post('/logout', [AuthController::class, 'logout']); // Lab04: Bắt buộc đổi sang POST

// Lab04: Route cho khu vực yêu cầu đăng nhập
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/session-demo', [DashboardController::class, 'sessionDemo']);

$router->get('/about', [AboutController::class, 'index']);
$router->get('/api/equipment', [EquipmentApiController::class, 'index']);
$router->get('/contact', [ContactController::class, 'index']);

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

$router->dispatch($method, $path);
