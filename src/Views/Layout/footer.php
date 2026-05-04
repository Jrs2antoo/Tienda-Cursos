<footer class="bg-dark text-white mt-5 pt-5 pb-3">
    <div class="container">
        <div class="row g-4 mb-4">

            <!-- Marca -->
            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-mortarboard-fill text-primary me-2"></i>TiendaCursos
                </h5>
                <p class="text-secondary small">
                    La plataforma de aprendizaje online donde encontrarás los mejores cursos impartidos por expertos del sector.
                </p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-secondary fs-5" title="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="text-secondary fs-5" title="Twitter / X">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                    <a href="#" class="text-secondary fs-5" title="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <a href="#" class="text-secondary fs-5" title="YouTube">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>
            </div>

            <!-- Navegación -->
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-semibold text-uppercase text-secondary small mb-3">Plataforma</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="/tiendaCursos/" class="text-secondary text-decoration-none">Inicio</a></li>
                    <li class="mb-2"><a href="/tiendaCursos/cursos" class="text-secondary text-decoration-none">Todos los cursos</a></li>
                    <li class="mb-2"><a href="/tiendaCursos/contacto" class="text-secondary text-decoration-none">Contacto</a></li>
                </ul>
            </div>

            <!-- Cuenta -->
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-semibold text-uppercase text-secondary small mb-3">Mi cuenta</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="/tiendaCursos/login" class="text-secondary text-decoration-none">Iniciar sesión</a></li>
                    <li class="mb-2"><a href="/tiendaCursos/registro" class="text-secondary text-decoration-none">Registrarse</a></li>
                    <li class="mb-2"><a href="/tiendaCursos/mis-cursos" class="text-secondary text-decoration-none">Mis cursos</a></li>
                    <li class="mb-2"><a href="/tiendaCursos/pedidos" class="text-secondary text-decoration-none">Mis pedidos</a></li>
                </ul>
            </div>

            <!-- Newsletter simple -->
            <div class="col-lg-4 col-md-6">
                <h6 class="fw-semibold text-uppercase text-secondary small mb-3">Mantente al día</h6>
                <p class="text-secondary small">Recibe novedades y ofertas exclusivas directamente en tu email.</p>
                <div class="input-group input-group-sm">
                    <input type="email" class="form-control bg-secondary border-0 text-white"
                           placeholder="tu@email.com">
                    <button class="btn btn-primary px-3" type="button">
                        <i class="bi bi-send"></i>
                    </button>
                </div>
            </div>

        </div>

        <!-- Divisor -->
        <hr class="border-secondary">

        <!-- Copyright -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <p class="text-secondary small mb-0">
                © <?= date('Y') ?> TiendaCursos. Todos los derechos reservados.
            </p>
            <div class="d-flex gap-3">
                <a href="#" class="text-secondary small text-decoration-none">Privacidad</a>
                <a href="#" class="text-secondary small text-decoration-none">Términos</a>
                <a href="#" class="text-secondary small text-decoration-none">Cookies</a>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>