<?php

namespace App\Controllers;

class AdminController
{
    public static function index(): void
    {
        include __DIR__ . '/../Pages/admin.php';
    }
}