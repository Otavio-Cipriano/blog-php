<?php

namespace App\Controllers;

use App\Service\PostService;
use Core\Http\Request;
use Core\Http\Response;

class HomeController
{
    public static function index(Request $request, Response $response):void
    {
        [$page, $hasNext, $hasPrev, $posts, $totalPages] = PostService::getPostsAndSetPagination(10);

        include __DIR__ . '/../Pages/home.php';
    }
}