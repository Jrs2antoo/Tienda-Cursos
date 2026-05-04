<main class="py-5">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold mb-1">Compras</h1>
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
                            <th class="ps-4" style="min-width:180px;">Usuario</th>
                            <th style="min-width:220px;">Cursos asignados</th>
                            <th class="pe-4" style="min-width:240px;">Asignar curso</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($usuarios as $u):
                            $ids     = $u['curso_ids']     ? explode(',', $u['curso_ids'])     : [];
                            $titulos = $u['curso_titulos'] ? explode('|', $u['curso_titulos']) : [];
                            $asignados = array_combine($ids, $titulos);
                            ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold"><?= htmlspecialchars($u['full_name']) ?></div>
                                    <div class="text-muted small"><?= htmlspecialchars($u['email']) ?></div>
                                </td>
                                <td>
                                    <?php if (empty($asignados)): ?>
                                        <span class="text-muted small fst-italic">Sin cursos</span>
                                    <?php else: ?>
                                        <div class="d-flex flex-column gap-1">
                                            <?php foreach ($asignados as $cid => $ctitulo): ?>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge bg-primary-subtle text-primary">
                                                        <?= htmlspecialchars($ctitulo) ?>
                                                    </span>
                                                    <form method="POST" action="/tiendaCursos/admin/compras/quitar">
                                                        <input type="hidden" name="user_id"   value="<?= $u['id'] ?>">
                                                        <input type="hidden" name="course_id" value="<?= $cid ?>">
                                                        <button type="submit"
                                                                class="btn btn-sm btn-outline-danger py-0 px-1"
                                                                onclick="return confirm('¿Quitar este curso?')"
                                                                title="Quitar">
                                                            <i class="bi bi-x-lg" style="font-size:.7rem;"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="pe-4">
                                    <form method="POST" action="/tiendaCursos/admin/compras/asignar"
                                          class="d-flex gap-2">
                                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                        <select name="course_id" class="form-select form-select-sm">
                                            <option value="">— Selecciona —</option>
                                            <?php foreach ($cursos as $c): ?>
                                                <?php if (!array_key_exists($c->id, $asignados)): ?>
                                                    <option value="<?= $c->id ?>">
                                                        <?= htmlspecialchars($c->title) ?>
                                                    </option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary text-nowrap">
                                            Asignar
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