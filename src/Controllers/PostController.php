<?php

namespace App\Controllers;

use App\Repositories\PostsRepository;

class PostController
{
    public static function index(int $postId): void
    {
        $postRepo = new PostsRepository();
        $post = $postRepo->fetchOne($postId);
        include __DIR__ . '/../Pages/post.php';
    }
}