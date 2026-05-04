<main class="py-5">
    <div class="container">

        <div class="mb-4">
            <h1 class="fw-bold mb-1">
                <i class="bi bi-shield-lock-fill text-primary me-2"></i>Panel de Administración
            </h1>
            <p class="text-muted">Resumen general de usuarios registrados.</p>
        </div>

        <!-- Filtros -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="/tiendaCursos/admin" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Buscar usuario</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" name="user"
                                   placeholder="Nombre o email…"
                                   value="<?= htmlspecialchars($_GET['user'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small">Fecha de registro</label>
                        <input type="date" class="form-control" name="date"
                               value="<?= htmlspecialchars($_GET['date'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small">Curso</label>
                        <input type="text" class="form-control" name="course"
                               placeholder="Nombre del curso…"
                               value="<?= htmlspecialchars($_GET['course'] ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel me-1"></i>Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla -->
        <?php if (empty($users)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-1"></i>No se encontraron usuarios con los filtros aplicados.
            </div>
        <?php else: ?>
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
                                <th>Cursos</th>
                                <th class="pe-4">Fecha registro</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="ps-4 text-muted small">#<?= htmlspecialchars($user['id']) ?></td>
                                    <td class="fw-semibold"><?= htmlspecialchars($user['full_name']) ?></td>
                                    <td class="text-muted small"><?= htmlspecialchars($user['email']) ?></td>
                                    <td>
                                        <?php if ($user['role'] === 'admin'): ?>
                                            <span class="badge bg-danger">Admin</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Usuario</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="small"><?= htmlspecialchars($user['courses'] ?? '—') ?></td>
                                    <td class="pe-4 text-muted small"><?= htmlspecialchars($user['created_at']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</main>