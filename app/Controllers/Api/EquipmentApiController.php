<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Support\Response;

class EquipmentApiController
{
    /**
     * Xử lý GET /api/equipment
     */
    public function index(): void
    {
        $equipment = $this->getEquipment();
        Response::json(200, $equipment);
    }

    private function getEquipment(): array
    {
        return require dirname(__DIR__, 3) . '/src/Data/equipment.php';
    }
}
