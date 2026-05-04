<main class="py-5">
    <div class="container">

        <h1 class="fw-bold mb-1">Tu Carrito</h1>
        <p class="text-muted mb-4">
            <?= count($courses) ?> <?= count($courses) === 1 ? 'curso' : 'cursos' ?> en tu carrito
        </p>

        <?php if (empty($courses)): ?>
            <div class="text-center py-5">
                <i class="bi bi-cart-x fs-1 text-muted d-block mb-3"></i>
                <h5 class="text-muted">Tu carrito está vacío</h5>
                <p class="text-muted small">Explora nuestro catálogo y añade cursos.</p>
                <a href="/tiendaCursos/cursos" class="btn btn-primary mt-2">Ver cursos disponibles</a>
            </div>

        <?php else: ?>
            <div class="row g-4">

                <!-- ITEMS -->
                <div class="col-lg-8">
                    <?php foreach ($courses as $course): ?>
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <div class="d-flex gap-3 align-items-start">
                                    <?php if (!empty($course->imageUrl)): ?>
                                        <img src="/tiendaCursos/public/img/cursos/<?= htmlspecialchars($course->imageUrl) ?>"
                                             class="rounded-3 object-fit-cover flex-shrink-0"
                                             style="width:80px;height:80px;"
                                             alt="<?= htmlspecialchars($course->title) ?>">
                                    <?php else: ?>
                                        <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0 bg-primary-subtle"
                                             style="width:80px;height:80px;">
                                            <i class="bi bi-play-circle fs-1 text-primary"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="flex-grow-1">
                                        <h5 class="fw-semibold mb-1"><?= htmlspecialchars($course->title) ?></h5>
                                        <p class="text-muted small mb-0"><?= htmlspecialchars($course->description) ?></p>
                                    </div>
                                    <div class="text-end flex-shrink-0">
                                        <div class="fs-5 fw-bold text-primary mb-3">
                                            <?= number_format($course->price, 2) ?> €
                                        </div>
                                        <form method="POST" action="/tiendaCursos/carrito/eliminar">
                                            <input type="hidden" name="curso_id" value="<?= $course->id ?>">
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-x-lg me-1"></i>Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <a href="/tiendaCursos/cursos" class="btn btn-outline-secondary">← Seguir comprando</a>
                </div>

                <!-- RESUMEN -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm sticky-top" style="top:80px;">
                        <div class="card-body">
                            <h5 class="fw-bold mb-4">Resumen del pedido</h5>
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted"><?= count($courses) ?> <?= count($courses) === 1 ? 'curso' : 'cursos' ?></span>
                                <span><?= number_format($total, 2) ?> €</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                                <span>Total</span>
                                <span class="text-primary"><?= number_format($total, 2) ?> €</span>
                            </div>
                            <div class="d-grid">
                                <a href ="/tiendaCursos/checkout" class="btn btn-warning fw-semibold py-2">Finalizar compra →</a>
                            </div>
                            <div class="alert alert-success small mt-3 mb-0 py-2">
                                <i class="bi bi-lock-fill me-1"></i>Pago 100% seguro.
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <?php endif; ?>

    </div>
</main>