<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Support\Response;

class ContactController
{
    public function index(): void
    {
        Response::view('contact', ['title' => 'Contact']);
    }
}
