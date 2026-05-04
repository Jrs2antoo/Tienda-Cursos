<main class="py-5">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold mb-1">Cursos</h1>
                <a href="/tiendaCursos/admin" class="text-muted small text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i>Volver al menú
                </a>
            </div>
            <a href="/tiendaCursos/admin/cursos/editar" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Nuevo curso
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Título</th>
                            <th>Precio</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($courses as $c): ?>
                            <tr>
                                <td class="ps-4 text-muted small">#<?= $c->id ?></td>
                                <td class="fw-semibold"><?= htmlspecialchars($c->title) ?></td>
                                <td class="text-primary fw-semibold"><?= number_format($c->price, 2) ?> €</td>
                                <td class="text-end pe-4">
                                    <a href="/tiendaCursos/admin/cursos/editar?id=<?= $c->id ?>"
                                       class="btn btn-sm btn-outline-primary me-1">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="/tiendaCursos/admin/cursos/borrar" class="d-inline"
                                          onsubmit="return confirm('¿Borrar este curso?')">
                                        <input type="hidden" name="id" value="<?= $c->id ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
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