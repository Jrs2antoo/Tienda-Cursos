<?php
namespace Jrs2a\TiendaCursos\Controllers;

use Jrs2a\TiendaCursos\Core\Pages;
use Jrs2a\TiendaCursos\Middleware\Middleware;
use Jrs2a\TiendaCursos\Services\CarritoService;

class CarritoController
{
    private CarritoService $carritoService;
    private Pages $pages;

    public function __construct()
    {
        $this->carritoService = new CarritoService();
        $this->pages          = new Pages();
    }

    public function index(): void
    {
        Middleware::requireLogin();
        $data = $this->carritoService->obtenerCarrito((int)$_SESSION['user_id']);
        $this->pages->render("compras/carrito", $data);
    }

    public function add(): void
    {
        Middleware::requireLogin();

        $courseId = (int)($_POST['curso_id'] ?? 0);

        if ($courseId > 0) {

            $result = $this->carritoService->agregar(
                (int)$_SESSION['user_id'],
                $courseId
            );

            if ($result === 'already_owned') {
                $_SESSION['error'] = 'Ya tienes este curso comprado.';
            }
        }

        header("Location: /tiendaCursos/carrito");
        exit;
    }

    public function eliminar(): void
    {
        Middleware::requireLogin();
        $courseId = (int)($_POST['curso_id'] ?? 0);

        if ($courseId > 0) {
            $this->carritoService->eliminar((int)$_SESSION['user_id'], $courseId);
        }

        header("Location: /tiendaCursos/carrito");
        exit;
    }

}
