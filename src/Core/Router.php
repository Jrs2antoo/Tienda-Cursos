<?php
namespace Jrs2a\TiendaCursos\Core;

class Router {
    /**
     * @var array<string, array<string, callable|array{0: class-string, 1: string}>>
     */
    protected $routes = [];

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    public function dispatch($uri, $method) {
        $callback = $this->routes[$method][$uri] ?? null;

        if (!$callback) {
            echo "404 Not Found";
            return;
        }

        if (is_array($callback)) {
            [$controller, $action] = $callback;
            $controllerInstance = new $controller();
            $controllerInstance->$action();
        } else {
            call_user_func($callback);
        }
    }
}