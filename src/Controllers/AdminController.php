<?php

namespace App\Controllers;

use App\Service\PostService;

class AdminController
{
    public static function index(): void
    {
        [$page, $hasNext, $hasPrev, $posts, $totalPages] = PostService::getPostsAndSetPagination(10);

        include __DIR__ . '/../Pages/admin.php';
    }
}