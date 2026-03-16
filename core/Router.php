<?php

namespace Core;

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\PostController;
use Core\Http\Request;
use Core\Http\Response;

//$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//$method = $_SERVER['REQUEST_METHOD'];


class Router
{
    public array $routes;
    private array $middlewares;

    private Request $request;
    private Response $response;

    private array $params;

    public function __construct(Request $request, Response $response)
    {
        $this->response = $response;
        $this->request = $request;
    }

    /**
     * received method from request
     * @param string $requestMethod
     * @param string $path
     * @param string $controller
     * controller from method
     * @param string $method
     * @return void
     */
    public function setRoute(string $requestMethod, string $path, array $controllerAndMethod)
    {
        $path = trim($path, '/');
        $this->routes[] = [
            'method' => $requestMethod,
            'path' => $path,
            'action' => $controllerAndMethod
        ];
    }

    public function setMiddleware(array $paths, array $controllerAndMethod)
    {
        $paths = array_map(fn ($path) => trim($path, '/'), $paths);
        $this->middlewares[] = [
            'paths' => $paths,
            'action' => $controllerAndMethod
        ];
    }

    public function run(): void
    {
        foreach ($this->routes as $route) {

            if ($route['method'] !== $this->request->httpMethod) {
                continue;
            }

            if ($this->match($route['path'], $this->request->path, $params)) {

                $this->checkMiddlewares($route['path']);
                $this->request->setParams($params);

                [$controller, $action] = $route['action'];

                $controller::$action($this->request, $this->response);

                return;
            }
        }

        echo "404 Page not found";
    }

    public function checkMiddlewares($path): void
    {
        foreach ($this->middlewares as $middleware) {
            if (in_array($path, $middleware['paths'])){
                [$middle, $action] = $middleware['action'];

                $middle::$action($this->request, $this->response);
            }
        }
    }

    private function match(string $routePath, string $requestPath, ?array &$params = []): bool
    {
        $routePath = trim($routePath, '/');
        $requestPath = trim($requestPath, '/');

        preg_match_all('/\{(\w+)(?::([^}]+))?}/', $routePath, $paramInfo);

        $pattern = preg_replace_callback(
            '/\{(\w+)(?::([^}]+))?}/',
            function ($matches) {
                return '(' . ($matches[2] ?? '[^/]+') . ')';
            },
            $routePath
        );

        $pattern = '#^' . $pattern . '$#';

        if (preg_match($pattern, $requestPath, $matches)) {
            array_shift($matches);
            $params = array_combine($paramInfo[1], $matches) ?? [];
            return true;
        }

        return false;
    }
}