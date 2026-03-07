<?php

namespace App\Controllers;

use App\Domain\Models\Post;
use App\Domain\Models\User;
use App\Domain\Repositories\PostsRepository;
use App\Service\HTMLPurifierService;
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

    public static function delete()
    {
    }

    public static function edit()
    {
    }

    public static function update()
    {

    }

    public static function create()
    {
        session_start();
        $errors = $_SESSION['errors']?? [];
        unset($_SESSION['errors']);
        include __DIR__ . '/../Pages/create.php';
    }

    public static function store()
    {
        session_start();
        $errors = $_SESSION['errors']?? [];
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $content = HTMLPurifierService::purify($_POST['content']);

        if(!$title || mb_strlen($title) < 8){
            $errors['title'] = "Title Inválido! Tamanho minimo de 8";
        }
        if(!$content || mb_strlen($title) < 2){
            $errors['content'] = "Content Muito Curto!";
        }

        if(empty($errors)){
            $post = new Post(null, $title, $content, null, null);
            $userRepo = new PostsRepository();
            $newPost = $userRepo->create($post);
            var_dump($newPost);
        }
    }
}