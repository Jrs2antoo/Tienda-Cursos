<?php
namespace Jrs2a\TiendaCursos\Core;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public string $email;
    public string $nombre;
    public string $token;

    public function __construct(string $email, string $nombre, string $token = '') {
        $this->email  = $email;
        $this->nombre = $nombre;
        $this->token  = $token;
    }

    public function enviarConfirmacion(): void {
        $logFile = __DIR__ . '/../../../smtp_debug.log';

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Port       = 465;
        $mail->Username   = $_ENV['SMTP_USER'];
        $mail->Password   = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Timeout    = 5;

        $mail->SMTPDebug   = 2;
        $mail->Debugoutput = function(string $str, int $level) use ($logFile) {
            file_put_contents($logFile, $str . "\n", FILE_APPEND);
        };

        $mail->setFrom($_ENV['SMTP_USER'], $_ENV['SMTP_NAME']);
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Confirma tu cuenta';
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $enlace = "http://localhost/tiendaCursos/confirmar-cuenta?token=" . $this->token;

        $mail->Body = "
            <h2>Hola, {$this->nombre}!</h2>
            <p>Has creado tu cuenta en TiendaCursos. Solo falta confirmarla:</p>
            <p><a href='{$enlace}'>✅ Confirmar mi cuenta</a></p>
            <p>Si no fuiste tú, ignora este mensaje.</p>
        ";

        $mail->send();

        file_put_contents($logFile, "[" . date('Y-m-d H:i:s') . "] Email enviado correctamente.\n", FILE_APPEND);
    }

    public function enviarContacto(string $asunto, string $mensaje): void {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['SMTP_PORT'];
        $mail->Username = $_ENV['SMTP_USER'];
        $mail->Password = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->setFrom($this->email, $this->nombre);
        $mail->addAddress('contacto@tiendacursos.com', 'TiendaCursos');
        $mail->addReplyTo($this->email, $this->nombre);
        $mail->Subject = 'Contacto: ' . $asunto;
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $mail->Body = "
            <h2>Nuevo mensaje de contacto</h2>
            <p><strong>Nombre:</strong> {$this->nombre}</p>
            <p><strong>Email:</strong> {$this->email}</p>
            <p><strong>Asunto:</strong> {$asunto}</p>
            <hr>
            <p><strong>Mensaje:</strong></p>
            <p>" . nl2br(htmlspecialchars($mensaje)) . "</p>
        ";

        if(!$mail->send()) {
            echo $mail->ErrorInfo;
        }
    }

    /**
     * Envía un email de agradecimiento tras completar una compra.
     *
     * @param Curso[] $cursos  Cursos adquiridos en la compra
     */
    public function enviarCompra(array $cursos): void
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Port       = 465;
        $mail->Username   = $_ENV['SMTP_USER'];
        $mail->Password   = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Timeout    = 5;

        $mail->setFrom($_ENV['SMTP_USER'], $_ENV['SMTP_NAME']);
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Gracias por tu compra en TiendaCursos!';
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $listaCursos = '';
        foreach ($cursos as $c) {
            $listaCursos .= '<li>' . htmlspecialchars($c->title) . '</li>';
        }

        $mail->Body = "
            <h2>Gracias por tu compra, {$this->nombre}!</h2>
            <p>Hemos procesado tu pedido correctamente. Ya puedes acceder a tus cursos:</p>
            <ul>{$listaCursos}</ul>
            <p>Un saludo,<br><strong>El equipo de TiendaCursos</strong></p>
        ";

        try {
            $mail->send();
        } catch (\Throwable $e) {
            error_log('Error enviando email de compra: ' . $e->getMessage());
        }
    }

    /**
     * Envía la factura de compra como adjunto PDF.
     *
     * @param string $pdfBytes  Contenido binario del PDF (salida de FacturaPdf::generar())
     * @param string $filename  Nombre del archivo adjunto, p. ej. "factura-FAC-20240101-0001.pdf"
     */
    public function enviarFactura(string $pdfBytes, string $filename): void
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Port       = 465;
        $mail->Username   = $_ENV['SMTP_USER'];
        $mail->Password   = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Timeout    = 5;

        $mail->setFrom($_ENV['SMTP_USER'], $_ENV['SMTP_NAME']);
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject  = 'Gracias por tu compra! Tu factura de TiendaCursos';
        $mail->isHTML(true);
        $mail->CharSet  = 'UTF-8';

        $mail->Body = "
            <h2>Gracias por tu compra, {$this->nombre}!</h2>
            <p>Hemos procesado tu pedido correctamente. Adjunto encontraras la factura en PDF.</p>
            <p>Ya puedes acceder a tus cursos desde tu panel de usuario.</p>
            <p>Un saludo,<br><strong>El equipo de TiendaCursos</strong></p>
        ";

        $mail->addStringAttachment($pdfBytes, $filename, 'base64', 'application/pdf');

        try {
            $mail->send();
        } catch (\Throwable $e) {
            error_log('Error enviando factura: ' . $e->getMessage());
        }
    }
}