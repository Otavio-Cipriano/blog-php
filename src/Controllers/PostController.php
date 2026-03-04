<?php

namespace App\Controllers;

use App\Repositories\PostsRepository;
use Core\Http\Request;
use Core\Http\Response;

class PostController
{
    public static function index(Request $request, Response $response): void
    {
        $postId = $request->params['id'];
        $postRepo = new PostsRepository();
        $post = $postRepo->fetchOne($postId);
        include __DIR__ . '/../Pages/post.php';
    }

    public static function deletePost()
    {
    }

    public static function updatePost()
    {
    }

    public static function createPost()
    {

    }
}