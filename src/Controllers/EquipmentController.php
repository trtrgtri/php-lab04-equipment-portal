<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Support\Response;

class EquipmentController
{
    public function index(): void
    {
        $equipment = $this->getEquipment();

        Response::view('equipment/index', [
            'title' => 'Equipment List',
            'equipment' => $equipment,
            'created' => ($_GET['created'] ?? '') === '1'
        ]);
    }

    public function create(): void
    {
        Response::view('equipment/create', [
            'title' => 'Create Equipment',
            'error' => null
        ]);
    }

    public function store(): void
    {
        $name     = trim($_POST['name'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $price    = (int) ($_POST['price'] ?? 0);
        $quantity = (int) ($_POST['quantity'] ?? 0);

        if ($name === '' || $category === '' || $price <= 0 || $quantity < 0) {
            Response::view('equipment/create', [
                'title' => 'Create Equipment',
                'error' => 'Please enter equipment name, category, price and quantity correctly.'
            ], 422);
        }

        Response::redirect('/equipment?created=1');
    }

    private function getEquipment(): array
    {
        return require dirname(__DIR__) . '/Data/equipment.php';
    }
}
