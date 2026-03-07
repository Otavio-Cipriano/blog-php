<?php

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\PostController;
use Core\Router;
use Core\Http\Request;
use Core\Http\Response;


[$request, $response] = [new Request(), new Response()];
$router = new Router($request, $response);
$router->setRoute('GET', '/', [HomeController::class, 'index']);
$router->setRoute('GET', '/post/{id:\d+}', [PostController::class, 'index']);
$router->setRoute('GET', '/admin', [AdminController::class, 'index']);
$router->setRoute('GET', '/login', [AuthController::class, 'login']);
$router->setRoute('GET', '/logout', [AuthController::class, 'logout']);
$router->setRoute('POST', '/login', [AuthController::class, 'authenticate']);
$router->setRoute('GET', '/post/create', [PostController::class, 'create'] );
$router->setRoute('POST', '/post/create', [PostController::class, 'store']);
$router->run();