<main class="py-5">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold mb-1">Usuarios</h1>
                <a href="/tiendaCursos/admin" class="text-muted small text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i>Volver al menú
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($usuarios as $u): ?>
                            <tr>
                                <td class="ps-4 text-muted small">#<?= $u->id ?></td>
                                <td class="fw-semibold"><?= htmlspecialchars($u->fullName) ?></td>
                                <td class="text-muted small"><?= htmlspecialchars($u->email) ?></td>
                                <td>
                                    <?php if ($u->role === 'admin'): ?>
                                        <span class="badge bg-danger">Admin</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Usuario</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="/tiendaCursos/admin/usuarios/editar?id=<?= $u->id ?>"
                                       class="btn btn-sm btn-outline-primary me-1">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <?php if ($u->id != $_SESSION['user_id']): ?>
                                        <form method="POST" action="/tiendaCursos/admin/usuarios/borrar" class="d-inline"
                                              onsubmit="return confirm('¿Borrar este usuario?')">
                                            <input type="hidden" name="id" value="<?= $u->id ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>