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

    public function enviarConfirmacion(): void
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['SMTP_PORT'];
        $mail->Username = $_ENV['SMTP_USER'];
        $mail->Password = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->setFrom('noreply@tiendacursos.com', 'TiendaCursos');
        $mail->addAddress($this->email);
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

        if (!$mail->send()) {
            echo $mail->ErrorInfo;
        }
    }
}