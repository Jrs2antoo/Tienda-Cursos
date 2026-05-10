<?php
namespace Jrs2a\TiendaCursos\Core;

use Dompdf\Dompdf;
use Dompdf\Options;

class FacturaPdf
{
    public static function generar(string $nombre, string $email, array $cursos): string
    {
        $fecha    = date('d/m/Y');
        $numero   = 'FAC-' . date('Ymd') . '-' . rand(1000, 9999);
        $total    = array_sum(array_map(fn($c) => $c->price, $cursos));

        $filas = '';
        foreach ($cursos as $c) {
            $filas .= '<tr>
                <td style="padding:8px 12px;border-bottom:1px solid #eee;">' . htmlspecialchars($c->title) . '</td>
                <td style="padding:8px 12px;border-bottom:1px solid #eee;text-align:right;">' . number_format($c->price, 2) . ' EUR</td>
            </tr>';
        }

        $html = '
        <!DOCTYPE html>
        <html>
        <head><meta charset="UTF-8"></head>
        <body style="font-family:Arial,sans-serif;color:#333;margin:0;padding:40px;">

            <table width="100%" style="margin-bottom:30px;">
                <tr>
                    <td>
                        <h1 style="margin:0;color:#4f46e5;font-size:24px;">TiendaCursos</h1>
                        <p style="margin:4px 0;color:#666;font-size:13px;">tu@tiendacursos.com</p>
                    </td>
                    <td style="text-align:right;">
                        <h2 style="margin:0;font-size:20px;">FACTURA</h2>
                        <p style="margin:4px 0;color:#666;font-size:13px;">' . $numero . '</p>
                        <p style="margin:4px 0;color:#666;font-size:13px;">' . $fecha . '</p>
                    </td>
                </tr>
            </table>

            <div style="background:#f8f8f8;padding:16px 20px;border-radius:6px;margin-bottom:30px;">
                <p style="margin:0;font-size:13px;color:#555;">Facturado a:</p>
                <p style="margin:4px 0;font-weight:bold;">' . htmlspecialchars($nombre) . '</p>
                <p style="margin:0;font-size:13px;color:#555;">' . htmlspecialchars($email) . '</p>
            </div>

            <table width="100%" style="border-collapse:collapse;margin-bottom:20px;">
                <thead>
                    <tr style="background:#4f46e5;color:#fff;">
                        <th style="padding:10px 12px;text-align:left;font-size:13px;">Curso</th>
                        <th style="padding:10px 12px;text-align:right;font-size:13px;">Precio</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>

            <table width="100%" style="margin-bottom:40px;">
                <tr>
                    <td></td>
                    <td style="text-align:right;width:200px;">
                        <table width="100%">
                            <tr>
                                <td style="padding:6px 0;font-size:13px;color:#555;">Subtotal:</td>
                                <td style="text-align:right;font-size:13px;">' . number_format($total, 2) . ' EUR</td>
                            </tr>
                            <tr>
                                <td style="padding:6px 0;font-size:13px;color:#555;">IVA (21%):</td>
                                <td style="text-align:right;font-size:13px;">' . number_format($total * 0.21, 2) . ' EUR</td>
                            </tr>
                            <tr style="border-top:2px solid #4f46e5;">
                                <td style="padding:8px 0;font-weight:bold;">TOTAL:</td>
                                <td style="text-align:right;font-weight:bold;color:#4f46e5;">' . number_format($total * 1.21, 2) . ' EUR</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <p style="text-align:center;color:#999;font-size:11px;border-top:1px solid #eee;padding-top:20px;">
                Gracias por confiar en TiendaCursos. Ya puedes acceder a tus cursos desde tu panel de usuario.
            </p>

        </body>
        </html>';

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }
}