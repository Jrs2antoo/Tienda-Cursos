<?php
namespace Jrs2a\TiendaCursos\Controllers;

use Jrs2a\TiendaCursos\Core\Pages;
use Jrs2a\TiendaCursos\Middleware\Middleware;
use Jrs2a\TiendaCursos\Requests\CursoRequest;
use Jrs2a\TiendaCursos\Requests\UsuarioRequest;
use Jrs2a\TiendaCursos\Services\CompraService;
use Jrs2a\TiendaCursos\Services\CursoService;
use Jrs2a\TiendaCursos\Services\UsuarioService;


class AdminController
{
    private CursoService $cursoService;
    private UsuarioService $usuarioService;
    private CompraService $compraService;

    public function __construct()
    {
        $this->cursoService   = new CursoService();
        $this->usuarioService = new UsuarioService();
        $this->compraService  = new CompraService();
    }

    public function index(): void
    {
        Middleware::requireAdmin();
        Pages::render('admin/menu');
    }

    // Usuarios

    public function usuarios(): void
    {
        Middleware::requireAdmin();
        $usuarios = $this->usuarioService->obtenerTodos();
        Pages::render('admin/usuarios', compact('usuarios'));
    }

    public function editarUsuario(): void
    {
        Middleware::requireAdmin();
        $id = (int)($_GET['id'] ?? 0);
        $usuario = $this->usuarioService->obtenerPorId($id);

        if (!$usuario) {
            header("Location: /tiendaCursos/admin/usuarios");
            exit;
        }

        Pages::render('admin/editar-usuario', compact('usuario'));
    }

    public function actualizarUsuario(): void
    {
        Middleware::requireAdmin();
        $request = new UsuarioRequest($_POST);

        if (!$request->isValid()) {
            // En un proyecto real se pasarían los errores a la vista
            header("Location: /tiendaCursos/admin/usuarios");
            exit;
        }

        $this->usuarioService->actualizar(
            $request->id,
            $request->fullName,
            $request->email,
            $request->role,
            $request->password
        );

        header("Location: /tiendaCursos/admin/usuarios");
        exit;
    }

    public function borrarUsuario(): void
    {
        Middleware::requireAdmin();
        $id = (int)($_POST['id'] ?? 0);

        $this->usuarioService->eliminar($id, (int)$_SESSION['user_id']);

        header("Location: /tiendaCursos/admin/usuarios");
        exit;
    }

    // Cursos

    public function cursos(): void
    {
        Middleware::requireAdmin();
        $courses = $this->cursoService->obtenerTodosAdmin();
        Pages::render('admin/cursos', compact('courses'));
    }

    public function editarCurso(): void
    {
        Middleware::requireAdmin();
        $id    = (int)($_GET['id'] ?? 0);
        $curso = $id ? $this->cursoService->obtenerPorId($id) : null;
        Pages::render('admin/editar-curso', compact('curso'));
    }

    public function actualizarCurso(): void
    {
        Middleware::requireAdmin();
        $request = new CursoRequest($_POST);

        if (!$request->isValid()) {
            header("Location: /tiendaCursos/admin/cursos");
            exit;
        }

        if ($request->id) {
            $this->cursoService->actualizar($request->id, $request->title, $request->description, $request->price, $request->stock, $request->imageUrl);
        } else {
            $this->cursoService->crear($request->title, $request->description, $request->price, $request->stock, $request->imageUrl);
        }

        header("Location: /tiendaCursos/admin/cursos");
        exit;
    }

    public function eliminarCurso(): void
    {
        Middleware::requireAdmin();
        $id    = (int)($_POST['id'] ?? 0);
        $curso = $this->cursoService->obtenerPorId($id);

        if ($curso) {
            if ($curso->activo) {
                $this->cursoService->eliminar($id);       // desactiva
            } else {
                $this->cursoService->reactivar($id);      // vuelve a activar
            }
        }

        header("Location: /tiendaCursos/admin/cursos");
        exit;
    }

    // Compras

    public function compras(): void
    {
        Middleware::requireAdmin();
        $usuarios = $this->usuarioService->obtenerTodosConCursos();
        $cursos   = $this->cursoService->obtenerTodos();
        Pages::render('admin/compras', compact('usuarios', 'cursos'));
    }

    public function asignarCurso(): void
    {
        Middleware::requireAdmin();
        $userId   = (int)($_POST['user_id']   ?? 0);
        $courseId = (int)($_POST['course_id'] ?? 0);
        $this->compraService->asignar($userId, $courseId);
        header("Location: /tiendaCursos/admin/compras");
        exit;
    }

    public function quitarCurso(): void
    {
        Middleware::requireAdmin();
        $userId   = (int)($_POST['user_id']   ?? 0);
        $courseId = (int)($_POST['course_id'] ?? 0);
        $this->compraService->quitar($userId, $courseId);
        header("Location: /tiendaCursos/admin/compras");
        exit;
    }
}