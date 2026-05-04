<?php
namespace Jrs2a\TiendaCursos\Controllers;

use Jrs2a\TiendaCursos\Core\Pages;

class DashboardController {

    public function index() {
        if (!isset($_SESSION['email'])) {
            header("Location: /tiendaCursos/public/login");
            exit;
        }

        Pages::render('Auth/dashboard', [
            'title' => 'Panel de Control',
            'email' => $_SESSION['email']
        ]);
    }
}