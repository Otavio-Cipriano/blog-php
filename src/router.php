<?php

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\PostController;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


switch ($path){
    case '/':
        HomeController::index();
        break;
    case str_starts_with($path, '/post'):
        $postID = (int) str_replace('/post/', '', $path);
        PostController::index($postID);
        break;
    case '/admin':
        AuthController::auth();
        AdminController::index();
        break;
    case '/login':
        AuthController::login();
        break;
    default:
        echo "Essa página não existe";
}
