<?php
namespace Jrs2a\TiendaCursos\Middleware;

class Middleware
{
    public static function requireLogin(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /tiendaCursos/login");
            exit;
        }
    }

    public static function requireAdmin(): void
    {
        self::requireLogin();

        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: /tiendaCursos/");
            exit;
        }
    }
}
