<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\HealthController;
use App\Controllers\HomeController;
use App\Controllers\EquipmentController;
use App\Core\Router;
use App\Controllers\AboutController;
use App\Controllers\Api\EquipmentApiController;
use App\Controllers\ContactController;


require_once dirname(__DIR__) . '/vendor/autoload.php';

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
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/about', [AboutController::class, 'index']);
$router->get('/api/equipment', [EquipmentApiController::class, 'index']);
$router->get('/contact', [ContactController::class, 'index']);

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

$router->dispatch($method, $path);
