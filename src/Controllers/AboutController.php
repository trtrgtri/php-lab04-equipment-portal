<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Support\Response;

class AboutController
{
    public function index(): void
    {
        Response::view('about/index', [
            'title' => 'About us:'
        ]);
    }
}