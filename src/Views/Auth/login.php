<main class="bg-light py-5 min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-7 col-lg-5">

                <div class="text-center mb-4">
                    <a href="/tiendaCursos/" class="text-decoration-none">
                        <span class="fs-3 fw-bold text-primary">
                            <i class="bi bi-mortarboard-fill me-1"></i>TiendaCursos
                        </span>
                    </a>
                </div>

                <div class="card border-0 shadow">
                    <div class="card-body p-4 p-md-5">

                        <h1 class="fs-3 fw-bold mb-1">Bienvenido de nuevo 👋</h1>
                        <p class="text-muted mb-4">Introduce tus credenciales para acceder a tu cuenta.</p>

                        <?php if (isset($_GET['verified'])): ?>
                            <div class="alert alert-success py-2 small">
                                <i class="bi bi-patch-check-fill me-1"></i>
                                <strong>¡Cuenta verificada!</strong> Tu correo ha sido confirmado correctamente. Ya puedes iniciar sesión.
                            </div>
                        <?php endif; ?>

                        <?php
                        $mensajeSesion     = $_SESSION['mensaje'] ?? '';
                        $mensajeTipoSesion = $_SESSION['mensaje_tipo'] ?? '';
                        unset($_SESSION['mensaje'], $_SESSION['mensaje_tipo']);
                        ?>
                        <?php if (!empty($mensajeSesion)): ?>
                            <?php
                            $alertClass = 'alert-info';
                            $iconClass  = 'bi-envelope-check';
                            if ($mensajeTipoSesion === 'error')   { $alertClass = 'alert-danger';  $iconClass = 'bi-exclamation-triangle'; }
                            if ($mensajeTipoSesion === 'success') { $alertClass = 'alert-success'; $iconClass = 'bi-check-circle'; }
                            ?>
                            <div class="alert <?= $alertClass ?> py-2 small">
                                <i class="bi <?= $iconClass ?> me-1"></i>
                                <?= htmlspecialchars($mensajeSesion) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger py-2 small">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="/tiendaCursos/login">

                            <div class="mb-3">
                                <label for="email-login" class="form-label fw-semibold">Correo electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" name="email" id="email-login"
                                           placeholder="tu@email.com" required
                                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <label for="pass-login" class="form-label fw-semibold mb-0">Contraseña</label>
                                    <a href="#" class="small text-primary text-decoration-none">¿La olvidaste?</a>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" name="password" id="pass-login"
                                           placeholder="••••••••" required>
                                </div>
                            </div>

                            <div class="form-check mb-4">
                                <input type="checkbox" class="form-check-input" id="recuerdame" name="recuerdame">
                                <label class="form-check-label small" for="recuerdame">
                                    Recuérdame en este dispositivo
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                Iniciar sesión <i class="bi bi-arrow-right ms-1"></i>
                            </button>

                            <a href="/tiendaCursos/auth/google" class="btn btn-outline-secondary w-100 py-2 fw-semibold mt-3 d-flex align-items-center justify-content-center gap-2">
                                <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="20" height="20" alt="Google">
                                Iniciar sesión con Google
                            </a>

                        </form>

                        <p class="text-center text-muted small mt-4 mb-0">
                            ¿No tienes cuenta?
                            <a href="/tiendaCursos/registro" class="text-primary fw-semibold text-decoration-none">
                                Regístrate gratis →
                            </a>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>