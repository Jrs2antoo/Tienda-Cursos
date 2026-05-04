<main class="py-5">
    <div class="container">

        <!-- Cabecera -->
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div>
                <h1 class="fw-bold mb-1">Mis cursos</h1>
                <p class="text-muted mb-0">Tu biblioteca de formación personal</p>
            </div>
            <?php if (!empty($courses)): ?>
                <span class="badge bg-primary rounded-pill fs-6 px-3 py-2">
                    <?= count($courses) ?> <?= count($courses) === 1 ? 'curso' : 'cursos' ?>
                </span>
            <?php endif; ?>
        </div>

        <?php if (empty($courses)): ?>
            <!-- Estado vacío -->
            <div class="text-center py-5">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle rounded-circle mb-4"
                     style="width:100px;height:100px;">
                    <i class="bi bi-mortarboard fs-1 text-primary"></i>
                </div>
                <h4 class="fw-semibold mb-2">Aún no tienes cursos</h4>
                <p class="text-muted mb-4">Explora el catálogo y empieza a aprender hoy.</p>
                <a href="/tiendaCursos/cursos" class="btn btn-primary px-4">
                    <i class="bi bi-search me-2"></i>Ver cursos disponibles
                </a>
            </div>

        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($courses as $course): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm overflow-hidden">

                            <!-- Imagen -->
                            <?php if (!empty($course->imageUrl)): ?>
                                <img src="/tiendaCursos/public/img/cursos/<?= htmlspecialchars($course->imageUrl) ?>"
                                     class="card-img-top object-fit-cover"
                                     style="height:190px;"
                                     alt="<?= htmlspecialchars($course->title) ?>">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center bg-primary-subtle"
                                     style="height:190px;">
                                    <i class="bi bi-play-circle fs-1 text-primary"></i>
                                </div>
                            <?php endif; ?>

                            <!-- Badge acceso -->
                            <div class="position-relative">
                                <span class="badge bg-success position-absolute top-0 end-0 m-2">
                                    <i class="bi bi-check-circle me-1"></i>Acceso completo
                                </span>
                            </div>

                            <div class="card-body d-flex flex-column pt-4">
                                <h5 class="fw-semibold mb-2"><?= htmlspecialchars($course->title) ?></h5>
                                <p class="text-muted small flex-grow-1"><?= htmlspecialchars($course->description) ?></p>

                                <div class="mt-3 pt-3 border-top d-flex gap-2">
                                    <a href="#" class="btn btn-primary btn-sm flex-grow-1">
                                        <i class="bi bi-play-fill me-1"></i>Continuar
                                    </a>
                                    <a href="#" class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-award"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pie -->
            <div class="text-center mt-5">
                <a href="/tiendaCursos/cursos" class="btn btn-outline-primary">
                    <i class="bi bi-plus-lg me-2"></i>Añadir más cursos
                </a>
            </div>

        <?php endif; ?>

    </div>
</main>