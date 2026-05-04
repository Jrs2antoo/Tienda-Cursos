<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TiendaCursos</title>

    <!-- Icon -->
    <link rel="icon" href="/tiendaCursos/public/img/favicon.ico">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container">

        <!-- LOGO -->
        <a class="navbar-brand fw-bold fs-4" href="/tiendaCursos/">
            <i class="bi bi-mortarboard-fill text-primary me-1"></i>
            Tienda<span>Cursos</span>
        </a>

        <!-- TOGGLER móvil -->
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Menú">
            <i class="bi bi-list fs-3"></i>
        </button>

        <!-- MENÚ -->
        <div class="collapse navbar-collapse" id="navbarMain">

            <!-- Links centrales -->
            <ul class="navbar-nav me-auto ms-3 gap-1">
                <li class="nav-item">
                    <a class="nav-link" href="/tiendaCursos/">
                        <i class="bi bi-house me-1"></i>Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/tiendaCursos/cursos">
                        <i class="bi bi-collection-play me-1"></i>Cursos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/tiendaCursos/contacto">
                        <i class="bi bi-envelope me-1"></i>Contacto
                    </a>
                </li>
            </ul>

            <!-- Derecha -->
            <div class="d-flex align-items-center gap-2">

                <!-- Carrito -->
                <a href="/tiendaCursos/carrito" class="btn btn-outline-secondary btn-carrito position-relative">
                    <i class="bi bi-cart3"></i>
                    <span class="carrito-badge">0</span>
                </a>

                <!-- Usuario logueado / no logueado -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle d-flex align-items-center gap-2"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                            <?= htmlspecialchars($_SESSION['full_name']) ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li>
                                <a class="dropdown-item" href="/tiendaCursos/mis-cursos">
                                    <i class="bi bi-book me-2 text-primary"></i>Mis cursos
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/tiendaCursos/pedidos">
                                    <i class="bi bi-receipt me-2 text-primary"></i>Mis pedidos
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/tiendaCursos/perfil">
                                    <i class="bi bi-gear me-2 text-primary"></i>Mi perfil
                                </a>
                            </li>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="/tiendaCursos/admin">
                                        <i class="bi bi-shield-lock me-2"></i>Panel Admin
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="/tiendaCursos/logout">
                                    <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="/tiendaCursos/login" class="btn btn-outline-primary">Iniciar sesión</a>
                    <a href="/tiendaCursos/registro" class="btn btn-primary">Registrarse</a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</nav>