<main class="py-5">
    <div class="container">

        <div class="mb-4">
            <h1 class="fw-bold">Todos los cursos</h1>
            <p class="text-muted">Explora nuestro catálogo completo de formación online.</p>
        </div>

        <?php if (empty($courses)): ?>
            <div class="alert alert-info text-center py-5">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                No hay cursos disponibles por el momento.
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($courses as $course): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0">
                            <?php if (!empty($course->imageUrl)): ?>
                                <img src="/tiendaCursos/public/img/cursos/<?= htmlspecialchars($course->imageUrl) ?>"
                                     class="card-img-top object-fit-cover"
                                     style="height:180px;"
                                     alt="<?= htmlspecialchars($course->title) ?>">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center bg-primary-subtle"
                                     style="height:180px;">
                                    <i class="bi bi-play-circle fs-1 text-primary"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <span class="badge bg-primary-subtle text-primary mb-2 align-self-start">Curso</span>
                                <h5 class="card-title fw-semibold"><?= htmlspecialchars($course->title) ?></h5>
                                <p class="card-text text-muted small flex-grow-1"><?= htmlspecialchars($course->description) ?></p>
                                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                    <span class="fs-5 fw-bold text-primary">
                                        <?= number_format($course->price, 2) ?> €
                                    </span>
                                    <form method="POST" action="/tiendaCursos/carrito/add">
                                        <input type="hidden" name="curso_id" value="<?= $course->id ?>">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="bi bi-cart-plus me-1"></i>Añadir
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</main>