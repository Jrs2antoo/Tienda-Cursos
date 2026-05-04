<main class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">

                <div class="mb-4">
                    <h1 class="fw-bold mb-1">Editar usuario</h1>
                    <a href="/tiendaCursos/admin/usuarios" class="text-muted small text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i>Volver a usuarios
                    </a>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form method="POST" action="/tiendaCursos/admin/usuarios/editar">
                            <input type="hidden" name="id" value="<?= $usuario->id ?>">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nombre</label>
                                <input type="text" class="form-control" name="full_name"
                                       value="<?= htmlspecialchars($usuario->fullName) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control" name="email"
                                       value="<?= htmlspecialchars($usuario->email) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Rol</label>
                                <select class="form-select" name="role">
                                    <option value="user"  <?= $usuario->role === 'user'  ? 'selected' : '' ?>>
                                        Usuario
                                    </option>
                                    <option value="admin" <?= $usuario->role === 'admin' ? 'selected' : '' ?>>
                                        Administrador
                                    </option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Nueva contraseña</label>
                                <input type="password" class="form-control" name="password"
                                       placeholder="Dejar en blanco para no cambiar">
                                <div class="form-text">Solo rellena este campo si quieres cambiar la contraseña.</div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    Guardar cambios
                                </button>
                                <a href="/tiendaCursos/admin/usuarios" class="btn btn-outline-secondary">
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