<?php
namespace Jrs2a\TiendaCursos\Controllers;

use Jrs2a\TiendaCursos\Core\Pages;
use Jrs2a\TiendaCursos\Services\CarritoService;
use Jrs2a\TiendaCursos\Services\CheckoutService;

class CheckoutController
{
    private CheckoutService $checkoutService;
    private CarritoService $carritoService;
    private Pages $pages;

    public function __construct()
    {
        $this->checkoutService = new CheckoutService();
        $this->carritoService  = new CarritoService();
        $this->pages           = new Pages();
    }

    private function requireLogin(): void
    {
        if (empty($_SESSION['user_id'])) {
            header("Location: /tiendaCursos/login");
            exit;
        }
    }

    public function index(): void
    {
        $this->requireLogin();
        $data = $this->carritoService->obtenerCarrito((int)$_SESSION['user_id']);
        $this->pages->render("compras/checkout", array_merge($data, ['title' => 'Finalizar compra']));
    }

    public function pagar(): void
    {
        $this->requireLogin();
        $data = $this->carritoService->obtenerCarrito((int)$_SESSION['user_id']);

        if (empty($data['courses'])) {
            header("Location: /tiendaCursos/carrito");
            exit;
        }

        $approveUrl = $this->checkoutService->crearOrdenPaypal($data['total']);

        if ($approveUrl) {
            header("Location: $approveUrl");
        } else {
            header("Location: /tiendaCursos/checkout/cancelado");
        }
        exit;
    }

    public function exito(): void
    {
        $this->requireLogin();
        $orderId = $_GET['token'] ?? null;

        if (!$orderId) {
            header("Location: /tiendaCursos/");
            exit;
        }

        if ($this->checkoutService->capturarPago($orderId)) {
            $this->checkoutService->completarCompra((int)$_SESSION['user_id']);
            $this->pages->render("compras/exito", ['title' => 'Pago completado']);
            return;
        }

        header("Location: /tiendaCursos/checkout/cancelado");
        exit;
    }

    public function cancelado(): void
    {
        $this->pages->render("compras/cancelado", ['title' => 'Pago cancelado']);
    }
}
