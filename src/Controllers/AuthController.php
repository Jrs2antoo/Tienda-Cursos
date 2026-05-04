<?php
namespace Jrs2a\TiendaCursos\Controllers;

use Google_Client;
use Jrs2a\TiendaCursos\Core\Email;
use Jrs2a\TiendaCursos\Core\Pages;
use Jrs2a\TiendaCursos\Requests\LoginRequest;
use Jrs2a\TiendaCursos\Requests\RegisterRequest;
use Jrs2a\TiendaCursos\Services\UsuarioService;

class AuthController
{
    private UsuarioService $usuarioService;

    public function __construct()
    {
        $this->usuarioService = new UsuarioService();
    }

    public function showLogin(): void
    {
        Pages::render('Auth/login', ['title' => 'Iniciar sesión']);
    }

    public function login(): void
    {
        $request = new LoginRequest($_POST);

        if (!$request->isValid()) {
            $_SESSION['mensaje']      = implode(' ', $request->errors);
            $_SESSION['mensaje_tipo'] = 'error';
            header("Location: /tiendaCursos/login");
            exit;
        }

        $user = $this->usuarioService->validarLogin($request->email, $request->password);

        if ($user) {
            session_regenerate_id(true);
            $_SESSION['user_id']   = $user->id;
            $_SESSION['email']     = $user->email;
            $_SESSION['full_name'] = $user->fullName;
            $_SESSION['role']      = $user->role;
            header("Location: /tiendaCursos/");
        } else {
            // Comprobar si existe pero no está verificado
            $userSinVerificar = $this->usuarioService->obtenerPorEmail($request->email);
            if ($userSinVerificar && !$userSinVerificar->estaConfirmado()) {
                $_SESSION['mensaje']      = "Tu cuenta aún no está verificada. Revisa tu bandeja de entrada y haz clic en el enlace de confirmación que te enviamos por correo.";
                $_SESSION['mensaje_tipo'] = 'error';
            } else {
                $_SESSION['mensaje']      = "El email o la contraseña no son correctos.";
                $_SESSION['mensaje_tipo'] = 'error';
            }
            header("Location: /tiendaCursos/login");
        }
        exit;
    }

    public function googleLogin(): void
    {
        require_once __DIR__ . '/../../vendor/autoload.php';

        $client = new Google_Client();
        $client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
        $client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
        $client->setRedirectUri('http://localhost/tiendaCursos/callback.php');
        $client->addScope("email");
        $client->addScope("profile");

        header("Location: " . $client->createAuthUrl());
        exit;
    }

    public function logout(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header("Location: /tiendaCursos/login");
        exit;
    }

    public function showRegister(): void
    {
        Pages::render('Auth/register', ['title' => 'Crear una cuenta']);
    }

    public function register(): void
    {
        $request = new RegisterRequest($_POST);

        if (!$request->isValid()) {
            $_SESSION['mensaje']      = implode(' ', $request->errors);
            $_SESSION['mensaje_tipo'] = 'error';
            header("Location: /tiendaCursos/registro");
            exit;
        }

        if ($this->usuarioService->emailExiste($request->email)) {
            $_SESSION['mensaje']      = "Este email ya está registrado.";
            $_SESSION['mensaje_tipo'] = 'error';
            header("Location: /tiendaCursos/registro");
            exit;
        }

        $result = $this->usuarioService->registrar($request->fullName, $request->email, $request->password);

        if ($result['success']) {
            try {
                (new Email($request->email, $request->fullName, $result['token']))->enviarConfirmacion();
                $_SESSION['mensaje']      = "¡Registro exitoso! Revisa tu bandeja de entrada (o la carpeta de spam) y haz clic en el enlace de confirmación para activar tu cuenta.";
                $_SESSION['mensaje_tipo'] = 'info';
            } catch (\Exception $e) {
                $_SESSION['mensaje']      = "Hubo un error al enviar el correo de confirmación.";
                $_SESSION['mensaje_tipo'] = 'error';
            }
            header("Location: /tiendaCursos/login");
        } else {
            $_SESSION['mensaje']      = "Error al registrar.";
            $_SESSION['mensaje_tipo'] = 'error';
            header("Location: /tiendaCursos/registro");
        }
        exit;
    }

    public function confirmarCuenta(): void
    {
        $token = $_GET['token'] ?? '';

        if (empty($token)) {
            die("Token no válido.");
        }

        if ($this->usuarioService->confirmarCuenta($token)) {
            header("Location: /tiendaCursos/login?verified=1");
        } else {
            die("El token es inválido o ha expirado. Vuelve a registrarte.");
        }
        exit;
    }
}
