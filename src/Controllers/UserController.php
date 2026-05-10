<?php
namespace Jrs2a\TiendaCursos\Controllers;

use Jrs2a\TiendaCursos\Core\Pages;
use Jrs2a\TiendaCursos\Middleware\Middleware;
use Jrs2a\TiendaCursos\Requests\UsuarioRequest;
use Jrs2a\TiendaCursos\Services\CompraService;
use Jrs2a\TiendaCursos\Services\UsuarioService;

class UserController
{
    private CompraService  $compraService;
    private UsuarioService $usuarioService;
    private Pages          $pages;

    public function __construct()
    {
        $this->compraService  = new CompraService();
        $this->usuarioService = new UsuarioService();
        $this->pages          = new Pages();
    }

    public function misCursos(): void
    {
        Middleware::requireLogin();
        $courses = $this->compraService->obtenerCursosDeUsuario((int)$_SESSION['user_id']);
        $this->pages->render("Cursos/mis-cursos", compact('courses'));
    }

    public function pedidos(): void
    {
        Middleware::requireLogin();
        $userId  = (int)$_SESSION['user_id'];
        $pedidos = $this->compraService->obtenerCursosDeUsuario($userId);
        $this->pages->render("compras/pedidos", compact('pedidos'));
    }

    public function perfil(): void
    {
        Middleware::requireLogin();
        $userId = (int)$_SESSION['user_id'];
        $user   = $this->usuarioService->obtenerPorId($userId);
        $this->pages->render("perfil/perfil", ['user' => $user, 'errors' => [], 'success' => false]);
    }

    public function actualizarPerfil(): void
    {
        Middleware::requireLogin();
        $userId  = (int)$_SESSION['user_id'];

        // Forzar role = user (el usuario no puede cambiarse el rol)
        $_POST['role'] = $_SESSION['role'] ?? 'user';
        $_POST['id']   = $userId;

        $request = new UsuarioRequest($_POST);

        if (!$request->isValid()) {
            $user = $this->usuarioService->obtenerPorId($userId);
            $this->pages->render("perfil/perfil", [
                'user'    => $user,
                'errors'  => $request->errors,
                'success' => false,
            ]);
            return;
        }

        $ok = $this->usuarioService->actualizar(
            $userId,
            $request->fullName,
            $request->email,
            $_SESSION['role'] ?? 'user',
            $request->password
        );

        if ($ok) {
            // Actualizar datos en sesión
            $_SESSION['full_name'] = $request->fullName;
            $_SESSION['email']     = $request->email;
        }

        $user = $this->usuarioService->obtenerPorId($userId);
        $this->pages->render("perfil/perfil", [
            'user'    => $user,
            'errors'  => [],
            'success' => $ok,
        ]);
    }
}
