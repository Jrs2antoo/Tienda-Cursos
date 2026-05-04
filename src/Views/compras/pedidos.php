<main class="py-5">
    <div class="container">

        <!-- Cabecera -->
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div>
                <h1 class="fw-bold mb-1">Mis pedidos</h1>
                <p class="text-muted mb-0">Historial de todos tus cursos adquiridos</p>
            </div>
            <?php if (!empty($pedidos)): ?>
                <span class="badge bg-primary rounded-pill fs-6 px-3 py-2">
                    <?= count($pedidos) ?> <?= count($pedidos) === 1 ? 'pedido' : 'pedidos' ?>
                </span>
            <?php endif; ?>
        </div>

        <?php if (empty($pedidos)): ?>
            <!-- Sin pedidos -->
            <div class="text-center py-5">
                <div class="d-inline-flex align-items-center justify-content-center bg-warning-subtle rounded-circle mb-4"
                     style="width:100px;height:100px;">
                    <i class="bi bi-receipt fs-1 text-warning"></i>
                </div>
                <h4 class="fw-semibold mb-2">No tienes pedidos aún</h4>
                <p class="text-muted mb-4">Cuando compres algún curso aparecerá aquí.</p>
                <a href="/tiendaCursos/cursos" class="btn btn-primary px-4">
                    <i class="bi bi-search me-2"></i>Ver cursos disponibles
                </a>
            </div>

        <?php else: ?>

            <div class="table-responsive">
                <table class="table align-middle table-hover bg-white shadow-sm rounded overflow-hidden">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Curso</th>
                        <th class="text-end">Precio</th>
                        <th class="text-center">Estado</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($pedidos as $i => $p): ?>
                        <tr>
                            <td class="text-muted small"><?= $i + 1 ?></td>

                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <?php if (!empty($p->imageUrl)): ?>
                                        <img src="/tiendaCursos/public/img/cursos/<?= htmlspecialchars($p->imageUrl) ?>"
                                             class="rounded"
                                             style="width:60px; height:45px; object-fit:cover; display:block;"
                                             alt="">
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center bg-primary-subtle rounded"
                                             style="width:52px;height:40px;">
                                            <i class="bi bi-play-circle text-primary"></i>
                                        </div>
                                    <?php endif; ?>

                                    <span class="fw-semibold"><?= htmlspecialchars($p->title) ?></span>
                                </div>
                            </td>

                            <td class="text-end">
                                <?= number_format($p->price, 2, ',', '.') ?> €
                            </td>

                            <td class="text-center">
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2">
                                    <i class="bi bi-check-circle me-1"></i>Completado
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>

                    <tfoot class="table-light">
                    <tr>
                        <td colspan="2" class="text-end fw-semibold">Total gastado:</td>
                        <td class="text-end fw-bold text-primary fs-5">
                            <?= number_format(array_sum(array_map(fn($p) => $p->price, $pedidos)), 2, ',', '.') ?> €
                        </td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <div class="text-center mt-4">
                <a href="/tiendaCursos/cursos" class="btn btn-outline-primary">
                    <i class="bi bi-plus-lg me-2"></i>Comprar más cursos
                </a>
            </div>

        <?php endif; ?>

    </div>
</main>