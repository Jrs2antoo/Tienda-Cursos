<main class="py-5 bg-light min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">

                <!-- Cabecera -->
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle mb-3"
                         style="width:80px;height:80px;">
                        <i class="bi bi-person-fill text-white fs-2"></i>
                    </div>
                    <h1 class="fw-bold mb-1">Mi perfil</h1>
                    <p class="text-muted">Actualiza tu información personal</p>
                </div>

                <!-- Alertas -->
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger rounded-3 mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <ul class="mb-0 ps-3">
                            <?php foreach ($errors as $e): ?>
                                <li><?= htmlspecialchars($e) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <div class="alert alert-success rounded-3 mb-4">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        Perfil actualizado correctamente.
                    </div>
                <?php endif; ?>

                <!-- Formulario -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <form method="POST" action="/tiendaCursos/perfil">

                            <!-- Nombre -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nombre completo</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text"
                                           class="form-control"
                                           name="full_name"
                                           value="<?= htmlspecialchars($user->fullName ?? '') ?>"
                                           required>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email"
                                           class="form-control"
                                           name="email"
                                           value="<?= htmlspecialchars($user->email ?? '') ?>"
                                           required>
                                </div>
                            </div>

                            <hr class="my-4">

                            <p class="text-muted small mb-3">
                                <i class="bi bi-lock me-1"></i>
                                Deja los campos de contraseña en blanco si no quieres cambiarla.
                            </p>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nueva contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                                    <input type="password"
                                           class="form-control"
                                           name="password"
                                           placeholder="Mínimo 8 caracteres"
                                           minlength="8"
                                           autocomplete="new-password">
                                </div>
                            </div>

                            <!-- Rol -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Rol</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-shield"></i></span>
                                    <input type="text"
                                           class="form-control bg-light"
                                           value="<?= htmlspecialchars(ucfirst($user->role ?? 'user')) ?>"
                                           disabled>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary fw-semibold py-2">
                                    <i class="bi bi-save me-2"></i>Guardar cambios
                                </button>
                                <a href="/tiendaCursos/mis-cursos" class="btn btn-outline-secondary">
                                    Cancelar
                                </a>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</main>