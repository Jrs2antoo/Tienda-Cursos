<?php
namespace Jrs2a\TiendaCursos\Services;

use Jrs2a\TiendaCursos\Services\CarritoService;
use Jrs2a\TiendaCursos\Services\CompraService;

class CheckoutService
{
    private CarritoService $carritoService;
    private CompraService  $compraService;

    public function __construct()
    {
        $this->carritoService = new CarritoService();
        $this->compraService  = new CompraService();
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

    public function completarCompra(int $userId): void
    {
        $courseIds = $this->carritoService->obtenerCourseIds($userId);

        foreach ($courseIds as $courseId) {
            $this->compraService->asignar($userId, $courseId);
        }

        $this->carritoService->vaciar($userId);
    }
}