<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Jrs2a\TiendaCursos\Core\Database;
use Jrs2a\TiendaCursos\Core\Router;

//.env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

session_start();

$router = new Router();
require __DIR__ . '/../config/routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = '/tiendaCursos';
$basePath = rtrim($basePath, '/');
$uri = substr($uri, strlen($basePath));

if ($uri === '' || $uri === false) {
    $uri = '/';
}
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($uri, $method);