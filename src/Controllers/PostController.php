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

    public static function edit(Request $request): void
    {
        session_start();
        $errors = $_SESSION['errors']?? [];
        unset($_SESSION['errors']);
        $postId = $request->params['id'];
        $postRepo = new PostsRepository();
        $post = $postRepo->fetchOne($postId);
        $_SESSION['post'] = $post->toArray();
        include __DIR__ . '/../Pages/update.php';
    }

    public static function update()
    {
        session_start();
        $errors = $_SESSION['errors']?? [];
        $oldPost = $_SESSION['post']?? [];
        unset($_SESSION['errors']);
        unset($_SESSION['post']);
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $content = HTMLPurifierService::purify($_POST['content']);

        if(!$title || mb_strlen($title) < 8){
            $errors['title'] = "Title Inválido! Tamanho minimo de 8";
        }
        if(!$content || mb_strlen($content) < 2){
            $errors['content'] = "Content Muito Curto!";
        }

        if(empty($errors)){

            if($title != $oldPost['title'] && $content != $oldPost['content']){
                $post = new Post($oldPost['id'], $title, $content, null, null);
                $userRepo = new PostsRepository();
                $newPost = $userRepo->update($post);
                if ($newPost){
                    header('Location: /admin');
                    exit();
                }
            }
            $errors['title'] = "Nenhum update realizado";
            $errors['content'] = "Nenhum update realizado";
        }

        $_SESSION['errors'] = $errors;
        header("Location: /post/{$oldPost['id']}/update");
        exit();
    }

    public static function create(): void
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
        if(!$content || mb_strlen($content) < 2){
            $errors['content'] = "Content Muito Curto!";
        }

        if(empty($errors)){
            $slug = Post::generateSlug($title);
            $post = new Post(null, $title, $content, $slug, null, null);
            $userRepo = new PostsRepository();
            $newPost = $userRepo->create($post);
            if ($newPost){
                $_SESSION['post'] = $newPost->toArray();
                header('Location: /posts');
                exit();
            }
        }

        $_SESSION['errors'] = $errors;
        header('Location: /post/create');
        exit();

    }
}