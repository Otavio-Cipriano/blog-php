<?php

namespace App\Controllers;

use App\Repositories\PostsRepository;
use App\Service\PostService;

class AdminController
{
    private static function initSession(): void
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
    }
    public static function index(): void
    {
        self::initSession();
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit();
        }

        [$page, $hasNext, $hasPrev, $posts, $totalPages] = PostService::getPostsAndSetPagination(10);

        include __DIR__ . '/../Pages/admin.php';
    }
    
    public static function updatePost()
    {
        include __DIR__ . '/../Pages/update.php';
    }

    public static function createPost()
    {
        include __DIR__ . '/../Pages/create.php';
    }
}