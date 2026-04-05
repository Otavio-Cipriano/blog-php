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
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        if(empty($_SESSION['user'])){
            header('Location: /login');
        }
        $slug = $request->params['slug'];
        $postRepo = new PostsRepository();

        if(!$postRepo->checkIfExistsBySlug($slug)){
            header('Location: /notfound');
            exit();
        }

        $post = $postRepo->fetchOne($slug);
        include __DIR__ . '/../Pages/post.php';
    }

    public static function edit(Request $request): void
    {
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        if(empty($_SESSION['user'])){
            header('Location: /login');
        }
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);
        $slug = $request->params['slug'];
        $postRepo = new PostsRepository();
        $post = $postRepo->fetchOne($slug);
        $_SESSION['post'] = $post->toArray();
        include __DIR__ . '/../Pages/update.php';
    }

    public static function update()
    {
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        if(empty($_SESSION['user'])){
            header('Location: /login');
        }
        $errors = $_SESSION['errors'] ?? [];
        $oldPost = $_SESSION['post'] ?? [];
        unset($_SESSION['errors']);
        unset($_SESSION['post']);
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $content = HTMLPurifierService::purify($_POST['content']);

        if (!$title || mb_strlen($title) < 8) {
            $errors['title'] = "Title Inválido! Tamanho minimo de 8";
        }
        if (!$content || mb_strlen($content) < 2) {
            $errors['content'] = "Content Muito Curto!";
        }

        if (empty($errors)) {

            if ($title != $oldPost['title'] || $content != $oldPost['content']) {
                $slug = Post::generateSlug($title);
                $post = new Post($oldPost['id'], $title, $content, $slug, null, null);
                $postRepo = new PostsRepository();

                if ($postRepo->checkIfExistsBySlug($slug)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: /new');
                    exit();
                }

                $newPost = $postRepo->update($post);
                if ($newPost) {
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

    public static function store()
    {
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        if(empty($_SESSION['user'])){
            header('Location: /login');
        }
        $errors = $_SESSION['errors'] ?? [];
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $content = HTMLPurifierService::purify($_POST['content']);

        if (!$title || mb_strlen($title) < 8) {
            $errors['title'] = "Title Inválido! Tamanho minimo de 8";
        }
        if (!(strip_tags($content)) || mb_strlen($content) < 10) {
            $errors['content'] = "Content Muito Curto!";
        }

        if (empty($errors)) {
            $slug = Post::generateSlug($title);
            $postRepo = new PostsRepository();

            $post = new Post(null, $title, $content, $slug, null, null);

            if($postRepo->checkIfExistsBySlug($slug)){
                $errors['title'] = "Já existe post com este titulo";
                $_SESSION['errors'] = $errors;
                header('Location: /new');
                exit();
            }

            $newPost = $postRepo->create($post);

            if ($newPost) {
                $_SESSION['post'] = $newPost->toArray();
                header('Location: /admin');
                exit();
            }
        }

        $_SESSION['errors'] = $errors;
        header('Location: /new');
        exit();

    }

    public static function create(): void
    {
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        if(empty($_SESSION['user'])){
            header('Location: /login');
        }
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);
        include __DIR__ . '/../Pages/create.php';
    }

    public static function delete(Request $request): void
    {
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        if(empty($_SESSION['user'])){
            header('Location: /login');
        }
        $slug = $request->params['slug'];
        $postRepo = new PostsRepository();
        $postRepo->delete($slug);
        header('Location: /admin');
        exit();
    }
}