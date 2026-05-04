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

                        <h1 class="fs-3 fw-bold mb-1">Crea tu cuenta 🚀</h1>
                        <p class="text-muted mb-4">Regístrate gratis y empieza a aprender hoy mismo.</p>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger py-2 small">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="/tiendaCursos/registro">

                            <div class="mb-3">
                                <label for="nombre-reg" class="form-label fw-semibold">Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" name="full_name" id="nombre-reg"
                                           placeholder="Tu nombre" required
                                           value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email-reg" class="form-label fw-semibold">Correo electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" name="email" id="email-reg"
                                           placeholder="tu@email.com" required
                                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="pass-reg" class="form-label fw-semibold">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" name="password" id="pass-reg"
                                           placeholder="Mínimo 8 caracteres" required minlength="8">
                                </div>
                            </div>

                            <div class="form-check mb-4">
                                <input type="checkbox" class="form-check-input" id="acepto" name="acepto" required>
                                <label class="form-check-label small" for="acepto">
                                    Acepto los
                                    <a href="#" class="text-primary text-decoration-none">Términos y condiciones</a>
                                    y la
                                    <a href="#" class="text-primary text-decoration-none">Política de privacidad</a>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                Crear cuenta gratis <i class="bi bi-arrow-right ms-1"></i>
                            </button>

                        </form>

                        <p class="text-center text-muted small mt-4 mb-0">
                            ¿Ya tienes cuenta?
                            <a href="/tiendaCursos/login" class="text-primary fw-semibold text-decoration-none">
                                Inicia sesión →
                            </a>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>