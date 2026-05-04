<?php

use Jrs2a\TiendaCursos\Controllers\AuthController;
use Jrs2a\TiendaCursos\Controllers\DashboardController;
use Jrs2a\TiendaCursos\Controllers\HomeController;
use Jrs2a\TiendaCursos\Controllers\CarritoController;
use Jrs2a\TiendaCursos\Controllers\AdminController;
use Jrs2a\TiendaCursos\Controllers\CourseController;
use Jrs2a\TiendaCursos\Controllers\UserController;
use Jrs2a\TiendaCursos\Controllers\ContactoController;
use Jrs2a\TiendaCursos\Controllers\CheckoutController;

$router->get('/', [Jrs2a\TiendaCursos\Controllers\HomeController::class, 'index']);

$router->get('/dashboard', [DashboardController::class, 'index']);

//login
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
//login google
$router->get('/auth/google', [AuthController::class, 'googleLogin']);

//logout
$router->get('/logout', [AuthController::class, 'logout']);

//vista main
$router->get('/', [HomeController::class, 'index']);

//  Contacto
$router->get('/contacto', [ContactoController::class, 'index']);
$router->post('/contacto', [ContactoController::class, 'enviar']);

//Usuario
$router->get('/pedidos', [UserController::class, 'pedidos']);
$router->get('/perfil', [UserController::class, 'perfil']);
$router->post('/perfil', [UserController::class, 'actualizarPerfil']);

//vista cursos
$router->get('/cursos', [CourseController::class, 'index']);
$router->get('/mis-cursos', [UserController::class, 'misCursos']);

//registro
$router->get('/registro', [AuthController::class, 'showRegister']);
$router->post("/registro", [AuthController::class, "register"]);
$router->get("/confirmar-cuenta", [AuthController::class, "confirmarCuenta"]);

//Carrito
$router->get('/carrito', [CarritoController::class, 'index']);
$router->post('/carrito/add', [CarritoController::class, 'add']);
$router->post('/carrito/eliminar', [CarritoController::class, 'eliminar']);

//Admin
$router->get('/admin', [AdminController::class, 'index']);

//Admin usuarios
$router->get('/admin/usuarios', [AdminController::class, 'usuarios']);
$router->get('/admin/usuarios/editar', [AdminController::class, 'editarUsuario']);
$router->post('/admin/usuarios/editar', [AdminController::class, 'actualizarUsuario']);
$router->post('/admin/usuarios/borrar', [AdminController::class, 'borrarUsuario']);

//Admin cursos
$router->get('/admin/cursos', [AdminController::class, 'cursos']);
$router->get('/admin/cursos/editar', [AdminController::class, 'editarCurso']);
$router->post('/admin/cursos/editar', [AdminController::class, 'actualizarCurso']);
$router->post('/admin/cursos/borrar', [AdminController::class, 'eliminarCurso']);

//Admin compras
$router->get('/admin/compras', [AdminController::class, 'compras']);
$router->post('/admin/compras/asignar', [AdminController::class, 'asignarCurso']);
$router->post('/admin/compras/quitar', [AdminController::class, 'quitarCurso']);

//checkout
$router->get("/checkout", [CheckoutController::class, "index"]);
$router->post("/checkout", [CheckoutController::class, "index"]);
$router->post('/checkout/pagar', [CheckoutController::class, 'pagar']);
$router->get('/checkout/exito', [CheckoutController::class, 'exito']);
$router->get('/checkout/cancelado', [CheckoutController::class, 'cancelado']);
