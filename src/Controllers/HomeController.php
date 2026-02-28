<?php

namespace App\Controllers;

use App\Repositories\PostsRepository;

class HomeController
{
    public static function index():void
    {
        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT) ?? 1;
        $page = max(1, (int) $page); //Impedir que pagian seja menor que 1
        $limit = 10;
        $postsRepo = new PostsRepository();
        $numberPosts = $postsRepo->getNumberPosts();
        $totalPages = (int) ceil($numberPosts / $limit);
        $page = min($page, $totalPages > 0 ? $totalPages : 1); //Impedir página maior que o total
        $offset = ($page - 1) * $limit;
        $hasNext = $page < $totalPages;
        $hasPrev = $page > 1;

        $posts = $postsRepo->fetchMany($limit, $offset);
        include __DIR__ . '/../Pages/home.php';
    }
}