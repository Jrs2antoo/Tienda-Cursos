<?php
namespace Jrs2a\TiendaCursos\Services;

use Jrs2a\TiendaCursos\Repositories\UsuarioRepository;
use Jrs2a\TiendaCursos\Core\Email;

class CheckoutService
{
    private CarritoService    $carritoService;
    private CompraService     $compraService;
    private UsuarioRepository $usuarioRepository;

    public function __construct()
    {
        $this->carritoService    = new CarritoService();
        $this->compraService     = new CompraService();
        $this->usuarioRepository = new UsuarioRepository();
    }

    private function getAccessToken(): string
    {
        $clientId = $_ENV['PAYPAL_CLIENT_ID'];
        $secret   = $_ENV['PAYPAL_SECRET'];

        $ch = curl_init('https://api-m.sandbox.paypal.com/v1/oauth2/token');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD        => "$clientId:$secret",
            CURLOPT_POSTFIELDS     => 'grant_type=client_credentials',
        ]);
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return $response['access_token'];
    }

    public function crearOrdenPaypal(float $total): ?string
    {
        $token = $this->getAccessToken();

        $order = [
            'intent'          => 'CAPTURE',
            'purchase_units'  => [[
                'amount'      => ['currency_code' => 'EUR', 'value' => number_format($total, 2, '.', '')],
                'description' => 'Compra de cursos en TiendaCursos',
            ]],
            'application_context' => [
                'return_url' => 'http://localhost/tiendaCursos/checkout/exito',
                'cancel_url' => 'http://localhost/tiendaCursos/checkout/cancelado',
                'brand_name' => 'TiendaCursos',
                'user_action' => 'PAY_NOW',
            ],
        ];

        $ch = curl_init('https://api-m.sandbox.paypal.com/v2/checkout/orders');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json', "Authorization: Bearer $token"],
            CURLOPT_POSTFIELDS     => json_encode($order),
        ]);
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        foreach ($response['links'] ?? [] as $link) {
            if ($link['rel'] === 'approve') {
                return $link['href'];
            }
        }

        return null;
    }

    public function capturarPago(string $orderId): bool
    {
        $token = $this->getAccessToken();

        $ch = curl_init("https://api-m.sandbox.paypal.com/v2/checkout/orders/$orderId/capture");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json', "Authorization: Bearer $token"],
        ]);
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return ($response['status'] ?? '') === 'COMPLETED';
    }
    /**
     * Finaliza el proceso de compra tras un pago exitoso:
     * 1. Registra cada curso del carrito como comprado por el usuario.
     * 2. Vacía el carrito.
     * 3. Genera y envía la factura en PDF por email.
     *
     * El envío del email está en un try/catch aislado: si falla,
     * las compras ya quedan registradas y no se interrumpe el flujo.
     *
     * @param int $userId ID del usuario que completó el pago
     */
    public function completarCompra(int $userId): void
    {
        // 1. Obtener cursos del carrito ANTES de vaciarlo
        $carrito   = $this->carritoService->obtenerCarrito($userId);
        $cursos    = $carrito['courses'];   // array de objetos Curso
        $courseIds = array_map(fn($c) => $c->id, $cursos);

        // 2. Registrar compras (igual que antes)
        foreach ($courseIds as $courseId) {
            $this->compraService->asignar($userId, $courseId);
        }

        // 3. Vaciar carrito (igual que antes)
        $this->carritoService->vaciar($userId);

        // 4. Enviar email de agradecimiento (no interrumpe el flujo si falla)
        try {
            $usuario = $this->usuarioRepository->findById($userId);

            if ($usuario && !empty($cursos)) {
                $email = new Email($usuario->email, $usuario->fullName);
                $email->enviarCompra($cursos);
            }
        } catch (\Throwable $e) {
            error_log('Error enviando email de compra: ' . $e->getMessage());
        }
    }
}