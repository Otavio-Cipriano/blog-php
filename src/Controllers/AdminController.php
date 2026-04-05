<?php

namespace App\Controllers;

use App\Service\PostService;

class AdminController
{
    public static function index(): void
    {
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        if(empty($_SESSION['user'])){
            header('Location: /login');
        }

        [$page, $hasNext, $hasPrev, $posts, $totalPages] = PostService::getPostsAndSetPagination(10);

        include __DIR__ . '/../Pages/admin.php';
    }
}